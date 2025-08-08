<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use App\Enums\RecruitmentLabelEnum;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Request;
use Filament\Notifications\Notification;

trait ApplicantFileUploadTrait{

    public function fileUpload($request, $email, $name,$job,$batch)
    {

        if($request->hasFile($name))
        {
            $randomNumber = rand(100000, 999999);
            $filename = $randomNumber.'.-.'.$request->$name->getClientOriginalName();
            $request->$name->storeAs('public/recruitment/application/'.$job.'/'.$batch.'/'.$email,$filename);
            return $filename;
        }else{
            return null;
        }
    }

    public function allApplicantAttachment($record)
    {
        $record = \App\Models\RecruitmetJobApplication::with(['comments' => function ($q) {
            $q->with('employeeInfo');
        }])->where('id', $record->id)->first();

        return [
            $this->perFile($record->letter_of_intent, 'letter_of_intent_status',  RecruitmentLabelEnum::LETTER_OF_INTENT->value),
            $this->perFile($record->pds, 'pds_status',  RecruitmentLabelEnum::PDS->value),
            $this->perFile($record->prc, 'prc_status',  RecruitmentLabelEnum::PRC->value),
            // $this->perFile($record->eligibility, 'eligibility_status',  RecruitmentLabelEnum::ELIGIBILITY->value),
            $this->perFile($record->tor, 'tor_status',  RecruitmentLabelEnum::TOR->value),
            $this->perFile($record->training_attended, 'training_attended_status',  RecruitmentLabelEnum::TRAINING_ATTENDED->value),
            $this->perFile($record->certificate_of_employment, 'certificate_of_employment_status',  RecruitmentLabelEnum::CERTIFICATE_OF_EMPLOYMENT->value),
            $this->perFile($record->latest_appointment, 'latest_appointment_status',  RecruitmentLabelEnum::LATEST_APPOINTMENT->value),
            $this->perFile($record->performance_rating, 'performance_rating_status',  RecruitmentLabelEnum::PERFORMANCE_RATING->value),
            $this->perFile($record->cav, 'cav_status',  RecruitmentLabelEnum::CAV->value),
            Section::make('MOVS')
                ->label(false)
                ->schema([
                    Grid::make(5)->schema([
                        \Filament\Forms\Components\Actions::make([

                            \Filament\Forms\Components\Actions\Action::make('onprogress')
                                ->badge()
                                ->label(function ($record) {
                                    if ($record->movs_status == 1) {
                                        return 'approved';
                                    } else if ($record->movs_status == 2) {
                                        return 'reject';
                                    }
                                })
                                ->color(function ($record) {
                                    if ($record->movs_status == 1) {
                                        return Color::Green;
                                    } else if ($record->movs_status == 2) {
                                        return Color::Red;
                                    } else if ($record->movs_status == 0) {
                                        return Color::Yellow;
                                    }
                                })
                                ->icon('heroicon-o-arrow-path')
                                ->disabled(),

                        ])->columnSpan(4),
                        \Filament\Forms\Components\Actions::make([
                            \Filament\Forms\Components\Actions\Action::make('movs_status-check')
                                ->iconButton()
                                ->color(Color::Green)
                                ->icon('heroicon-o-check')
                                ->extraAttributes(['title' => 'Approved'])
                                ->action(function ($record) {
                                    \App\Models\ApplicantLog::create([
                                        'activity' => 'Approved by ' . Auth::user()->name,
                                        'message' => RecruitmentLabelEnum::MOVS,
                                        'id_number' => Auth::user()->id_number,
                                        'applicant_id' => $record->id,
                                        'type' => '1'
                                    ]);
                                    $record->update(['movs_status' => 1]);
                                    return $record;
                                }),
                            \Filament\Forms\Components\Actions\Action::make('movs_status-reject')
                                ->iconButton()
                                ->color(Color::Red)
                                ->extraAttributes(['title' => 'Reject'])
                                ->icon('heroicon-o-x-mark')
                                ->action(function ($record) {
                                    \App\Models\ApplicantLog::create([
                                        'activity' => 'Reject by ' . Auth::user()->name,
                                        'message' => RecruitmentLabelEnum::MOVS,
                                        'id_number' => Auth::user()->id_number,
                                        'applicant_id' => $record->id,
                                        'type' => '2'
                                    ]);

                                    $record->update(['movs_status' => 2]);

                                    return $record;
                                }),
                        ])->extraAttributes(['style' => 'width:fit-content;margin-left:auto'])->hidden(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                        $this->perFile($record->awards_recognition, 'awards_recognition_status', RecruitmentLabelEnum::AWARDS_AND_RECOGNITION->value, true),
                        $this->perFile($record->research_innovation, 'research_innovation_status', RecruitmentLabelEnum::RESEARCH_AND_INNOVATION->value, true),
                        $this->perFile($record->membership_in_national, 'membership_in_national_status', RecruitmentLabelEnum::MEMBERSHIP_IN_NATIONAL->value, true),
                        $this->perFile($record->resource_speakership, 'resource_speakership_status', RecruitmentLabelEnum::RESOURCE_AND_SPEAKERSHIP->value, true),
                        $this->perFile($record->application_of_education, 'application_of_education_status', RecruitmentLabelEnum::APPLICATION_OF_EDUCATION->value, true),
                        $this->perFile($record->l_and_d, 'l_and_d_status', RecruitmentLabelEnum::LEARNING_AND_DEVELOPMENT->value, true),

                    ])
                ])->heading(RecruitmentLabelEnum::MOVS->value)->collapsible()->collapsed()
        ];
    }

    public function extraActionsInApplicationTable()
    {
        return [
            Action::make('Not Qualified')

            ->label('Not Qualified')
            ->color(Color::Red)
            ->action(function ($record, $arguments) {
                $data = \App\Models\RecruitmetJobApplication::with(['comments'])->where('application_code', $record->application_code)->first();
                $info = [
                    'position' => $record->jobInfo?->job_title
                ];

                Mail::to($record->email)->queue(new  \App\Mail\Recruitment\NotQualifiedApplicant($record));
                \App\Models\ApplicantLog::create([
                    'activity' => 'Reject by ' . Auth::user()->name,
                    'message' => "Pending => Not Qualified",
                    'id_number' => Auth::user()->id_number,
                    'applicant_id' => $record->id,
                    'type' => '2'
                ]);
                \App\Models\ApplicantLog::create([
                    'activity' => 'Send Email by ' . Auth::user()->name,
                    'message' => 'Disqualified Email',
                    'id_number' => Auth::user()->id_number,
                    'applicant_id' => $record->id,
                    'type' => '10'
                ]);
                $record->update([
                    'application_status' => 4
                ]);
                Notification::make()
                    ->title('Transfer Data successfully')
                    ->success()
                    ->send();
                sleep(1);
                return redirect()->route('recruitment.view_job', ['job_title' => $this->job_title,'batch'=> $this->batch,'job_id' => $this->job_id, 'activeTab' => $this->activeTab, 'tableFilters' => $this->tableFilters]);
//                return redirect()->route('recruitment.application.table', ['job_title' => $this->job_title, 'id' => $this->job_id, 'activeTab' => $this->activeTab]);
            })->disabled(fn($record) => $record->movs_status != 0 && $record->letter_of_intent_status != 0 && $record->pds_status != 0  && $record->prc_status != 0 && $record->tor_status != 0 && $record->training_attended_status != 0 && $record->certificate_of_employment_status != 0 && $record->latest_appointment_status != 0 && $record->performance_rating_status != 0 && $record->cav_status != 0   ? false  : true)
            ->hidden(fn($record) => ($record->eligibilityInfo?->education_status == 4 || $record->eligibilityInfo?->training_status == 4 || $record->eligibilityInfo?->experience_status == 4 || $record->eligibilityInfo?->eligibility_status == 4)  ? false : true),
            Action::make('Approved')
            ->label('Approved')
            ->color(Color::Green)
            ->action(function ($record, $action) {

                if (!!$record->jobOtherInformation?->initial_evaluation)
                {

                    Mail::to($record->email)->queue(new  \App\Mail\Recruitment\QualifiedApplicant($record));
                    \App\Models\ApplicantLog::create([
                        'activity' => 'Approved by ' . Auth::user()->name,
                        'message' =>"Validate => Qualified",
                        'id_number' => Auth::user()->id_number,
                        'applicant_id' => $record->id,
                        'type' => '1'
                    ]);
                    \App\Models\ApplicantLog::create([
                        'activity' => 'Send Email by ' . Auth::user()->name,
                        'message' => 'Qualified Email',
                        'id_number' => Auth::user()->id_number,
                        'applicant_id' => $record->id,
                        'type' => '10'
                    ]);

                    $record->update([
                        'application_status' => 2
                    ]);
                    Notification::make()
                        ->title('Transfer Data successfully')
                        ->success()
                        ->send();
                    sleep(1);
                    return redirect()->route('recruitment.view_job', ['job_title' => $this->job_title,'batch'=> $this->batch,'job_id' => $this->job_id, 'activeTab' => $this->activeTab, 'tableFilters' => $this->tableFilters]);
//                    return redirect()->route('recruitment.application.table', ['job_title' => $this->job_title, 'id' => $this->job_id, 'activeTab' => $this->activeTab, 'tableFilters' => $this->tableFilters]);
                }else{
                    Notification::make()
                        ->title('No date is available for Initial Evaluation Report')
                        ->persistent()
                        ->danger()
                        ->send();
                }
            })->disabled(fn($record) => $record->movs_status != 0 && $record->letter_of_intent_status != 0 && $record->pds_status != 0  && $record->prc_status != 0 && $record->tor_status != 0 && $record->training_attended_status != 0 && $record->certificate_of_employment_status != 0 && $record->latest_appointment_status != 0 && $record->performance_rating_status != 0 && $record->cav_status != 0   ? false  : true)

            ->hidden(fn($record) => ($record->eligibilityInfo?->education_status == 4 || $record->eligibilityInfo?->training_status == 4 || $record->eligibilityInfo?->experience_status == 4 || $record->eligibilityInfo?->eligibility_status == 4) || ($record->eligibilityInfo?->education_status == '' && $record->eligibilityInfo?->training_status == '' && $record->eligibilityInfo?->experience_status == '' && $record->eligibilityInfo?->eligibility_status == '') ? true : false),

        ];
    }

}
