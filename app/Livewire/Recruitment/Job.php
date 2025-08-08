<?php

namespace App\Livewire\Recruitment;

use Carbon\Carbon;
use App\Models\User;
use Filament\Forms\Get;
use Filament\Tables\Enums\ActionsPosition;

use Filament\Tables\Enums\FiltersLayout;
use Livewire\Component;
use Filament\Tables\Table;

use Illuminate\Support\Str;

use Livewire\Attributes\Title;
use App\Models\Recruitment_Job;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;

use Filament\Support\Enums\MaxWidth;

use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;

use Filament\Forms\Components\Fieldset;

use Filament\Tables\Actions\EditAction;

use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;

use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;


use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;

use Filament\Actions\Contracts\HasActions;


use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class Job extends Component implements HasForms, HasTable, HasActions
{

    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public $options = [];

    public function table(Table $table): Table
    {

        return $table
            ->query(Recruitment_Job::with(['batchInfo' => function ($q) {
                $q->where('status', 1)->with(['hiredInfo' => function ($q) {
                    $q->select('fname', 'mname', 'lname', 'application_code');
                }]);
            }])->withCount(['allApplicant']))
            ->heading('JOB APPLICATION')
            ->headerActions([
                $this->headerAddAction()
            ])
            ->columns([
//                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('job_title')->label('Position Title')->searchable()->sortable(),
//                TextColumn::make('applicants')->label('No. of Applicant')->state(fn($record) => $record->all_applicant_count)->badge()->color(Color::Yellow)->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('batchInfo')->label('Batch')->formatStateUsing(fn($state) => $state->batch_name),
                TextColumn::make('plantilla_item')->searchable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('place_of_assignment')->searchable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('status_of_hiring')->boolean()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('status_of_appointment')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('batchInfo.posting_date')->label('Posting Date')->formatStateUsing(fn($state) => !!$state ? Carbon::parse($state)->format('M d, Y h:i:s A') : null)->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('closing_date')->label('Closing Date')->toggleable(isToggledHiddenByDefault: false)->state(fn($record) => Carbon::parse($record->batchInfo?->closing_date)->format('M d, Y h:i:s A')),


            ])
            ->filters([

                SelectFilter::make('status_of_appointment')
                    ->options([
                        'Permanent' => 'Permanent',
                        'Contractual' => 'Contractual',
                        'Contract of Service' => 'Contract of Service',
                        'Job Order' => 'Job Order',
                    ]),
                SelectFilter::make('status_of_hiring')
                    ->options([
                        '1' => 'Open',
                        '0' => 'Close',
                    ]),
                Filter::make('created_ats')->form([
                    DatePicker::make('posting_date')->label('Posting Date'),
                ])->query(function ($query, array $data) {
                    return $query
                        ->when(
                            $data['posting_date'],
                            fn($query, $date) => $query->whereHas('batchInfo', function ($q) use ($date) {
                                $q->whereDate('posting_date', $date);
                            }),
                        );
                }),
            ])
            ->filtersFormWidth(MaxWidth::Large)
            ->deferFilters()
            ->deferLoading()
            ->deselectAllRecordsWhenFiltered(false)
            ->actions([
                ViewAction::make()
                    ->label( fn($record) => new HtmlString("Job Information <span class='shrink-0 rounded-full bg-red-500 px-2 font-mono text-md font-medium tracking-tight text-white'>$record->all_applicant_count</span>"))
                    ->icon('heroicon-m-information-circle')
//                    ->badge()
                    ->color(Color::Gray)
                    ->url(function ($record) {
                        $slug = str_replace(' ', '-', $record->job_title);
                        $slug = strtoupper($slug);
                        return route('recruitment.view_job', ['job_title' => $slug, 'job_id' => $record->job_id, 'batch' => $record?->batchInfo?->batch_id]);
                    })->extraAttributes(['wire:navigate' => 'true']),
//               ActionGroup::make([
//                     //############################ View job information button ###############################################
//                     ViewAction::make()->label('View Job Information')
//                     ->icon('heroicon-m-information-circle')
//                     ->url(function($record){
//                        $slug = str_replace(' ', '-',  $record->job_title);
//                        $slug = strtoupper($slug);
//                        return route('recruitment.view_job', ['job_title' => $slug , 'job_id' => $record->job_id,'batch'=>$record?->batchInfo?->batch_id]);
//                    })->extraAttributes(['wire:navigate' => 'true']),
//
//                    //############################ View button ###############################################
//                    ViewAction::make()->label('View Applicants')->url(function($record){
//                        $slug = str_replace(' ', '-',  $record->job_title);
//                        $slug = strtoupper($slug);
//                        return route('recruitment.application.table', ['job_title' => $slug , 'id' => $record->job_id]);
//                    })
//                    ->hidden(function(){
//                        if(Auth::user()->can('RECRUITMENT')) return false;
//                        if(Auth::user()->can('RECRUITMENT VIEW')) return true;
//
//                    })
//                    ->extraAttributes(['wire:navigate' => 'true']),
//
//                    //############################ Update button ###############################################
//                    EditAction::make()
//                        ->label('Update ')
//                        ->modalHeading(fn($record) => "Update - $record->job_title")
//                        ->mutateRecordDataUsing(function (array $data, $record): array {
//
//                            $data['batch'] = $record->batchInfo?->batch_name;
//                            $data['closing_date'] = $record->batchInfo?->closing_date;
//                            $data['posting_date'] = $record->batchInfo?->posting_date;
//                            // $data['status_of_hiring'] = $record->batchInfo?->status;
//
//                            return $data;
//                        })
//                        ->form([
//
//                            Fieldset::make('Basic Information of the Position')
//                                ->schema([
//                                    Grid::make([
//                                        'default' => 1,
//                                        'sm' => 2
//                                    ])->schema([
//                                        Select::make('status_of_appointment')->options([
//                                            'Permanent' => 'Permanent',
//                                            'Contractual' => 'Contractual',
//                                            'Contract of Service' => 'Contract of Service',
//                                            'Job Order' => 'Job Order',
//                                        ])->live()->default('Permanent')->rules('required')->required(),
//                                        TextInput::make('job_title')->label('Position Title')->required()->rules('required'),
//                                        TextInput::make('plantilla_item')->label('Plantilla Item No.')->hidden(fn(Get $get) => $get('status_of_appointment') == 'Permanent' ? false : true)->required()->rules('required'),
//                                        TextInput::make('salary_grade')->label('Salary Grade / Salary')->required()->rules('required'),
//                                        DateTimePicker::make('posting_date')->label('Posting Date')->required(),
//                                        DateTimePicker::make('closing_date')->label('Close Date')->required(),
//                                        // DatePicker::make('closing_date')->label('Close Date')->required()->native(false)->minDate(now())->rules('required'),
//                                        Select::make('status_of_hiring')->options([
//                                            '1' => 'Open',
//                                            '0' => 'Close',
//                                        ])->live()->default('1'),
//
//                                        TextInput::make('application_code')->label('Application Code')->required()->rules('required'),
//                                        TextInput::make('place_of_assignment')->label('Division/Place of Assignment')->required()->rules('required'),
//                                    ]),
//
//
//
//                                ]),
//
//
//                            Fieldset::make('Qualification Standards of the Position')
//                                ->schema([
//                                    Grid::make([
//                                        'default' => 1,
//                                        'sm' => 2
//                                    ])->schema([
//                                        TextInput::make('education')->required()->rules('required'),
//                                        TextInput::make('training')->required()->rules('required'),
//                                        TextInput::make('experience')->required()->rules('required'),
//                                        TextInput::make('eligibility')->required()->rules('required'),
//
//                                    ])
//
//                                ]),
//
//
//                            RichEditor::make('description')
//                                ->label('Job Description Summary')
//                                ->toolbarButtons([
//                                    'attachFiles',
//                                    'blockquote',
//                                    'bold',
//                                    'bulletList',
//                                    'h2',
//                                    'h3',
//                                    'h1',
//                                    'italic',
//                                    'link',
//                                    'orderedList',
//                                    'redo',
//                                    'strike',
//                                    'underline',
//                                    'undo',
//                                ])->fileAttachmentsDirectory('recruitment/job')->extraAttributes([
//                                    'style' => 'max-height:30rem'
//                                ])->grow(false)
//
//
//                        ])
//                        ->hidden(function(){
//                            if(Auth::user()->can('RECRUITMENT')) return false;
//                            if(Auth::user()->can('RECRUITMENT VIEW')) return true;
//
//                        })
//                        ->action(function ($data, $record) {
//                            $record->batchInfo?->update([
//                                'closing_date' => $data['closing_date'],
//                                'posting_date' => $data['posting_date'],
//
//                            ]);
//                            $plantilla = !!data_get($data, 'plantilla_item') ? $data['plantilla_item'] : '';
//                            \App\Models\RecruitmentJobActivity::create([
//                                'activity' => 'Updated by ' . Auth::user()->name,
//                                'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'><p class='font-bold'>$data[job_title] - " . $record->batchInfo->batch_name . "<p><br>
//                                    job_title => $data[job_title]<br>
//                                    status_of_hiring => $data[status_of_hiring]<br>
//                                    status_of_appointment => $data[status_of_appointment]<br>
//                                    plantilla_item =>  $plantilla<br>
//                                    salary_grade => $data[salary_grade]<br>
//                                    place_of_assignment => $data[place_of_assignment]<br>
//
//                                    application_code => $data[application_code]<br>
//                                    education => $data[education]<br>
//                                    training => $data[training]<br>
//                                    experience => $data[experience]<br>
//                                    eligibility => $data[eligibility]<br>
//
//                                </main>"),
//                                'id_number' => Auth::user()->id_number,
//                                'type' => '1',
//                                'job_id' => $record->job_id
//                            ]);
//                            $arr = [
//                                'job_title' => $data['job_title'],
//                                'status_of_hiring' => $data['status_of_hiring'],
//                                'status_of_appointment' => $data['status_of_appointment'],
//
//                                'salary_grade' => $data['salary_grade'],
//                                'place_of_assignment' => $data['place_of_assignment'],
//                                'description' => $data['description'],
//                                'application_code' => $data['application_code'],
//                                'education' => $data['education'],
//                                'training' => $data['training'],
//                                'experience' => $data['experience'],
//                                'eligibility' => $data['eligibility'],
//                            ];
//                            if (!!data_get($data, 'plantilla_item')) {
//                                $arr['plantilla_item'] = $data['plantilla_item'];
//                                $record->update($arr);
//                            } else {
//
//                                $job =  $record->update($arr);
//                            }
//                            \App\Models\RecruitmentMonitoring::where('batch_id', $record->batchInfo?->batch_id)->update([
//                                'job_id' =>  $record->job_id,
//                                'unfilled_position' => $data['job_title'],
//                                'dbm_plantilla_item_number' =>  $plantilla,
//                                'deadline_on_the_submmision_of_application' => Carbon::parse($data['closing_date'])->format('F d, Y'),
//                                'date_of_publication' => Carbon::parse($data['posting_date'])->format('F d, Y'),
//                                'issuance_of_regional_memo' => Carbon::parse($data['posting_date'])->format('F d, Y'),
//                            ]);
//
//                            Notification::make()
//                                ->title('Updated successfully')
//                                ->success()
//                                ->send();
//                        })->modalWidth(MaxWidth::ScreenMedium)->color(Color::Green),
//
//                    //############################ change batch button ###############################################
//                    EditAction::make('Change Batch')->label('Change Batch')->icon('heroicon-o-arrow-path')
//                        ->modalHeading(fn($record) => "Change Batch - $record->job_title")
//                        ->mutateRecordDataUsing(function (array $data, $record): array {
//                            $this->options = [];
//                            $data['batch'] = $record->batchInfo?->batch_id;
//                            return $data;
//                        })
//                        ->form([
//                            Select::make('batch')
//                                ->options(function ($record) {
//                                    $oldOption = \App\Models\RecruitmentJobBatch::where('job_id', $record->job_id)->orderByDesc('id')->get()->pluck('batch_name', 'batch_id')->all();
//                                    foreach ($oldOption as $key => $option) {
//                                        $this->options[$key] = $option;
//                                    }
//                                    return $this->options;
//                                })
//                                ->searchable()
//                                ->createOptionForm([
//                                    TextInput::make('batch_no')->label('Batch name')->required()->rules('required'),
//                                ])
//
//                                ->createOptionUsing(function (array $data, $record): String {
//
//                                    $id = \App\Models\RecruitmentJobBatch::create([
//                                        'job_id' => $record->job_id,
//                                        'batch_name' => $data['batch_no'],
//                                        'status' => 0,
//                                        'batch_id' => Str::uuid(),
//                                    ]);
//                                    \App\Models\RecruitmentMonitoring::create([
//                                        'job_id' =>  $record->job_id,
//                                        'batch_id' => $id->batch_id,
//                                        'unfilled_position' => $record->job_title,
//                                        'dbm_plantilla_item_number' => $record->plantilla_item,
//
//                                    ]);
//                                    return $id->batch_id;
//                                })->live()->required()
//                                ->editOptionForm([
//                                    TextInput::make('batch_no')
//                                        ->required(),
//
//                                ])->fillEditOptionActionFormUsing(function (Get $get) {
//                                    $info =  \App\Models\RecruitmentJobBatch::select('batch_id', 'batch_name')->where('batch_id', $get('batch'))->first();
//                                    return [
//                                        'batch_no' => $info?->batch_name
//                                    ];
//                                })->updateOptionUsing(function ($data, Get $get) {
//                                    \App\Models\RecruitmentJobBatch::select('batch_id', 'batch_name')->where('batch_id', $get('batch'))->update([
//                                        'batch_name' => $data['batch_no']
//                                    ]);
//                                }),
//                        ])
//                        ->modalWidth(MaxWidth::Small)
//                        ->hidden(function(){
//                            if(Auth::user()->can('RECRUITMENT')) return false;
//                            if(Auth::user()->can('RECRUITMENT VIEW')) return true;
//
//                        })
//                        ->action(function ($data, $record) {
//
//                            foreach ($this->options as $key => $option) {
//
//                                if (Str::isUuid($key)) {
//
//                                    \App\Models\RecruitmentJobBatch::where('batch_id', '=', $key)->update([
//                                        'status' => $key == $data['batch'] ? 1 : 0,
//                                    ]);
//                                } else {
//                                    \App\Models\RecruitmentJobBatch::create([
//                                        'job_id' => $record->job_id,
//                                        'batch_name' => $option,
//                                        'status' => $key == $data['batch'] ? 1 : 0,
//                                        'batch_id' => Str::uuid(),
//                                    ]);
//                                }
//                            }
//                            \App\Models\RecruitmentJobActivity::create([
//                                'activity' => 'Batch Update by ' . Auth::user()->name,
//                                'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'><p class='font-bold'>$record->job_title - " . $record->batchInfo?->batch_name . "<p><br></main>
//                           "),
//                                'id_number' => Auth::user()->id_number,
//                                'type' => '1',
//                                'job_id' => $record->job_id
//                            ]);
//
//                            sleep(1);
//                            Notification::make()
//                                ->title('Updated successfully')
//                                ->success()
//                                ->send();
//                        })->color(Color::Orange),
//                    // ###################################### PSB ####################################
//                    EditAction::make('psb')
//
//                        ->mutateRecordDataUsing(function (array $data, $record): array {
//                            $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::where('job_id', $record->job_id)->where('batch_id', $record->batchInfo?->batch_id)->first();
//
//                            $data['initial_evaluation_report'] = $otherInformation?->initial_evaluation;
//                            $data['open_ranking'] = $otherInformation?->open_ranking;
//                            $data['exam'] = $otherInformation?->exam;
//                            $data['interview'] = $otherInformation?->interview;
//                            $data['type'] = $otherInformation?->type;
//                            $data['category'] = $otherInformation?->category;
//                            $data['min_requirements_education'] = $otherInformation?->min_requirements_education;
//                            $data['min_requirements_training'] = $otherInformation?->min_requirements_training;
//                            $data['min_requirements_experience'] = $otherInformation?->min_requirements_experience;
//
//                            if ($otherInformation) {
//                                $data['psb'] = \App\Models\RecruitmentJobPsb::select('otherinformation_id', 'id_number')->where('otherinformation_id', $otherInformation->id)->get()->pluck('id_number')->toArray();
//                            }
//
//                            return $data;
//                        })
//
//                        ->modalHeading(fn($record) => "Update - PSB & other information($record->job_title)")
//                        ->label('PSB & other information')
//                        ->icon('heroicon-o-shield-check')
//                        ->form([
//                            Grid::make([
//                                'default' => 2
//                            ])->schema([
//                                Group::make([
//                                    Section::make('PSB DETAILS')->schema([
//                                        Select::make('psb')->label('Select PSB')
//                                            ->multiple()
//                                            ->options(User::select('name', 'id_number')->get()->pluck('name', 'id_number')),
//                                        DateTimePicker::make('initial_evaluation_report'),
//                                        DateTimePicker::make('open_ranking'),
//                                        DateTimePicker::make('exam'),
//                                        DateTimePicker::make('interview'),
//                                    ]),
//                                ]),
//                                Group::make([
//                                    Section::make('EIR DETAILS')->schema([
//                                        Select::make('type')
//                                            ->options([
//                                                'Related-Teaching Positions' => 'Related-Teaching Positions',
//                                                'Non-Teaching Positions' => 'Non-Teaching Positions',
//                                            ])->live()->required()->rules(['required']),
//
//                                        Select::make('category')
//                                            ->options(function (Get $get) {
//                                                if (!!$get('type') && $get('type') == 'Related-Teaching Positions') {
//                                                    return [
//                                                        'SG 11-15' => 'SG 11-15',
//                                                        'SG 16-23 and SG-24' => 'SG 16-23 and SG-24',
//                                                        'SG-24(Chief)' => 'SG-24(Chief)',
//                                                    ];
//                                                } elseif (!!$get('type') && $get('type') == 'Non-Teaching Positions') {
//                                                    return [
//                                                        'General Services' => 'General Services',
//                                                        'SG 1-9 (None-General Services)' => 'SG 1-9 (None-General Services)',
//                                                        'SG 10-22 and SG 27' => 'SG 10-22 and SG 27',
//                                                        'SG-24(Chief)' => 'SG-24(Chief)',
//                                                    ];
//                                                }
//                                            })->hidden(fn(Get $get) => !!$get('type') ? false : true)->required()->rules(['required']),
//                                        Grid::make([
//                                            'default' => 3
//                                        ])->schema([
//                                            TextInput::make('min_requirements_education')->numeric()->minValue(1)->required()->rules(['required']),
//                                            TextInput::make('min_requirements_training')->numeric()->minValue(1)->required()->rules(['required']),
//                                            TextInput::make('min_requirements_experience')->numeric()->minValue(1)->required()->rules(['required']),
//                                        ])
//
//                                    ]),
//                                ])
//
//                            ])
//                        ])
//                        ->hidden(function(){
//                            if(Auth::user()->can('RECRUITMENT')) return false;
//                            if(Auth::user()->can('RECRUITMENT VIEW')) return true;
//
//                        })
//                        ->color(Color::Blue)
//                        ->action(function ($data, $record) {
//
//                            $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::where('job_id', $record->job_id)->where('batch_id', $record->batchInfo?->batch_id)->first();
//                            if ($otherInformation) {
//
//                                $otherInformation->update([
//                                    'initial_evaluation' => $data['initial_evaluation_report'],
//                                    'open_ranking' => $data['open_ranking'],
//                                    'exam' => $data['exam'],
//                                    'interview' => $data['interview'],
//                                    'type' => $data['type'],
//                                    'category' => $data['category'],
//                                    'min_requirements_education' => $data['min_requirements_education'],
//                                    'min_requirements_training' => $data['min_requirements_training'],
//                                    'min_requirements_experience' => $data['min_requirements_experience'],
//
//                                ]);
//                            } else {
//                                $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::create([
//                                    'initial_evaluation' => $data['initial_evaluation_report'],
//                                    'open_ranking' => $data['open_ranking'],
//                                    'exam' => $data['exam'],
//                                    'interview' => $data['interview'],
//                                    'type' => $data['type'],
//                                    'category' => $data['category'],
//                                    'min_requirements_education' => $data['min_requirements_education'],
//                                    'min_requirements_training' => $data['min_requirements_training'],
//                                    'min_requirements_experience' => $data['min_requirements_experience'],
//                                    'batch_id' => $record->batchInfo?->batch_id,
//                                    'job_id' => $record?->job_id,
//                                ]);
//                            }
//                            \App\Models\RecruitmentJobPsb::where('otherinformation_id', $otherInformation->id)->delete();
//                            $users = [];
//                            $datetime = !!$data['open_ranking'] ? Carbon::parse($data['open_ranking'])->format('M d, Y h:i:s A') : '';
//                            $datetimeier = !!$data['initial_evaluation_report'] ? Carbon::parse($data['initial_evaluation_report'])->format('M d, Y h:i:s A') : '';
//                            foreach ($data['psb'] as $key => $psb) {
//
//                                Notification::make()
//                                    ->icon('heroicon-o-folder')
//                                    ->iconColor(Color::Yellow)
//                                    ->title('Assigned Job')
//                                    ->body(new HtmlString("$record->job_title - " . $record->batchInfo?->batch_name . "<br> <strong>Open ranking: " . $datetime . "</strong>" . "<br> <strong>IER: " . $datetimeier . "</strong>"))
//                                    ->success()
//                                    ->actions([
//                                        \Filament\Notifications\Actions\Action::make('view')
//                                            ->url(route('recruitment.psb.applicant', ['job_title' => $record->job_title, 'job_batch' => $record->batchInfo?->batch_id, 'job_id' => $record->job_id])),
//                                        \Filament\Notifications\Actions\Action::make('markAsRead')
//                                            ->link()
//                                            ->color(Color::Red)
//                                            ->markAsRead(),
//                                    ])
//                                    ->sendToDatabase(User::where('id_number', $psb)->first());
//                                $user = User::where('id_number', $psb)->first();
//                                $users[] = $user->name;
//                                \App\Models\RecruitmentJobPsb::create([
//                                    'id_number' => $psb,
//                                    'batch_id' => $record->batchInfo?->batch_id,
//                                    'job_id' => $record?->job_id,
//                                    'otherinformation_id' => $otherInformation->id,
//                                ]);
//                            }
//                            $finaluser = implode(', ', $users);
//                            \App\Models\RecruitmentJobActivity::create([
//                                'activity' => 'Updated by ' . Auth::user()->name . '(PSB & Other Information)',
//                                'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'>
//                                'PSB' => ($finaluser)<br>
//                                'initial_evaluation' => $data[initial_evaluation_report]<br>
//                                'open_ranking' => $data[open_ranking]<br>
//                                'exam' => $data[exam]<br>
//                                'interview' => $data[interview]<br>
//                                </main>"),
//                                'id_number' => Auth::user()->id_number,
//                                'type' => '1',
//                                'job_id' => $record->job_id
//                            ]);
//
//
//                            Notification::make()
//                                ->title('Updated successfully')
//                                ->success()
//                                ->duration(2000)
//                                ->send();
//                        })->modalWidth(MaxWidth::Full),
//                    // ####################################### Activity log Action #################################################
//                    Action::make('logs')
//                        ->label('Activity Logs')
//                        ->modalHeading(fn($record) => "$record->job_title")
//                        ->icon('heroicon-o-clock')
//                        ->modalContent(function ($record) {
//                            $logs = \App\Models\RecruitmentJobActivity::where('job_id', $record->job_id)->orderByDesc('id')->get();
//                            return view('livewire.recruitment.activity_log', compact('logs'));
//                        })
//                        ->modalSubmitAction(false)
//                        ->modalCancelAction(false)
//                        ->hidden(function(){
//                            if(Auth::user()->can('RECRUITMENT')) return false;
//                            if(Auth::user()->can('RECRUITMENT VIEW')) return true;
//
//                        })
//                        ->color(Color::Gray),
//
//
//                    // ####################################### APPLICANT CAR #################################################
//                    Action::make('carFile')
//                        ->label('CAR FILE')
//
//                        ->extraModalActions([
//
//                            EditAction::make('statusx')
//                                ->icon('heroicon-o-arrow-up-tray')
//                                ->modalHeading('Upload File')
//                                ->color(Color::Amber)
//                                ->label('Upload File')
//                                ->mutateRecordDataUsing(function (array $data, $record): array {
//
//
//                                    $data['car_file'] = $record?->batchInfo?->car_file;
//                                    $data['notification_letter'] = $record?->batchInfo?->notification_letter;
//                                    $data['hired_applicant_id'] = $record?->batchInfo?->hired_applicant_id;
//                                    return $data;
//                                })
//                                ->form([
//
//                                    FileUpload::make('car_file')
//                                        ->directory('recruitment/application/car')->acceptedFileTypes(['application/pdf'])->preserveFilenames()->getUploadedFileNameForStorageUsing(
//                                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName()),
//                                        ),
//                                    Select::make('hired_applicant_id')
//                                        ->label('Author')
//                                        ->options(function ($record) {
//                                            $batch = $record->batchInfo?->batch_id;
//                                            $job_id = $record->job_id;
//                                            $applicants = \App\Models\RecruitmetJobApplication::where('job_id', $job_id)->where('batch_id', $batch)->where('application_status', 2)->get();
//                                            $applicantArray = [];
//                                            foreach ($applicants as $applicant) {
//                                                $applicantArray[$applicant->application_code] = "$applicant->fname $applicant->mname $applicant->lname";
//                                            }
//
//                                            return $applicantArray;
//                                        })
//                                        ->searchable()->required()->rules('required'),
//                                    FileUpload::make('notification_letter')
//                                        ->directory('recruitment/application/notification_letter')->acceptedFileTypes(['application/pdf'])->preserveFilenames()->getUploadedFileNameForStorageUsing(
//                                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName()),
//                                        )->required()->rules('required')
//                                ])
//                                ->modalWidth(MaxWidth::Small)
//                                ->modalSubmitActionLabel('Upload')
//                                ->action(function ($data, $record) {
//
//                                    $record->batchInfo->update([
//                                        'car_file' => $data['car_file'],
//                                        'hired_applicant_id' => $data['hired_applicant_id'],
//                                        'notification_letter' => $data['notification_letter'],
//                                    ]);
//                                    Notification::make()
//                                        ->title('Uploaded Successfully')
//                                        ->success()
//                                        ->send();
//
//
//                                }),
//
//                        ])
//                        ->icon('heroicon-o-arrow-up-tray')
//                        ->modalHeading(fn($record) => "$record->job_title")
//                        ->form([
//                            Grid::make([
//                                'default' => 2,
//                                'sm' => 1,
//                                'md' => 2
//                            ])->schema([
//                                PdfViewerField::make('CAR WITH SIGNED')
//                                    ->label('CAR WITH SIGN')
//                                    ->minHeight('70svh')
//                                    ->fileUrl(function ($record) {
//                                        $file = $record?->batchInfo?->car_file;
//                                        return Storage::url("public/$file");
//                                    })->hidden(fn($record): bool => !!$record?->batchInfo?->car_file ? false : true),
//                                PdfViewerField::make('notification_letter')
//                                    ->label(fn($record) => "NOTIFICATION LETTER (" . $record->batchInfo?->hiredInfo?->fname . " " . $record->batchInfo?->hiredInfo?->mname . " " . $record->batchInfo?->hiredInfo?->lname . ")")
//                                    ->minHeight('70svh')
//                                    ->fileUrl(function ($record) {
//                                        $file = $record?->batchInfo?->notification_letter;
//                                        return Storage::url("public/$file");
//                                    })->hidden(fn($record): bool => !!$record?->batchInfo?->notification_letter ? false : true),
//                            ])
//
//                        ])
//                        ->modalSubmitAction(false)
//                        ->modalCancelAction(false)
//                        ->modalWidth(MaxWidth::Full)
//                        ->hidden(function(){
//                            if(Auth::user()->can('RECRUITMENT')) return false;
//                            if(Auth::user()->can('RECRUITMENT VIEW')) return true;
//
//                        }),
//                ])->tooltip('Action Button'),

            ], position: ActionsPosition::BeforeColumns )
            ->defaultSort('created_at', 'desc');
    }

    public function headerAddAction()
    {

        return Action::make('Add Job')
            ->modalHeading('Add Job')
            ->icon('heroicon-o-plus-circle')
            ->hidden(function () {
                if (Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value)) return false;
                if (Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)) return true;

            })
            ->slideOver()
            ->form([
                TextInput::make('batch')->required(),
                Fieldset::make('Basic Information of the Position')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Select::make('status_of_appointment')->options([
                                'Permanent' => 'Permanent',
                                'Contractual' => 'Contractual',
                                'Job Order' => 'Job Order',
                            ])->live()->default('Permanent')->rules('required')->required(),
                            TextInput::make('job_title')->label('Position Title')->required()->rules('required'),
                            TextInput::make('plantilla_item')->label('Plantilla Item No.')->hidden(fn(Get $get) => $get('status_of_appointment') == 'Permanent' ? false : true)->required()->rules('required'),
                            TextInput::make('salary_grade')->label('Salary Grade / Salary')->required()->rules('required'),
                            DateTimePicker::make('posting_date')->label('Posting Date')->required(),
                            DateTimePicker::make('closing_date')->label('Close Date')->required(),
                            // DatePicker::make('closing_date')->label('Close Date')->required()->native(false)->minDate(now())->rules('required'),
                            Select::make('status_of_hiring')->options([
                                '1' => 'Open',
                                '0' => 'Close',
                            ])->live()->default('1'),
                            TextInput::make('application_code')->label('Application Code')->required()->rules('required'),
                            TextInput::make('place_of_assignment')->label('Division/Place of Assignment')->required()->rules('required'),
                        ]),


                    ]),


                Fieldset::make('Qualification Standards of the Position')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            TextInput::make('education')->required()->rules('required'),
                            TextInput::make('training')->required()->rules('required'),
                            TextInput::make('experience')->required()->rules('required'),
                            TextInput::make('eligibility')->required()->rules('required'),

                        ])

                    ]),

                RichEditor::make('description')
                    ->label('Job Description Summary')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'h2',
                        'h3',
                        'h1',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])->fileAttachmentsDirectory('recruitment/job'),


            ])
            ->action(function ($data) {

                $arr = [
                    'job_title' => $data['job_title'],
                    'job_id' => Str::uuid(),
                    'status_of_hiring' => $data['status_of_hiring'],
                    'status_of_appointment' => $data['status_of_appointment'],
                    'salary_grade' => $data['salary_grade'],
                    'place_of_assignment' => $data['place_of_assignment'],
                    'description' => $data['description'],
                    'application_code' => $data['application_code'],
                    'education' => $data['education'],
                    'training' => $data['training'],
                    'experience' => $data['experience'],
                    'eligibility' => $data['eligibility'],
                ];
                if (!!data_get($data, 'plantilla_item')) {
                    $arr['plantilla_item'] = $data['plantilla_item'];
                    $job = Recruitment_Job::create($arr);
                } else {
                    $job = Recruitment_Job::create($arr);
                }
                $batch = \App\Models\RecruitmentJobBatch::create([
                    'batch_id' => Str::uuid(),
                    'job_id' => $job->job_id,
                    'batch_name' => $data['batch'],
                    'status' => 1,
                    'closing_date' => $data['closing_date'],
                    'posting_date' => $data['posting_date'],
                ]);
                \App\Models\RecruitmentMonitoring::create([
                    'batch_id' => $batch->batch_id,
                    'job_id' => $job->job_id,
                    'unfilled_position' => $data['job_title'],
                    'dbm_plantilla_item_number' => !!data_get($data, 'plantilla_item') ? $data['plantilla_item'] : '',
                    'deadline_on_the_submmision_of_application' => Carbon::parse($data['closing_date'])->format('F d, Y'),
                    'date_of_publication' => Carbon::parse($data['posting_date'])->format('F d, Y'),
                    'issuance_of_regional_memo' => Carbon::parse($data['posting_date'])->format('F d, Y'),
                    // 'date_of_publication' => Carbon::parse($data['posting_date'])->format('F d, Y'),
                ]);
                \App\Models\RecruitmentJobActivity::create([
                    'activity' => 'Created by ' . Auth::user()->name,
                    'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'><p class='font-bold'>$data[job_title] - " . $data['batch'] . "<p><br>
                    job_title => $data[job_title]<br>
                    status_of_hiring => $data[status_of_hiring]<br>
                    status_of_appointment => $data[status_of_appointment]<br>
                    plantilla_item => $data[plantilla_item]<br>
                    salary_grade => $data[salary_grade]<br>
                    place_of_assignment => $data[place_of_assignment]<br>

                    application_code => $data[application_code]<br>
                    education => $data[education]<br>
                    training => $data[training]<br>
                    experience => $data[experience]<br>
                    eligibility => $data[eligibility]<br></main>
                "),
                    'id_number' => Auth::user()->id_number,
                    'type' => '1',
                    'job_id' => $job->job_id
                ]);

                sleep(1);
                Notification::make()
                    ->title('Created successfully')
                    ->success()
                    ->send();
            })->modalWidth(MaxWidth::ScreenMedium);
    }

    #[Title('RSA - Create Job')]
    public function render()
    {

        return view('livewire.recruitment.job');
    }
}
