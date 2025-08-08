<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use App\Models\TaskBoard\TaskBoardItem;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Actions\Concerns\HasInfolist;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Infolists\Concerns\InteractsWithInfolists;


class TaskBoard extends Component implements HasActions, HasForms
{
    use InteractsWithForms;
    use InteractsWithActions;

    public $newGroupLabel = '';
    public $title = '';
    public $task_name = '';
    public $task_id = '';
    public $firstGroup = null;
    public function mount($task_name, $task_id)
    {
        $this->task_name = $task_name;
        $this->task_id = $task_id;
    }


    public function updateTaskOrder($list)
    {

        foreach ($list as $group) {
            $group_id = $group['value'];
            foreach ($group['items'] as $item) {

                \App\Models\TaskBoard\TaskBoardItem::where('id', $item['value'])->update([
                    'group_id' => $group_id,
                    'order' => $item['order'],
                ]);
            }
        }
    }
    // DELETE TASK ITEM
    public function slideOverDeleteTaskAction()
    {
        return \Filament\Actions\Action::make('slideOverDeleteTask')
            ->label('Delete Task')
            ->icon('heroicon-m-trash')
            ->color(Color::Red)
            ->size('sm')
            ->requiresConfirmation()
            ->iconButton()

            ->action(function ($arguments) {

                \App\Models\TaskBoard\TaskBoardItem::where('id', $arguments['id'])->delete();
                Notification::make()
                    ->title('Deleted successfully')
                    ->success()
                    ->send();
            })
        ;
    }

    // EDIT TASK ITEM
    public function slideOverEditTaskAction()
    {
        return \Filament\Actions\EditAction::make('slideOverEditTask')
            ->record(function ($arguments) {

                return TaskBoardItem::where('id', $arguments['id'])->first();
            })
            ->slideOver()
            ->label('Edit Task')
            ->icon('heroicon-m-pencil')
            ->color(Color::Gray)
            ->size('sm')
            ->mutateRecordDataUsing(function (array $data): array {
                $data['files'] = json_decode($data['files']);
                $data['tags'] = json_decode($data['tags']);

                return $data;
            })
            ->iconButton()
            ->form([
                TextInput::make('title'),
                TagsInput::make('tags'),
                FileUpload::make('files')
                    ->directory("taskitem")
                    ->multiple()
                    ->previewable(false)
                    ->preserveFilenames()
                    ,
                RichEditor::make('description'),

            ])
            ->action(function ($data, $record) {
                $record->update([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'tags' => json_encode($data['tags']),
                    'files' => json_encode($data['files']),
                ]);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
            })
        ;
    }

