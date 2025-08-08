<?php

namespace App\Livewire\Personnel;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\UserInfo;
use Filament\Forms\Form;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\On;
use Filament\Actions\Action;

use App\Traits\ActivityTrait;
use Livewire\Attributes\Title;
use Filament\Actions\ViewAction;
use Filament\Infolists\Infolist;
use Livewire\Attributes\Computed;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use App\Models\TaskBoard\TaskBoardItem;
use Illuminate\Support\Facades\Request;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Actions\Contracts\HasActions;
use Stevebauman\Location\Facades\Location;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class Home extends Component implements HasActions, HasForms
{

    use InteractsWithActions;
    use InteractsWithForms;
    use ActivityTrait;



    public function mount()
    {


        // $user = \App\Models\User::where('id',Auth::id())->first();
        // $user->givePermissionTo('edit articles');

        exec('php artisan icon:cache');

        $this->dispatch('open-modal', id: 'modal_id');
        // exec('php artisan icon:clear');
        // exec('php artisan optimize:clear');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([



                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Tab 1')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Tab 2')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Tab 3')
                            ->schema([
                                // ...
                            ]),
                    ])
                // ...
            ])
            ->statePath('data');
    }
    #[Computed]
    public function birthDate()
    {
        $user_info = UserInfo::select('birth_date')->where('id_number', Auth::user()->id_number)->first();

        return !!$user_info?->birth_date ? Crypt::decryptString($user_info->birth_date) : null;
    }
    public function tabButton()
    {

        return Action::make('clickme')->icon('heroicon-m-computer-desktop')->outlined();
    }

    public function convertDivision($key)
    {
        $divisionCode = \App\Models\OfficeCode::select('division_code','division_name')->where('division_code',$key)->first();
        return $divisionCode?->division_name;
    }
    public function generate()
    {

        // $usersPerGroup = User::query()
        // ->join('tbl_fd', 'users.fd_code', '=', 'tbl_fd.division_code')
        // ->groupBy('users.fd_code', 'users.name', 'tbl_fd.division_name')
        // ->select('users.fd_code', 'users.name', 'tbl_fd.division_name', DB::raw('count(*) as count'))
        // ->get();
        $usersPerGroup = User::query()
        ->select('name','fd_code')
        ->orderBy('name','asc')
        ->whereHas('userInfo')
        // ->whereHas('skillHobbies')
        // ->whereHas('distinction')
        // ->whereHas('association')
        // ->whereHas('learningAndDevelopment')
        // ->whereHas('voluntaryAndInvolvement')
        ->whereHas('workExperiencefirst')
        // ->whereHas('civilServiceEligibility')
        ->whereHas('familyBackground')
        ->whereHas('educationalBackground')
        ->get()
        ->groupBy('fd_code');
        $var = [];
        foreach($usersPerGroup as $key => $employee)
        {


            $var[$this->convertDivision($key)] = $employee;

        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.personal-data-sheet.assets.employee_complete_pds', ['records' => $var])->setPaper('A4', 'landscape');
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->stream();
                },  'Completed in PDS.pdf');

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

    public function slideOverViewTaskAction()
    {
        return ViewAction::make('slideOverViewTask')
            ->record(function($arguments)
            {

               return TaskBoardItem::where('id', $arguments['id'])->first();
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
                                       \App\Models\TaskBoard\TaskComment::where('id', $arguments['id'])->update([
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
                                ->downloadable()
                        ])->columnSpan(3),

                    ])

            ])
            ->modalWidth(MaxWidth::ScreenTwoExtraLarge)

        ;
    }

    #[Title('Dashboard')]
    public function render(Request $request)
    {
        $now = Carbon::now();
        $start = $now->format('F Y');


        $prevYear = Carbon::now()->subYear()->format('Y');
        $currentYear = Carbon::now()->format('Y');

        $users = \App\Models\User::whereHas('leavePointLatest',function($query){
            $query->whereYear('created_at',Carbon::now());
        })->select('id_number')->get();
        // dd($currentYear);
        $fd_code = User::with('user_fd_code')->where('id_number', Auth::user()->id_number)->first();
        // $groups = \App\Models\TaskBoard\TaskBoardGroup::with(['tasks' => function ($q) {
        //     $q->orderBy('order', 'asc');
        // }])->get();
        $task = \App\Models\TaskBoard\Task::with(['groups'=>function($q){
            $q->with(['tasks' => function ($q) {
                $q->orderBy('order', 'asc');
            }]);
        }])->where('pin', 1)->where('division_name',Auth::user()->fd_code)->first();
        $groups = [];
        if($task)
        {
            $groups = \App\Models\TaskBoard\TaskBoardGroup::with(['tasks' => function ($q) {
                $q->orderBy('order', 'asc');
            }])->where('task_id', $task->id)->get();
        }

        return view('livewire.personnel.home', compact('fd_code','task','groups'));
    }
}
