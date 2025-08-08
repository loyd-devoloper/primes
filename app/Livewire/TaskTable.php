<?php

namespace App\Livewire;

use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\TaskBoard\Task;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class TaskTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Task::query()->with('groups')->where('division_name', Auth::user()->fd_code))
            ->headerActions([
                Action::make('add')
                    ->form([
                        TextInput::make('name'),
                        Repeater::make('groups')
                            ->schema([
                                TextInput::make('name')->label('Label')->required(),
                                ColorPicker::make('color')->required()->rgb()
                            ])
                            ->columns(2),

                    ])
                    ->action(function ($data) {
                        $task = Task::query()
                            ->create([
                            'name' => $data['name'],
                            'status' => 'PENDING',
                            'id_number' => Auth::user()->id_number,
                            'division_name' => Auth::user()->fd_code,
                        ]);

                        foreach ($data['groups'] as $group) {
                            \App\Models\TaskBoard\TaskBoardGroup::query()
                            ->create([
                                'label' => $group['name'],
                                'color' => $group['color'],
                                'task_id' => $task->id,
                            ]);
                        }
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('status')->badge(),
                CheckboxColumn::make('pin')
                    ->beforeStateUpdated(function ($record, $state) {
                        Task::query()->where('division_name', Auth::user()->fd_code)->update(['pin' => 0]);
                    })
            ])
            ->actions([
                // OPEN TASK ACTION
                ViewAction::make()
                    ->label('open')
                    ->color(Color::Blue)
                    ->url(function ($record) {
                        $slug = str_replace(' ', '-',  $record->name);
                        $slug = strtoupper($slug);
                        return route('task_board', ['task_name' => $slug, 'task_id' => $record->id]);
                    })->extraAttributes(['wire:navigate' => 'true']),
                // EDIT TASK
                EditAction::make()
                    ->color(Color::Green)
                    ->mutateRecordDataUsing(function (array $data,$record): array {
                        $data['groups'] = $record->groups;

                        return $data;
                    })
                    ->form([
                        TextInput::make('name'),
                        Repeater::make('groups')
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                ColorPicker::make('color')->required()->rgb()
                            ])
                            ->columns(2)
                        ->deletable(false)
                    ])
                    ->action(function($data,$record){

                        // update name
                        $record->update([
                            'name' => $data['name'],
                        ]);
                        // UPDATE TASK GROUP
                        foreach ($data['groups'] as $group) {
                            // CHECK IF GROUP IS OLD
                            if (isset($group['id']))
                            {
                                \App\Models\TaskBoard\TaskBoardGroup::query()
                                    ->where('task_id', $group['task_id'])
                                    ->where('id', $group['id'])
                                    ->update([
                                        'label' => $group['label'],
                                        'color' => $group['color'],
                                    ]);
                            }else{
                                \App\Models\TaskBoard\TaskBoardGroup::query()
                                    ->create([
                                        'label' => $group['label'],
                                        'color' => $group['color'],
                                        'task_id' => $record->id,
                                    ]);
                            }
                        }
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                    }),
                // DELETE TASK
                Tables\Actions\DeleteAction::make()
            ]);
    }

    public function render(): View
    {
        return view('livewire.task-table');
    }
}