    // VIEW TASK ITEM
    public function slideOverViewTaskAction()
    {
        return ViewAction::make('slideOverViewTask')
            ->record(function ($arguments) {

                return TaskBoardItem::with(['comments' => fn($q) => $q->with('employeeInfo')])->where('id', $arguments['id'])->first();
            })
            ->modalHeading(fn($arguments) => $arguments['title'])
            ->label('Open Task')
            ->icon('heroicon-m-eye')
            ->color(Color::Blue)
            ->size('sm')
            ->mutateRecordDataUsing(function (array $data): array {
                $data['files'] = json_decode($data['files']);
                $data['tags'] = json_decode($data['tags']);

                return $data;
            })

            ->iconButton()
            ->slideOver()

            ->form([
                Grid::make([
                    'default' => 2,
                    'sm' => 7
                ])
                    ->schema([
                        ViewField::make('rating')
                            ->view('components.assets.task_view')->columnSpan(4)
                            ->registerActions([
                                \Filament\Forms\Components\Actions\Action::make('deleteComment')
                                ->requiresConfirmation()
                                ->label('Delete')
                                ->link()
                                ->color(Color::Red)
                                ->action(function($arguments){
                                    \App\Models\TaskBoard\TaskComment::where('id', $arguments['id'])->delete();
                                    Notification::make()
                                        ->title('Deleted successfully')
                                        ->success()
                                        ->send();
                                }),
                                \Filament\Forms\Components\Actions\Action::make('editComment')

                                    ->link()
                                    ->color(Color::Green)
                                    ->label('Edit')
                                    ->slideOver()
                                    ->form(function($arguments){
                                        $comment = \App\Models\TaskBoard\TaskComment::where('id', $arguments['id'])->first();
                                        return [
                                            RichEditor::make('comment')->default($comment->comment)->required()

                                        ];
                                    })
                                    ->action(function ($data,$arguments) {
                                        $comment = \App\Models\TaskBoard\TaskComment::where('id', $arguments['id'])->update([
                                            'comment' => $data['comment']
                                        ]);
                                        Notification::make()
                                        ->title('Updated successfully')
                                        ->success()
                                        ->send();
                                    }),
                                \Filament\Forms\Components\Actions\Action::make('comment')
                                    ->label('add comment')
                                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                    ->color(Color::Green)
                                    ->button()
                                    ->slideOver()
                                    ->form([
                                        RichEditor::make('comment')->required(),


                                    ])
                                    ->action(function ($data, $record) {

                                        \App\Models\TaskBoard\TaskComment::create([
                                            'comment' => $data['comment'],
                                            'task_id' => $record->id,
                                            'id_number' => Auth::user()->id_number
                                        ]);
                                        Notification::make()
                                            ->title('Saved successfully')
                                            ->success()
                                            ->send();
                                    }),
                            ]),
                        Group::make([
                            FileUpload::make('files')
                                ->label('Attachments')
                                ->deletable(false)
                                ->previewable(false)
                                ->id('taskViewUpload')
                                ->downloadable()
                        ])->columnSpan(3),

                    ])

            ])

            ->modalWidth(MaxWidth::ScreenTwoExtraLarge)

        ;
    }

    // DELETE ITEM COMMENT
    public function slideOverDeleteCommentAction()
    {
        return ViewAction::make('slideOverDeleteComment')
            ->record(function ($arguments) {
                dd($arguments);
                return TaskBoardItem::where('id', $arguments['id'])->first();
            })
            ->label('Edit Task')
            ->icon('heroicon-m-pencil')
            ->color(Color::Gray)
            ->size('sm')
            ->mutateRecordDataUsing(function (array $data): array {
                $data['files'] = json_decode($data['files']);
                $data['tags'] = json_decode($data['tags']);

                return $data;
            })

            ->label('Open Task')
            ->icon('heroicon-m-eye')
            ->color(Color::Blue)
            ->size('sm')


            ->iconButton()
            ->slideOver()
            ->form([
                TextInput::make('dsad')
            ])
            ->modalWidth(MaxWidth::ScreenTwoExtraLarge)

        ;
    }

    // ADD NEW TASK ITEM
    public function slideOverAddTaskAction()
    {
        return \Filament\Actions\Action::make('slideOverAddTask')
            ->label('Add Task')
            ->icon('heroicon-m-plus')
            ->color(Color::Red)
            ->size('sm')
            ->form([
                TextInput::make('title'),

                TagsInput::make('tags'),
                FileUpload::make('files')
                    ->directory("taskitem")
                    ->multiple()
                    ->previewable(false)
                    ->preserveFilenames(),
                RichEditor::make('description'),

            ])
            ->slideOver()
            ->action(function ($data) {

                \App\Models\TaskBoard\TaskBoardItem::create([
                    'group_id' => $this->firstGroup->id,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'tags' => json_encode($data['tags']),
                    'files' => json_encode($data['files']),
                ]);
            })
        ;
    }
    public function render()
    {
        $groups = \App\Models\TaskBoard\TaskBoardGroup::with(['tasks' => function ($q) {
            $q->orderBy('order', 'asc');
        }])->where('task_id', $this->task_id)->get();
        $this->firstGroup = $groups->first();
        return view('livewire.task-board', compact('groups'));
    }
}
