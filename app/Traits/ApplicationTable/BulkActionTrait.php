<?php

namespace App\Traits\ApplicationTable;

use Carbon\Carbon;
use Filament\Forms\Get;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;



trait BulkActionTrait
{
    use \App\Traits\RecruitmentPsbTrait;
    public function bulkAction()
    {
        return [
            BulkActionGroup::make([
                // BULK ACTION NA MAG GENERATE NG IER START
                BulkAction::make('report')
                    ->label('Initial Evaluation Result')
                    ->action(function ($records) {
                        $jobInfo = $records->first()?->jobInfo;
                        $templatePath = public_path('/INITIAL EVALUATION RESULT TEMPLATE.xlsx');
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

                        $spreadsheet = $reader->load($templatePath);
                        $sheet = $spreadsheet->getSheet(0);
                        $sheet->setCellValue('B4', 'Position:  ' . $this->job_title);
                        $sheet->setCellValue('B5', 'Plantilla Item Number: ' . $jobInfo->plantilla_item);
                        $sheet->setCellValue('B6', 'SG/Salary per Month: ' . $jobInfo->salary_grade);
                        $sheet->setCellValue('B8', 'Education: ' . $jobInfo->education);
                        $sheet->setCellValue('B9', 'Training:  ' . $jobInfo->training);
                        $sheet->setCellValue('B10', 'Experience:  ' . $jobInfo->experience);
                        $sheet->setCellValue('B11', 'Eligibility:  ' . $jobInfo->eligibility);

                        $styleArray = $sheet->getStyle('A18')->exportArray();
                        $x = 1;
                        $i = 17;
                        foreach ($records as $record) {

                            // education
                            $education = json_decode($record->eligibilityInfo?->education, true);

                            $applicantEduc = [];

                            if (!!$education) {

                                foreach ($education as $educ) {

                                    $applicantEduc[] = $educ;
                                }
                            }
                            $applicantFinal = implode(PHP_EOL . PHP_EOL . PHP_EOL, $applicantEduc);

                            // TRAINING
                            $training = json_decode($record->eligibilityInfo?->training, true);
                            $applicantTraining = [];
                            $applicantTrainingHours = [];

                            if (!!$training) {
                                foreach ($training as $train) {

                                    $applicantTraining[] = $train["title"];
                                    $applicantTrainingHours[] = $train["hours"];
                                }
                            }
                            $applicantFinalTraining = implode(PHP_EOL . PHP_EOL . PHP_EOL, $applicantTraining);
                            $applicantFinalTrainingHours = implode(PHP_EOL . PHP_EOL . PHP_EOL, $applicantTrainingHours);

                            // Experience
                            $experience = json_decode($record->eligibilityInfo?->experience, true);
                            $applicantexperience = [];
                            $applicantexperienceYears = [];

                            if (!!$experience) {
                                foreach ($experience as $exp) {

                                    $applicantexperience[] = $exp["details"];
                                    $applicantexperienceYears[] = $exp["years"];
                                }
                            }
                            $applicantFinalexperience = implode(PHP_EOL . PHP_EOL . PHP_EOL, $applicantexperience);
                            $applicantFinalexperienceYears = implode(PHP_EOL . PHP_EOL . PHP_EOL, $applicantexperienceYears);

                            // ELIGIBILITY
                            $eligibility = json_decode($record->eligibilityInfo?->eligibility, true);
                            $applicantEli = [];

                            if (!!$eligibility) {
                                foreach ($eligibility as $eli) {

                                    $applicantEli[] = $eli;
                                }
                            }
                            $applicantFinalEli = implode(PHP_EOL . PHP_EOL . PHP_EOL, $applicantEli);
                            if ($i > 18) {

                                $sheet->insertNewRowBefore($i);
                                $values = [
                                    $x,
                                    $record->application_code,
                                    "$record->lname, $record->fname $record->mname",
                                    $record->address,
                                    Carbon::parse($record->birthdate)->age,
                                    $record->sex,
                                    $record->civil_status,
                                    !!$record->religion ? $record->religion : 'N/A',
                                    !!$record->disability ? $record->disability : 'N/A',
                                    !!$record->ethnic_group ? $record->ethnic_group : 'N/A',
                                    $record->email,
                                    $record->mobile_number,
                                    !!$applicantFinal ? $applicantFinal : 'None',
                                    !!$applicantFinalTraining ? $applicantFinalTraining : 'None',
                                    $applicantFinalTrainingHours,
                                    !!$applicantFinalexperience ? $applicantFinalexperience : 'None',
                                    $applicantFinalexperienceYears,
                                    !!$applicantFinalEli ? $applicantFinalEli : 'None',
                                    'Qualified'
                                ];
                                $sheet->fromArray($values, null, 'A' . $i);
                                $sheet->getStyle('A' . $i)->applyFromArray($styleArray);
                            } else {
                                $sheet->setCellValue('A' . $i, $x);
                                $sheet->setCellValue('B' . $i, $record->application_code);
                                $sheet->setCellValue('C' . $i, "$record->lname, $record->fname $record->mname");
                                $sheet->setCellValue('D' . $i, $record->address);
                                $sheet->setCellValue('E' . $i, Carbon::parse($record->birthdate)->age);
                                $sheet->setCellValue('F' . $i, $record->sex);
                                $sheet->setCellValue('G' . $i, $record->civil_status);
                                $sheet->setCellValue('H' . $i,  !!$record->religion ? $record->religion : 'N/A');
                                $sheet->setCellValue('I' . $i, !!$record->disability ? $record->disability : 'N/A');
                                $sheet->setCellValue('J' . $i, !!$record->ethnic_group ? $record->ethnic_group : 'N/A');
                                $sheet->setCellValue('K' . $i, $record->email);
                                $sheet->setCellValue('L' . $i, $record->mobile_number);
                                $sheet->setCellValue('M' . $i, !!$applicantFinal ? $applicantFinal : 'None');
                                $sheet->setCellValue('N' . $i, !!$applicantFinalTraining ? $applicantFinalTraining : 'None');
                                $sheet->setCellValue('O' . $i, $applicantFinalTrainingHours);
                                $sheet->setCellValue('P' . $i, !!$applicantFinalexperience ? $applicantFinalexperience : 'None');
                                $sheet->setCellValue('Q' . $i, $applicantFinalexperienceYears);
                                $sheet->setCellValue('R' . $i, !!$applicantFinalEli ? $applicantFinalEli : 'None');
                                $sheet->setCellValue('S' . $i, 'Qualified');
                            }
                            $x++;
                            $i++;
                        }
                        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                        $fileName = $this->job_title . '-' . Carbon::now()->format('Y-m-d') . ".xlsx";
                        $writer->save(storage_path('app/public/' . $fileName));


                        return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
                    })
                    ->hidden($this->activeTab == 'validator' || $this->activeTab == 'qualified' ? false : true)
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-m-arrow-down-on-square')
                    ->color(Color::Blue),
                // BULK ACTION NA MAG GENERATE NG IER END

                // BULK ACTION NA MAGSEND SA APPLICANT NG EMAIL START
                BulkAction::make('send')
                    ->requiresConfirmation()
                    ->form([
                        Select::make('type')->options([
                            'First' => 'Open Ranking',
                            'Reschedule' => 'Open Ranking(Reschedule)',
                        ])->required()->live(),
                        DateTimePicker::make('date')->hidden(fn(Get $get) => $get('type') !== 'Reschedule')->required()
                    ])
                    ->label('Send Open ranking Email')
                    ->action(function ($records, $data) {

                        $first = $records->first();

                        if ($first?->jobOtherInformation?->open_ranking && $first?->jobOtherInformation?->venue) {
                            $date = Carbon::parse($first->jobOtherInformation->open_ranking)->format('M d, Y h:i:s A');
                            $type = $data['type'] == 'First' ? "Open Ranking Email($date)" : "Reschedule of open ranking email($date)";
                            $type2 = $data['type'] == 'First' ? "Open Ranking Email" : "Reschedule of open ranking email";

                            $records->each(function ($record) use ($type, $data, $type2) {

                                if ($data['type'] == 'First') {
                                    Mail::to($record->email)->queue(new \App\Mail\Recruitment\OpenRanking($record,$record?->jobOtherInformation?->open_ranking));
                                } else {

                                    Mail::to($record->email)->queue(new \App\Mail\Recruitment\RescheduleOpenRanking($record,$data['date']));
                                }

                                \App\Models\ApplicantLog::create([
                                    'activity' => 'Send Email by ' . Auth::user()->name,
                                    'message' => $type2,
                                    'id_number' => Auth::user()->id_number,
                                    'applicant_id' => $record->id,
                                    'type' => '10'
                                ]);
                            });
                            Notification::make()
                                ->title('Send an email successfully')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('No date available for Open Ranking or no venue is available')
                                ->actions([
                                    \Filament\Notifications\Actions\Action::make('view')
                                        ->button()
                                        ->url(route('recruitment.jobs')),

                                ])
                                ->persistent()
                                ->danger()
                                ->send();
                        }
                    })
                    ->icon('heroicon-m-envelope')
                    ->hidden($this->activeTab == 'qualified' ? false : true)
                    ->color(Color::Yellow)
                    ->deselectRecordsAfterCompletion(),
                // BULK ACTION NA MAGSEND SA APPLICANT NG EMAIL END

                // BULK ACTION NA MAGSEND SA APPLICANT NG EMAIL START
                BulkAction::make('sendNotificationEmail')
                    ->requiresConfirmation()
                    ->label('Send Notification Letter Email')
                    ->action(function ($records, $data) {

                        $first = $records->first();

                        if (!!$first?->batchInfo?->notification_letter) {
                            $records->each(function ($record) {
                                if($record->application_code == $record?->batchInfo?->hired_applicant_id)
                                {
                                       Mail::to($record->email)->queue(new \App\Mail\Recruitment\NotificationLetter($record));
                                       \App\Models\ApplicantLog::create([
                                        'activity' => 'Send Email by ' . Auth::user()->name,
                                        'message' => "Notification Letter Email",
                                        'id_number' => Auth::user()->id_number,
                                        'applicant_id' => $record->id,
                                        'type' => '10'
                                    ]);
                                }

                            });
                            Notification::make()
                                ->title('Send an email successfully')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('No Notification letter file was found.')

                                ->persistent()
                                ->danger()
                                ->send();
                        }
                    })
                    ->icon('heroicon-m-envelope')
                    ->hidden($this->activeTab == 'qualified' ? false : true)
                    ->color(Color::Yellow)
                    ->deselectRecordsAfterCompletion(),
                // BULK ACTION NA MAGSEND SA APPLICANT NG EMAIL END


                // BULK ACTION NA MAGSEND SA APPLICANT NG EMAIL START
                BulkAction::make('sendCar')
                    ->requiresConfirmation()
                    ->label('Send Car Email')
                    ->action(function ($records, $data) {

                        $first = $records->first();
                        $records->first()->jobOtherInformation?->psbs->each(function ($psb) use($first)  {

                               Mail::to($psb->psbInformation->email)->queue(new \App\Mail\Recruitment\Car($first));
                        });

                        if (!!$first?->batchInfo?->car_file) {
                            $records->each(function ($record) {
//                                if($record->application_code == $record?->batchInfo?->hired_applicant_id)
//                                {
//                                       Mail::to($record->email)->queue(new \App\Mail\Recruitment\NotificationLetter($record));
//                                       \App\Models\ApplicantLog::create([
//                                        'activity' => 'Send Email by ' . Auth::user()->name,
//                                        'message' => "Notification Letter Email",
//                                        'id_number' => Auth::user()->id_number,
//                                        'applicant_id' => $record->id,
//                                        'type' => '10'
//                                    ]);
//                                }
                                Mail::to($record->email)->queue(new \App\Mail\Recruitment\Car($record));
                                \App\Models\ApplicantLog::create([
                                    'activity' => 'Send Email by ' . Auth::user()->name,
                                    'message' => "CAR Email",
                                    'id_number' => Auth::user()->id_number,
                                    'applicant_id' => $record->id,
                                    'type' => '10'
                                ]);
                            });
                            Notification::make()
                                ->title('Send an email successfully')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('No CAR file was found.')

                                ->persistent()
                                ->danger()
                                ->send();
                        }
                    })
                    ->icon('heroicon-m-envelope')
                    ->hidden($this->activeTab == 'qualified' ? false : true)
                    ->color(Color::Yellow)
                    ->deselectRecordsAfterCompletion(),
                // BULK ACTION NA MAGSEND SA APPLICANT NG EMAIL END

                // BULK ACTION NA MAG GENERATE NG APPLICANT DETAILS START
                BulkAction::make('export')
                    ->label('Generate Per Applicant')
                    ->action(function ($records) {
                        $templatePath = public_path('/Applicant_template.xlsx');
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        $spreadsheet = $reader->load($templatePath);
                        $sheet = $spreadsheet->getSheet(0);
                        $styleArray = $sheet->getStyle('A2')->exportArray();

                        $x = 1;
                        $i = 2;
                        foreach ($records as $record) {


                            if ($i > 18) {

                                $sheet->insertNewRowBefore($i);
                                if ($record->application_status == 0) {
                                    $status = 'Pending';
                                } elseif ($record->application_status == 1) {
                                    $status = 'Validate';
                                } elseif ($record->application_status == 2) {
                                    $status = 'Qualified';
                                } elseif ($record->application_status == 4) {
                                    $status = 'Not Qualified';
                                }
                                $values = [
                                    $record->jobInfo?->job_title,
                                    $record->jobInfo?->plantilla_item,
                                    $record->application_code,
                                    $record->fname . ' ' . $record->mname . ' ' . $record->lname,
                                    $record->email,
                                    $record->sex,
                                    !!$record->birthdate ? Carbon::parse($record->birthdate)->format('F d, Y') : '',
                                    $record->mobile_number,
                                    $record->address,
                                    $status,
                                    !!$record->created_at ? Carbon::parse($record->created_at)->format('F d, Y A') : '',

                                ];
                                $sheet->fromArray($values, null, 'A' . $i);
                                $sheet->getStyle('A' . $i)->applyFromArray($styleArray);
                            } else {
                                if ($record->application_status == 0) {
                                    $status = 'Pending';
                                } elseif ($record->application_status == 1) {
                                    $status = 'Validate';
                                } elseif ($record->application_status == 2) {
                                    $status = 'Qualified';
                                } elseif ($record->application_status == 4) {
                                    $status = 'Not Qualified';
                                }
                                $sheet->setCellValue('A' . $i, $record->jobInfo?->job_title);
                                $sheet->setCellValue('B' . $i, $record->jobInfo?->plantilla_item);
                                $sheet->setCellValue('C' . $i, $record->application_code);
                                $sheet->setCellValue('D' . $i,  $record->fname . ' ' . $record->mname . ' ' . $record->lname);
                                $sheet->setCellValue('E' . $i, $record->email);
                                $sheet->setCellValue('F' . $i, $record->sex);
                                $sheet->setCellValue('G' . $i,  !!$record->birthdate ? Carbon::parse($record->birthdate)->format('F d, Y') : '');
                                $sheet->setCellValue('H' . $i, $record->mobile_number);
                                $sheet->setCellValue('I' . $i, $record->address);
                                $sheet->setCellValue('J' . $i, $status);
                                $sheet->setCellValue('K' . $i,  !!$record->created_at ? Carbon::parse($record->created_at)->format('F d, Y h:i:s A') : '');
                            }
                            $x++;
                            $i++;
                        }
                        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
                        $fileName = 'Applicant(' . $this->job_title . '-' . Carbon::now()->format('Y-m-d') . ").xlsx";
                        $writer->save(storage_path('app/public/' . $fileName));


                        return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
                    })->deselectRecordsAfterCompletion()
                    ->color(Color::Red)->icon('heroicon-m-arrow-down-on-square'),
                // BULK ACTION NA MAG GENERATE NG APPLICANT DETAILS END


                BulkAction::make('Car')
                    ->action(function ($records) {

                        return $this->car('with', false, $records);
                    })->deselectRecordsAfterCompletion()
                    ->icon('heroicon-m-arrow-down-on-square')
                    ->color(Color::Green)
                    ->hidden($this->activeTab == 'qualified' ? false : true),
                BulkAction::make('Carw/oname')->label('CAR W/O NAME')

                    ->action(function ($records) {

                        return $this->car('without', false, $records);
                    })->deselectRecordsAfterCompletion()
                    ->icon('heroicon-m-arrow-down-on-square')
                    ->color(Color::Green)
                    ->hidden($this->activeTab == 'qualified' ? false : true),
                BulkAction::make('Carpotential')->label('CAR WITH POTENTIAL')

                    ->action(function ($records) {

                        return $this->car('with', true, $records);
                    })->deselectRecordsAfterCompletion()
                    ->icon('heroicon-m-arrow-down-on-square')
                    ->color(Color::Green)
                    ->hidden($this->activeTab == 'qualified' ? false : true),
                BulkAction::make('Carw/opotential')->label('CAR POTENTIAL W/O NAME')

                    ->action(function ($records) {

                        return $this->car('without', true, $records);
                    })->deselectRecordsAfterCompletion()
                    ->icon('heroicon-m-arrow-down-on-square')
                    ->color(Color::Green)
                    ->hidden($this->activeTab == 'qualified' ? false : true),
                BulkAction::make('wp_potential')->label('WP-POTENTIAL')

                    ->action(function ($records) {

                        return $this->wp_potential($records);
                    })->deselectRecordsAfterCompletion()
                    ->icon('heroicon-m-arrow-down-on-square')
                    ->color(Color::Green)
                    ->hidden($this->activeTab == 'qualified' ? false : true),
            ])->color(Color::Blue)
        ];
    }


