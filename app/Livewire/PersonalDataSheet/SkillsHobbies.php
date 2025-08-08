<?php

namespace App\Livewire\PersonalDataSheet;

use Livewire\Component;
use App\Models\SkillHobbies;
use Filament\Actions\Action;

use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;

use Illuminate\Support\Facades\DB;

use Filament\Forms\Components\Grid;

use Filament\Support\Enums\MaxWidth;

use Illuminate\Support\Facades\Auth;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Contracts\HasForms;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

use Filament\Forms\Components\DatePicker;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\SkillHobbies as ModelSkillHobbies;
use Filament\Actions\Concerns\InteractsWithActions;

class SkillsHobbies extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    public function modalFormAction()
    {
        return   Action::make('modalForm')
            ->label('Add')
            ->icon('heroicon-o-plus')
            ->modalHeading('Add Special Skill')
            ->form([

                    Select::make('type')->label(' Type of Skills ')->options([
                        'Active listening' => 'Active listening',
                        'Communication' => 'Communication',
                        "Computer skills" => "Computer skills",
                        "Customer service" => "Customer service",
                        "Interpersonal skills" => "Interpersonal skills",
                        "Leadership" => "Leadership",
                        "Management skills" => "Management skills",
                        "Problem-solving" => "Problem-solving",
                        "Time management" => "Time management",
                        "Transferable skills" => "Transferable skills",
                        "Sports" => "Sports",
                        "Others" => "Others",
                    ])->required(),
                    TextInput::make('skills_hobbies')->label(' SPECIAL SKILLS and HOBBIES  ')->required(),




            ])

            ->action(function (array $data) {
                ModelSkillHobbies::create([
                        'id_number' => Auth::user()->id_number,
                        'type' => $data['type'],
                        'skills_hobbies' => $data['skills_hobbies'],


                    ]);

                    sleep(1);
                Notification::make()
                    ->title('Saved successfully')
                    ->success()
                    ->send();
            })->modalWidth(MaxWidth::Large);
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
                $skill =ModelSkillHobbies::where('id', $arguments['license_id'])->first();
                return [


                    'type' => $skill->type,
                    'skills_hobbies' =>$skill->skills_hobbies,
                    'recognition' =>$skill->recognition,
                    'membership_organization' =>$skill->membership_organization,
                ];
            })
            ->form([
                Select::make('type')->label(' Type of Skills ')->options([
                    'Active listening' => 'Active listening',
                    'Communication' => 'Communication',
                    "Computer skills" => "Computer skills",
                    "Customer service" => "Customer service",
                    "Interpersonal skills" => "Interpersonal skills",
                    "Leadership" => "Leadership",
                    "Management skills" => "Management skills",
                    "Problem-solving" => "Problem-solving",
                    "Time management" => "Time management",
                    "Transferable skills" => "Transferable skills",
                    "Sports" => "Sports",
                    "Others" => "Others",
                ])->required(),
                TextInput::make('skills_hobbies')->label(' SPECIAL SKILLS and HOBBIES  ')->required(),


            ])
            ->action(function ($data,$arguments) {
                ModelSkillHobbies::where('id', $arguments['license_id'])->update([
                    'id_number' => Auth::user()->id_number,
                        'type' => $data['type'],
                        'skills_hobbies' => $data['skills_hobbies'],


                ]);

                sleep(1);
                Notification::make()
                ->title('Updated successfully')
                ->success()
                ->send();
            })->modalSubmitActionLabel('Update')->modalWidth(MaxWidth::Large);
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
                ModelSkillHobbies::where('id', $arguments['license_id'])->delete();

                sleep(1);
                Notification::make()
                    ->title('Deleted successfully')
                    ->success()
                    ->send();
            });
    }
    #[Title('Skills & Hobbies')]

    public function render()
    {

        $skills = ModelSkillHobbies::where('id_number',Auth::user()->id_number)->latest()->get();

        $count = $skills->count();
        return view('livewire.personal-data-sheet.skills-hobbies',compact('skills','count'));
    }
}
