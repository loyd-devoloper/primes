<?php

namespace App\Livewire\PersonalDataSheet;

use Livewire\Component;
use Filament\Tables\Table;


use Filament\Actions\Action;

use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;

use Illuminate\Support\Facades\DB;

use Filament\Forms\Components\Grid;

use Illuminate\Support\Facades\Auth;

use Filament\Forms\Components\Select;

use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Contracts\HasForms;

use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Actions\Contracts\HasActions;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\Eligibility as ModelsEligibility;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class Eligibility extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;





    public function modalFormAction()
    {
        return   Action::make('modalForm')
            ->label('Add License ')
            ->icon('heroicon-o-plus')
            ->modalHeading('Add License')
            ->form([
                Grid::make()->schema([
                    Select::make('type')->label(' Type of Eligibily ')->options([
                        'Civil Service' => 'Civil Service',
                        'Professional Regulation Commission' => 'Professional Regulation Commission',
                        "LTO - Driver's License" => "LTO - Driver's License",
                        "Supreme Court" => "Supreme Court",
                        "Other License" => "Other License",
                    ])->required(),
                    TextInput::make('license_title')->label(' Eligibility Title ')->required(),
                    TextInput::make('rating')->label('Rating')->numeric(),
                    DatePicker::make('date_examination')->label('Date Acquired '),
                    TextInput::make('place_examination')->label(' Place of Conferment  '),
                    TextInput::make('license_number')->label('  License Number   ')->required(),

                    DatePicker::make('date_validity')->label(' Date of Validity ')
                ])

            ])

            ->action(function (array $data) {
                ModelsEligibility::create([
                        'id_number' => Auth::user()->id_number,
                        'type' => $data['type'],
                        'license_title' => $data['license_title'],
                        'date_examination' => $data['date_examination'],
                        'place_examination' => $data['place_examination'],
                        'license_number' => $data['license_number'],
                        'date_validity' => $data['date_validity'],
                        'rating' => $data['rating'],
                    ]);

                    sleep(1);
                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            });
    }
    public function buttonAction(): Action
    {

        return Action::make('button')
            ->icon('heroicon-o-pencil-square')
            ->label('Edit')
            ->modalHeading('Edit License')
            ->badge()->outlined()
            ->color(Color::Green)
            ->fillForm(function ($arguments) {
                $license = ModelsEligibility::where('id', $arguments['license_id'])->first();
                return [
                    'type' => $license->type,
                    'license_title' => $license->license_title,
                    'rating' => $license->rating,
                    'date_examination' => $license->date_examination,
                    'place_examination' => $license->place_examination,
                    'license_number' => $license->license_number,
                    'date_validity' => $license->date_validity,
                ];
            })
            ->form([
                Grid::make()->schema([
                    Select::make('type')->label(' Type of Eligibily ')->options([
                        'Civil Service' => 'Civil Service',
                        'Professional Regulation Commission' => 'Professional Regulation Commission',
                        "LTO - Driver's License" => "LTO - Driver's License",
                        "Supreme Court" => "Supreme Court",
                        "Other License" => "Other License",
                    ])->required(),
                    TextInput::make('license_title')->label(' Eligibility Title ')->required(),
                    TextInput::make('rating')->label('Rating')->numeric(),
                    DatePicker::make('date_examination')->label('Date Acquired '),
                    TextInput::make('place_examination')->label(' Place of Conferment  '),
                    TextInput::make('license_number')->label('  License Number   ')->required(),

                    DatePicker::make('date_validity')->label(' Date of Validity ')
                ])
            ])
            ->action(function ($data,$arguments) {
                ModelsEligibility::where('id', $arguments['license_id'])->update([
                    'type' => $data['type'],
                    'license_title' => $data['license_title'],
                    'date_examination' => $data['date_examination'],
                    'place_examination' => $data['place_examination'],
                    'license_number' => $data['license_number'],
                    'date_validity' => $data['date_validity'],
                    'rating' => $data['rating'],
                ]);

                sleep(1);
                Notification::make()
                ->title('Updated successfully')
                ->success()
                ->send();
            })->modalSubmitActionLabel('Update');
    }

    public function confirmationModalAction(): Action
    {
        return Action::make('confirmationModal')
            ->label('Delete')
            ->color('danger')
            ->icon('heroicon-o-trash')
            ->requiresConfirmation()
            ->badge()->outlined()
            ->action(function ($arguments) {
                ModelsEligibility::where('id', $arguments['license_id'])->delete();
                sleep(1);

                Notification::make()
                    ->title('Deleted successfully')
                    ->success()
                    ->send();
            });
    }
    #[Title('Eligibility')]

    public function render()
    {
        $licenses=  ModelsEligibility::where('id_number', Auth::user()->id_number)->get();
        $count = $licenses->count();

        return view('livewire.personal-data-sheet.eligibility', compact('licenses','count'));
    }
}