    public function car($carType, $potential = false, $records)
    {
        $batch_id = $records->first();
        $plantilla = $batch_id->jobInfo?->plantilla_item;
        $place_of_assignment = $batch_id->jobInfo?->place_of_assignment;
        $place_of_assignmentacronym = Str::acronym($batch_id->jobInfo?->place_of_assignment);


        $templatePath = public_path("/excel/CAR.xlsx");
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($templatePath);
        $car = $spreadsheet->getSheet(0);
        $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::select('job_id', 'batch_id', 'type', 'category')
            ->where('job_id', $this->job_id)
            ->where('batch_id', $batch_id?->batch_id)
            ->first();
        $type = $otherInformation?->type;
        $category = $otherInformation?->category;


        $styleArray = $car->getStyle('A8')->exportArray();
        $educ = $this->educationWeightAllocation($type, $category) . "pts";
        $training = $this->trainingWeightAllocation($type, $category) . "pts";
        $experienceWeightAllocation = $this->experienceWeightAllocation($type, $category) . "pts";
        $performanceWeightAllocation = $this->performanceWeightAllocation($type, $category) . "pts";
        $outstandingAccomplishmentWeightAllocation = $this->outstandingAccomplishmentWeightAllocation($type, $category) . "pts";
        $applicationOfEducationWeightAllocation = $this->applicationOfEducationWeightAllocation($type, $category) . "pts";
        $learningAndDevelopmentWeightAllocation = $this->learningAndDevelopmentWeightAllocation($type, $category) . "pts";
        $potentialWeightAllocation = $this->potentialWeightAllocation($type, $category) . "pts";
        $car->setCellValue('B4',  "Position:   $this->job_title");
        $car->setCellValue('E7',  "Education \n ($educ)");
        $car->setCellValue('F7',  "Training \n ($training)");
        $car->setCellValue('G7',  "Experience \n ($experienceWeightAllocation)");
        $car->setCellValue('H7',  "Performance \n ($performanceWeightAllocation)");
        $car->setCellValue('I7',  "Outstanding Accomplishments \n ($outstandingAccomplishmentWeightAllocation)");
        $car->setCellValue('J7',  "Application of Education \n ($applicationOfEducationWeightAllocation)");
        $car->setCellValue('K7',  "Application of L&D \n ($learningAndDevelopmentWeightAllocation)");
        $car->setCellValue('L7',  "Potential \n ($potentialWeightAllocation)");
        $car->setCellValue('O4',  "$plantilla");
        $car->setCellValue('O5',  Carbon::parse($batch_id?->jobOtherInformation?->open_ranking)->format('Y-m-d h:i:s A'));
        $car->setCellValue('B5',  "Office/Bureau/Service/Unit where the vacancy exists: $place_of_assignment ($place_of_assignmentacronym)");
        $x = 1;
        $i = 8;

        foreach ($records as $applicantData) {

            $applicant = $applicantData?->applicantGrades?->first();
            $count =  $applicantData?->applicantGrades->where('potential_total','!=', null)->where('potential_total','!=', 0)->count();
            if ($count > 0 && $potential == true)
            {
                if($applicant)
                {
                    if ($i > 8) {
                        $car->insertNewRowBefore($i);

                        $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance_total + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;

//                        $total += $potential && $count != 0 ? (float)$applicantData?->applicantGrades->sum('potential_total') / $count : 0;
//                        $potentialVal = $potential && $count != 0 ? (float)$applicantData?->applicantGrades->sum('potential_total') / $count : '0';
                        $weCount = $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->count();
                        $we =  $weCount > 0 ? $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->sum('we') /  $weCount :  $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->sum('we');
                        $wstCount = $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->count();
                        $wst =  $wstCount > 0 ?  $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst') / $wstCount : $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst');
                        $beiCount = $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->count();
                        $bei = $beiCount > 0 ? $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei') / $beiCount : $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei');

//                        $potentialVal = $potential && $count != 0 ? (float)$applicantData?->applicantGrades->sum('potential_total') / $count : 0;
                        $potentialVal = (float)$we + (float)$wst + (float)$bei;
                        $total += $potentialVal;
                        $nameFormtted = "$applicantData?->lname, $applicantData?->fname $applicantData?->mname";
                        $values = [
                            '',
                            $x,
                            $carType == 'with' || $carType == 'withpotential' ? Str::upper($nameFormtted)  : '',
                            $applicant->applicant_id,
                            $applicant->education_total,
                            $applicant->training_total,
                            $applicant->experience_total,
                            $applicant->performance_total,
                            $applicant->outstanding,
                            $applicant->application_of_education,
                            $applicant->l_and_d,
                            $potentialVal,
                            $total
                        ];

                        $car->fromArray($values, null, 'A' . $i);

                        $car->getStyle('A' . $i)->applyFromArray($styleArray);
                    } else {
//                    $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;




                        $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance_total + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;
                        $weCount = $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->count();
                        $we =  $weCount > 0 ? $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->sum('we') /  $weCount :  $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->sum('we');
                        $wstCount = $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->count();
                        $wst =  $wstCount > 0 ?  $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst') / $wstCount : $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst');
                        $beiCount = $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->count();
                        $bei = $beiCount > 0 ? $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei') / $beiCount : $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei');

//                        $potentialVal = $potential && $count != 0 ? (float)$applicantData?->applicantGrades->sum('potential_total') / $count : 0;
                        $potentialVal = (float)$we + (float)$wst + (float)$bei;
                        $total += $potentialVal;

                        $nameFormtted = "$applicantData?->lname, $applicantData?->fname $applicantData?->mname";

                        $car->setCellValue('B' . $i, $x);
                        $car->setCellValue('C' . $i,  $carType == 'with' || $carType == 'withpotential' ? Str::upper($nameFormtted) : '');
                        $car->setCellValue('D' . $i, $applicant?->applicant_id);
                        $car->setCellValue('E' . $i,  $applicant?->education_total);
                        $car->setCellValue('F' . $i, $applicant?->training_total);
                        $car->setCellValue('G' . $i, $applicant?->experience_total);
                        $car->setCellValue('H' . $i,  $applicant?->performance_total);
                        $car->setCellValue('I' . $i, $applicant?->outstanding);
                        $car->setCellValue('J' . $i, $applicant?->application_of_education);
                        $car->setCellValue('K' . $i, $applicant?->l_and_d);
                        $car->setCellValue('L' . $i,  $potentialVal);
                        $car->setCellValue('M' . $i, $total);
                    }
                }
                $x++;
                $i++;
            }
            elseif(($potential == false && $count > 0) || ($potential == false && $count < 1))
            {
                if($applicant)
                {
                    if ($i > 8) {
                        $car->insertNewRowBefore($i);

                        $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance_total + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;
                        $total += $potential && $count != 0 ? (float)$applicantData?->applicantGrades->sum('potential_total') / $count : 0;
                        $potentialVal = $potential && $count != 0 ? (float)$applicantData?->applicantGrades->sum('potential_total') / $count : '0';

                        $nameFormtted = "$applicantData?->lname, $applicantData?->fname $applicantData?->mname";
                        $values = [
                            '',
                            $x,
                            $carType == 'with' || $carType == 'withpotential' ? Str::upper($nameFormtted)  : '',
                            $applicant->applicant_id,
                            $applicant->education_total,
                            $applicant->training_total,
                            $applicant->experience_total,
                            $applicant->performance_total,
                            $applicant->outstanding,
                            $applicant->application_of_education,
                            $applicant->l_and_d,
                            $potentialVal,
                            $total
                        ];

                        $car->fromArray($values, null, 'A' . $i);

                        $car->getStyle('A' . $i)->applyFromArray($styleArray);
                    } else {
//                    $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;
                        $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance_total + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;

                        $potentialVal = $potential && $count != 0 ? (float)$applicantData?->applicantGrades->sum('potential_total') / $count : 0;

                        $total += $potentialVal;

                        $nameFormtted = "$applicantData?->lname, $applicantData?->fname $applicantData?->mname";

                        $car->setCellValue('B' . $i, $x);
                        $car->setCellValue('C' . $i,  $carType == 'with' || $carType == 'withpotential' ? Str::upper($nameFormtted) : '');
                        $car->setCellValue('D' . $i, $applicant?->applicant_id);
                        $car->setCellValue('E' . $i,  $applicant?->education_total);
                        $car->setCellValue('F' . $i, $applicant?->training_total);
                        $car->setCellValue('G' . $i, $applicant?->experience_total);
                        $car->setCellValue('H' . $i,  $applicant?->performance_total);
                        $car->setCellValue('I' . $i, $applicant?->outstanding);
                        $car->setCellValue('J' . $i, $applicant?->application_of_education);
                        $car->setCellValue('K' . $i, $applicant?->l_and_d);
                        $car->setCellValue('L' . $i,  $potentialVal);
                        $car->setCellValue('M' . $i, $total);
                    }
                }
                $x++;
                $i++;
            }


        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = $potential ? "CAR WITH POTENTIAL- $this->job_title.xlsx" : "CAR - $this->job_title.xlsx";
        $writer->save(storage_path('app/public/' . $fileName));

        return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
    }

    public function wp_potential($records)
    {


        $templatePath = public_path("/excel/WP-POTENTIAL.xlsx");
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($templatePath);
        $car = $spreadsheet->getSheet(0);
        $batch_id = $records->first();
        $plantilla = $batch_id->jobInfo?->plantilla_item;
        $place_of_assignment = $batch_id->jobInfo?->place_of_assignment;
        $position = $batch_id->jobInfo?->job_title;
        $openRankingDate = $batch_id->jobOtherInformation?->open_ranking;

        $car->setCellValue('A2', "$position / $place_of_assignment");
        $car->setCellValue('A3', Carbon::parse($openRankingDate)->format('F d, Y h:i:s A'));
        $header = $car->getStyle('D4')->exportArray();
        $label = $car->getStyle('B5')->exportArray();
        $lastRow = $car->getStyle('A6')->exportArray();
        $grade = $car->getStyle('B6')->exportArray();
        $gradeTotal = $car->getStyle('E6')->exportArray();
        $total = $car->getStyle('B7')->exportArray();
        $totalRed = $car->getStyle('E7')->exportArray();
        $totalBold = $car->getStyle('F7')->exportArray();

        $x = 1;
        $i = 4;
        $potential = 6;
        $loopCount = 1;
//        $car->setCellValue('B2', Carbon::now()->format('M d, Y'));
        foreach ($records as $applicantData) {

            $first = true;
            $active = [];
            foreach ($applicantData->assignPsb as $value)
            {
                $active[] = $value->id_number;
            }

            $newApp = \App\Models\RecruitmentPsbGrade::query()->leftJoin('users','recruitment_psb_grades.id_number','=','users.id_number')
                ->orderBy('users.name')
                ->where('recruitment_psb_grades.applicant_id',$applicantData?->application_code)->whereIn('recruitment_psb_grades.id_number',$active)->get();


            foreach ($newApp as $key => $applicant) {


                if ($loopCount == 1) {
                    if ($potential > 6) {
                        $car->insertNewRowBefore($potential);


                        $values = [
                            Str::acronym($applicant?->psbInfo?->name),
                            $applicant?->we,
                            $applicant?->wst,
                            $applicant?->bei,
                            (float)$applicant?->we + (float)$applicant?->wst + (float)$applicant?->bei
                        ];

                        $car->fromArray($values, null, 'A' . $potential);
                        $car->getStyle("A$potential")->applyFromArray($lastRow);
                        if ($applicantData?->applicantGrades->last() === $applicant) {

                            $potential++;
                            $weCount = $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->count();
                            $we =  $weCount > 0 ? $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->sum('we') /  $weCount :  $applicantData?->applicantGrades?->where('we', '!=', null)->where('we', '!=', 0)->sum('we');
                            $wstCount = $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->count();
                            $wst =  $wstCount > 0 ?  $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst') / $wstCount : $applicantData?->applicantGrades?->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst');
                            $beiCount = $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->count();
                            $bei = $beiCount > 0 ? $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei') / $beiCount : $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei');
                            $car->setCellValue('B' . $potential, $we);
                            $car->setCellValue('C' . $potential, $wst);
                            $car->setCellValue('D' . $potential, $bei);
                            $car->setCellValue('E' . $potential, (float)$we + (float)$wst + (float)$bei);
                        }
                    }
                    else {

                        $car->setCellValue('A' . $potential, Str::acronym($applicant?->psbInfo?->name));
                        $car->setCellValue('D' . $i, $applicant->applicant_id);
                        $car->setCellValue('B' . $potential, $applicant?->we);
                        $car->setCellValue('C' . $potential, $applicant?->wst);
                        $car->setCellValue('D' . $potential, $applicant?->bei);
                        $car->setCellValue('E' . $potential, (float)$applicant?->we + (float)$applicant?->wst + (float)$applicant?->bei);
                        if ($applicantData?->applicantGrades->last() === $applicant) {

                            $potential++;
//                            $we =  $applicantData?->applicantGrades?->where('we', '!=', null)->sum('we');
//                            $wst =   $applicantData?->applicantGrades?->where('wst', '!=', null)->sum('wst');
//                            $beiCount = $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->count();
//                            $bei = $applicantData?->applicantGrades?->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei') / $beiCount;
                            $weCount = $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('we', '!=', null)->where('we', '!=', 0)->count();
                            $we =  $weCount > 0 ? $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('we', '!=', null)->where('we', '!=', 0)->sum('we') /  $weCount :  $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('we', '!=', null)->where('we', '!=', 0)->sum('we');
                            $wstCount = $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('wst', '!=', null)->where('wst', '!=', 0)->count();
                            $wst =  $wstCount > 0 ?  $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst') / $wstCount : $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst');
                            $beiCount = $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('bei', '!=', null)->where('bei', '!=', 0)->count();
                            $bei = $beiCount > 0 ? $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei') / $beiCount : $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei');
                            $car->setCellValue('B' . $potential, $we);
                            $car->setCellValue('C' . $potential, $wst);
                            $car->setCellValue('D' . $potential, $bei);
                            $car->setCellValue('E' . $potential, (float)$we + (float)$wst + (float)$bei);
                        }
                    }
                    $potential++;
                } else {
                    if ($first) {
                        $potential += 2;
                        $car->insertNewRowBefore($potential);
                        $values = [
                            '',
                            '',
                            '',
                            $applicant->applicant_id,
                            ''
                        ];

                        $car->fromArray($values, null, "A$potential");

                        $car->getStyle("A$potential:E$potential")->applyFromArray($header);

                        $potential++;
                        $labelData = [
                            '',
                            'WE',
                            'WST',
                            'BEI',

                        ];
                        $car->insertNewRowBefore($potential);
                        $car->fromArray($labelData, null, 'A' . $potential);
                        $car->getStyle("A$potential:E$potential")->applyFromArray($label);


                        $first = false;
                    }
                    $potential++;
                    $car->insertNewRowBefore($potential);


                    $values = [
                        Str::acronym($applicant?->psbInfo?->name),
                        $applicant?->we,
                        $applicant?->wst,
                        $applicant?->bei,
                        (float)$applicant?->we + (float)$applicant?->wst + (float)$applicant?->bei
                    ];

                    $car->fromArray($values, null, 'A' . $potential);
                    $car->getStyle("A$potential")->applyFromArray($lastRow);
                    $car->getStyle("B$potential:D$potential")->applyFromArray($grade);
                    $car->getStyle("E$potential")->applyFromArray($gradeTotal);
                    if ($applicantData?->applicantGrades->last() === $applicant) {
                        $potential++;
                        $car->insertNewRowBefore($potential);
//                        $we =  $applicantData?->applicantGrades?->where('we', '!=', null)->sum('we');
//                        $wst =   $applicantData?->applicantGrades?->where('wst', '!=', null)->sum('wst');
//                        $bei = $applicantData?->applicantGrades?->where('bei', '!=', null)->sum('bei');
                        $weCount = $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('we', '!=', null)->where('we', '!=', 0)->count();
                        $we =  $weCount > 0 ? $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('we', '!=', null)->where('we', '!=', 0)->sum('we') /  $weCount :  $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('we', '!=', null)->where('we', '!=', 0)->sum('we');
                        $wstCount = $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('wst', '!=', null)->where('wst', '!=', 0)->count();
                        $wst =  $wstCount > 0 ?  $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst') / $wstCount : $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('wst', '!=', null)->where('wst', '!=', 0)->sum('wst');
                        $beiCount = $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('bei', '!=', null)->where('bei', '!=', 0)->count();
                        $bei = $beiCount > 0 ? $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei') / $beiCount : $applicantData?->applicantGrades?->whereIn('id_number',$active)->where('bei', '!=', null)->where('bei', '!=', 0)->sum('bei');
                        $car->setCellValue('B' . $potential, $we);
                        $car->setCellValue('C' . $potential, $wst);
                        $car->setCellValue('D' . $potential, $bei);
                        $car->setCellValue('E' . $potential, (float)$we + (float)$wst + (float)$bei);
                        $car->setCellValue('F' . $potential, 'Final Score');
                        $car->getStyle("B$potential:D$potential")->applyFromArray($total);
                        $car->getStyle("E$potential")->applyFromArray($totalRed);
                        $car->getStyle("F$potential")->applyFromArray($totalBold);
                    }
                }
            }
            $loopCount++;
            $potential++;
            $x++;
            // $i++;
        }


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = "WP-POTENTIAL - $this->job_title.xlsx";
        $writer->save(storage_path('app/public/' . $fileName));
        return response()->download(storage_path('app/public/' . $fileName));
    }
}
