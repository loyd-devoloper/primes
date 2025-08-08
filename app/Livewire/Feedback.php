<?php

namespace App\Livewire;

use Filament\Tables;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\SystemFeedback;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;

use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class Feedback extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public function table(Table $table): Table
    {
        if (Auth::user()->fd_code == '01D') {
            $query = SystemFeedback::query()->with(['employeeInfo','fixBy'])->orderByDesc('id');
        } else {
            $query = SystemFeedback::query()->with(['employeeInfo','fixBy'])->where('id_number', Auth::user()->id_number)->orderByDesc('id');
        }

        return $table
        ->heading('Feedback')
            ->query($query)
            ->headerActions([
                \Filament\Tables\Actions\Action::make('Feedback')
                    ->icon('heroicon-o-plus')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('message')->rules('required')->required(),
                        \Filament\Forms\Components\FileUpload::make('image')->image()->directory('system-feedback'),
                    ])
                    ->action(function ($data) {
                        $data['id_number'] = Auth::user()->id_number;
                        SystemFeedback::create($data);
                        Notification::make()
                            ->title('Submitted successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([

                TextColumn::make('message')->limit('80'),
                ImageColumn::make('image'),
                TextColumn::make('employeeInfo.name')->label('Feedback By'),
                TextColumn::make('fixBy.name'),
                TextColumn::make('status')->badge()
                    ->color(fn( $state) => match ($state) {
                        'PENDING' => Color::Gray,
                        'ONGOING' => Color::Yellow,
                        'FIX' => Color::Green,
                         default => 'gray',
                    }),
                TextColumn::make('created_at')->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('F d, Y h:i:s A')),


            ])
            ->actions([
                EditAction::make()
                    ->color(Color::Green)
                    ->form(([
                        Select::make('status')
                            ->options([
                            'PENDING'=>'PENDING',
                            'ONGOING'=>'ONGOING',
                            'FIX'=>'FIX',
                            ])
                    ]))
                    ->action(function($data,$record){
                        if($data['status'] == "FIX")
                        {
                            $data['fix_by'] = Auth::user()->id_number;
                        }
                        $record->update($data);
                        Notification::make()
                        ->title('Updated successfully')
                        ->success()
                        ->send();
                    })->modalWidth(MaxWidth::Small)
                    ->hidden(fn($record) => Auth::user()->fd_code == '01D' ? false : true),
                ViewAction::make()->form([
                    Placeholder::make('message')
                        ->content(fn($record) => new HtmlString("<p class='dark:text-white'>$record->message</p>")),
                        Placeholder::make('Image')
                        ->content(function ($record): HtmlString {
                           return new HtmlString("<img class='w-full' src= '/storage/" . $record->image . "')>");
                     })->hidden(fn($record) => !!$record->image ? false : true)

                ]),
                DeleteAction::make()->hidden(fn($record) => $record->id_number == Auth::user()->id_number ? false : true)
            ]);
    }
    #[Title('System Feedback')]
    public function render(): View
    {
        return view('livewire.feedback');
    }
}
