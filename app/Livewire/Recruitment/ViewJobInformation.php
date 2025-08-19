<?php

namespace App\Livewire\Recruitment;

use Carbon\Carbon;
use App\Models\User;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use App\Enums\RecruitmentLabelEnum;
use App\Models\RecruitmentJobBatch;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use App\Traits\ApplicantFileUploadTrait;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Traits\RecruitmentAttachmentFunctionTrait;
use Filament\Actions\Concerns\InteractsWithActions;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class ViewJobInformation extends Component  implements HasActions, HasForms,HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;
    use RecruitmentAttachmentFunctionTrait;
    use ApplicantFileUploadTrait;
    use \App\Traits\ApplicationTable\BulkActionTrait;
    public $job_title = '';
    public $job_id = '';
    public $batch_id = '';
    #[Url()]
    public $batch = '';
    public $jobInfo = null;
    public $currentBatch = null;
    public $batches = null;
    public $psbMembers = null;

    // batch
    public $options = [];

    // ########### APPLICANT VARIABLE
    #[Url()]

    public $activeTab = 'all';
    public $allData = null;
    #[Url()]
    public $tableSearch = '';
    #[Url]
    public ?array $tableFilters = null;
    public function changeTab($value)
    {
        $this->tableSearch = '';
        $this->resetPage();

        $this->deselectAllTableRecords();
        sleep(1);

        $this->activeTab = $value;
    }
    public function deleteComment(\App\Models\RecruitmentApplicationFileComment $id, $record)
    {
        \App\Models\ApplicantLog::create([
            'activity' => 'Comment Deleted by ' . Auth::user()->name,
            'message' => $id->comment,
            'id_number' => Auth::user()->id_number,
            'applicant_id' => $id->application_id,
            'type' => '2'
        ]);
        $id->delete();
        $this->resetTable();
        Notification::make()
            ->title('Deleted successfully')
            ->success()
            ->send();
    }

    public function table(Table $table): Table
    {
        // QUERY FROM DATABASE
        if ($this->activeTab == 'checkfile') {
            $query = \App\Models\RecruitmetJobApplication::query()->where('batch_id',$this->batch)->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('application_status', 0)->where('job_id', $this->job_id) ;
        } elseif ($this->activeTab == 'validator') {
            $query = \App\Models\RecruitmetJobApplication::query()->where('batch_id',$this->batch)->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('application_status', 1)->where('job_id', $this->job_id) ;
        } elseif ($this->activeTab == 'qualified') {
            $query = \App\Models\RecruitmetJobApplication::query()->where('batch_id',$this->batch)

                ->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            },'assignPsb','eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation','jobOtherInformation.psbs.psbInformation:email,id_number','myGrade'])
                ->where('application_status', 2)
                ->where('job_id', $this->job_id);
        } elseif ($this->activeTab == 'all') {
            $query = \App\Models\RecruitmetJobApplication::query()->where('batch_id',$this->batch)->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('job_id', $this->job_id) ;
        } elseif ($this->activeTab == 'notqualified') {
            $query = \App\Models\RecruitmetJobApplication::query()->where('batch_id',$this->batch)->with(['applicantGrades' => function ($q) {
                $q->with('psbInfo');
            }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation'])->where('application_status', 4)->where('job_id', $this->job_id) ;
        }
        return $table
            ->query($query)
             ->emptyStateHeading('No Applicants')
            ->deferLoading()
            ->columns([
                // APPLICANT CODE START
                TextColumn::make('application_code')
                    ->label('Applicant Code')
                    ->searchable()
                    ->sortable()
                    ->markdown(),
                // APPLICANT CODE END

                // BATCH NAME START
                TextColumn::make('batch_id')
                    ->label('Batch')
                    ->state(fn($record) => $record->batchInfo?->batch_name),
                // BATCH NAME END

                // FULL NAME START
                TextColumn::make('fullname')
                    ->label('Applicant Name')
                    ->searchable(['fname', 'lname', 'mname'])
                    ->sortable(['lname'])
                    ->state(fn($record) => new HtmlString($record?->lname . ',<br> ' . $record?->fname . ' ' . $record?->mname)),
                // FULL NAME END

                // FINAL POINTS
                TextColumn::make('applicantGrades')
                    ->label('Final Points')

                    ->formatStateUsing(function ($record) {
                        $totalqs = 0;
                        $totalPotential = 0;
                        $count =  $record?->applicantGrades->where('potential_total','!=', null)->where('potential_total','!=', 0)->count();
                        $totalPotential = (float)$record?->myGrade->education_total + (float)$record?->myGrade->training_total + (float)$record?->myGrade->experience_total + (float)$record?->myGrade->performance_total + (float)$record?->myGrade->outstanding + (float)$record?->myGrade->application_of_education + (float)$record?->myGrade->l_and_d;
                        $totalPotential += $count != 0 ? (float)$record?->applicantGrades->sum('potential_total') / $count : 0;

                        return number_format($totalPotential,2,'.',',');
                    }),

                // FINAL POINTS END

                // EMAIL START
                TextColumn::make('email')
                    ->label('Applicant Email')
                    ->searchable()
                    ->copyable()
                    ->state(fn($record) => $record?->email)
                    ->copyMessage('Email address copied')->toggleable(isToggledHiddenByDefault: false),
                // EMAIL END

                // MOBILE NUMBER START
                TextColumn::make('mobile_number')
                    ->label('Applicant Mobile Number')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->state(fn($record) => $record?->mobile_number),
                // MOBILE NUMBER END

                // ADDDRESS START
                TextColumn::make('address')
                    ->label('Applicant Address')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->state(fn($record) => $record?->address)
                    ->extraAttributes(['class' => ' break-all break-words  w-[2rem] overflow-hidden'])
                    ->wrap(),
                // ADDRESS END

                // SUBMITTED START
                TextColumn::make('created_at')
                    ->label('submitted At')
                    ->state(fn($record) => Carbon::parse($record->created_at)
                        ->format('M d, Y h:i:s A'))
                    ->toggleable(isToggledHiddenByDefault: false),
                // SUBMITTED END

                // LAHAT NG EMAIL NA NASEND SA APPLICANT START
                TextColumn::make('activitiesEmail.message')
                    ->label('Emails')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->badge()
                    ->icon('heroicon-m-check-circle'),
                // LAHAT NG EMAIL NA NASEND SA APPLICANT END

                // STATUS OF APPLICATION START
                TextColumn::make('application_status')->label('Applicant Status')->state(function ($record) {
                    return match ($record->application_status) {
                        0 => \App\Enums\RecruitmemtApplicantStatusEnum::PENDING,
                        1 => \App\Enums\RecruitmemtApplicantStatusEnum::VALIDATE,
                        2 => \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED,
                        4 => \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED,
                    };
                })->badge()->color(function ($record) {
                    return match ($record->application_status) {
                        0 => Color::Yellow,
                        1 => Color::Blue,
                        2 => Color::Green,
                        4 => Color::Red,
                    };
                }),
                // STATUS OF APPLICATION END



            ])
            ->actions([
                ActionGroup::make([
                    // ######################################### validate action ##########################################
                    Action::make('Validate')
                        ->slideOver()
                        ->modalWidth(MaxWidth::Full)
                        ->modalHeading(function ($record) {
                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
                        })
                        ->color(Color::Blue)
                        ->icon('heroicon-o-eye')
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->extraModalActions($this->extraActionsInApplicationTable())
                        ->form([
                            Grid::make([
                                'default'=>2,
                                'sm'=>2
                            ])
                                ->schema([
                                    Group::make([
                                        Select::make('select')->label('Select Attachment')->options(function () {
                                            $allCases = RecruitmentLabelEnum::cases();
                                            $exceptOneCases = array_filter($allCases, fn($case) => $case !== RecruitmentLabelEnum::MOVS);
                                            $x = [];
                                            foreach ($exceptOneCases as $exceptOneCase) {
                                                $x[$exceptOneCase->value] = \App\Enums\RecruitmentLabelEnum::tryFrom($exceptOneCase->value)->shortName();
                                            }
                                            return $x;
                                        })->live(),
                                        Hidden::make('token')->reactive(),
                                        PdfViewerField::make('file')
                                            ->label(fn(Get $get) => !!$get('select') ? $get('select') : '')
                                            ->fileUrl(function (Get $get, $record, Set $set) {
                                                $value = \App\Enums\RecruitmentLabelEnum::tryFrom($get('select'))?->getColumn();
                                                    if (!!$record->$value) {
                                                        $set('token', false);
                                                        $batchinfo = $record->batchInfo->id;
                                                        $batchName = $record->batchInfo->batch_name;
                                                        $jobInfo = $record->jobInfo->id;
                                                        $jobTitle = $record->jobInfo->job_title;
                                                        $filePath = "public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value;
                                                        $filePathUpdate = "public/recruitment/application/$jobTitle/$batchName/$record->email/" . $record->$value;

                                                        if (Storage::exists($filePath)) {

                                                            return Storage::url("public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value);
                                                        } else if(Storage::exists($filePathUpdate)) {
                                                            return Storage::url($filePathUpdate);

                                                        }

                                                    }
                                                $set('token', true);
                                                return "";
                                            })->minHeight('70svh'),
                                    ]),
                                    Group::make([
                                        ViewField::make('rating')
                                            ->view('livewire.recruitment.assets.attachment_table')
                                            ->registerActions([
                                                \Filament\Forms\Components\Actions\Action::make('approved')
                                                    ->icon('heroicon-o-check')
                                                    ->color(Color::Green)
                                                    ->iconButton()
                                                    ->action(function ($record,$arguments){
                                                        $record->update([
                                                            "$arguments[id]_status"=>1
                                                        ]);
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('disapproved')
                                                    ->icon('heroicon-o-x-mark')
                                                    ->color(Color::Red)
                                                    ->iconButton()
                                                    ->action(function ($record,$arguments){
                                                        $record->update([
                                                            "$arguments[id]_status"=>2
                                                        ]);
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('comment')
                                                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                                    ->color(Color::Gray)
                                                    ->iconButton()
                                                    ->form([
                                                        TextInput::make('comment')
                                                    ])
                                                    ->modalWidth(MaxWidth::Small)
                                                    ->action(function ($data,$record,$arguments){
                                                        \App\Models\RecruitmentApplicationFileComment::create([
                                                            'application_id' => $record->id,
                                                            'comment' => $data['comment'],
                                                            'filename' => $arguments['id'],
                                                            'id_number' => Auth::user()->id_number
                                                        ]);
                                                        \App\Models\ApplicantLog::create([
                                                            'activity' => 'Commented by '.Auth::user()->name,
                                                            'message'=>$data['comment'] ,
                                                            'id_number' => Auth::user()->id_number,
                                                            'applicant_id' => $record->id,
                                                            'type'=>'1'
                                                        ]);

                                                        Notification::make()
                                                            ->title('Created successfully')
                                                            ->success()
                                                            ->send();
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('deletecomment')
                                                    ->requiresConfirmation()
                                            ])
                                    ])
                                ])
                        ])
                        ->hidden(fn($record) => $record->application_status == 1 ? false : true),
//                    Action::make('Validate')
//                        ->modalHeading(function ($record) {
//                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
//                        })
//                        ->extraModalActions($this->extraActionsInApplicationTable())
//                        ->color(Color::Blue)->icon('heroicon-o-eye')
//                        ->hidden(fn($record) => $record->application_status == 1 ? false : true)
//                        ->form(function ($record) {
//                            return $this->allApplicantAttachment($record);
//                        })
//                        ->modalSubmitAction(false)
//                        ->modalCancelAction(false)
//                        ->closeModalByClickingAway(false)
//                        ->extraAttributes([
//                            'id' => 'edit-xx'
//                        ])->modalWidth(MaxWidth::ScreenLarge),

                    // ########################################### Check File Action #######################################
                    Action::make('Check File')
                        ->slideOver()
                        ->modalWidth(MaxWidth::Full)
                        ->modalHeading(function ($record) {
                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
                        })
                        ->color(Color::Yellow)
                        ->icon('heroicon-o-eye')
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->extraModalActions([
                            Action::make('approve_proceed')
                                ->label('Approved and proceed to validator')
                                ->color(Color::Green)
                                ->action(function ($record) {
                                    \App\Models\ApplicantLog::create([
                                        'activity' => 'Approved(Check Requirements) by ' . Auth::user()->name,
                                        'message' => "Pending => Validate",
                                        'id_number' => Auth::user()->id_number,
                                        'applicant_id' => $record->id,
                                        'type' => '1'
                                    ]);
                                    $record->update([
                                        'application_status' => 1
                                    ]);

                                    Notification::make()
                                        ->title('Transfer Data successfully')
                                        ->success()
                                        ->send();
                                    sleep(1);

                                    return redirect()->route('recruitment.view_job', ['job_title' => $this->job_title,'batch'=> $this->batch,'job_id' => $this->job_id, 'activeTab' => $this->activeTab, 'tableFilters' => $this->tableFilters]);
                                })
                                ->disabled(fn($record) => $record->movs_status != 0 && $record->letter_of_intent_status != 0 && $record->pds_status != 0  && $record->prc_status != 0 && $record->tor_status != 0 && $record->training_attended_status != 0 && $record->certificate_of_employment_status != 0 && $record->latest_appointment_status != 0 && $record->performance_rating_status != 0 && $record->cav_status != 0  && $record->neap_status != 0  ? false  : true)
                        ])
                        ->form([
                            Grid::make([
                                'default'=>2,
                                'sm'=>2
                            ])
                                ->schema([
                                    Group::make([
                                        Select::make('select')->label('Select Attachment')->options(function () {
                                            $allCases = RecruitmentLabelEnum::cases();
                                            $exceptOneCases = array_filter($allCases, fn($case) => $case !== RecruitmentLabelEnum::MOVS);
                                            $x = [];
                                            foreach ($exceptOneCases as $exceptOneCase) {
                                                $x[$exceptOneCase->value] = \App\Enums\RecruitmentLabelEnum::tryFrom($exceptOneCase->value)->shortName();
                                            }
                                            return $x;
                                        })->live(),
                                        Hidden::make('token')->reactive(),
                                        PdfViewerField::make('file')
                                            ->label(fn(Get $get) => !!$get('select') ? $get('select') : '')
                                            ->fileUrl(function (Get $get, $record, Set $set) {
                                                $set('token', true);
                                                if (!!$get('select'))
                                                {
                                                    $value = \App\Enums\RecruitmentLabelEnum::tryFrom($get('select'))?->getColumn();

                                                    if (!!$record->$value) {

                                                        $set('token', false);
                                                        $batchinfo = $record->batchInfo->id;
                                                        $batchName = $record->batchInfo->batch_name;
                                                        $jobInfo = $record->jobInfo->id;
                                                        $jobTitle = $record->jobInfo->job_title;
                                                        $filePath = "public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value;
                                                        $filePathUpdate = "public/recruitment/application/$jobTitle/$batchName/$record->email/" . $record->$value;

                                                        if (Storage::exists($filePath)) {

                                                            return Storage::url("public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value);
                                                        } else if(Storage::exists($filePathUpdate)) {
                                                            return Storage::url($filePathUpdate);

                                                        }

                                                    }
                                                    $set('token', true);
                                                    return "";
                                                }
                                                $set('token', true);
                                                return "";
                                            })->minHeight('70svh'),
                                    ]),
                                    Group::make([
                                        ViewField::make('rating')
                                            ->view('livewire.recruitment.assets.attachment_table')
                                            ->registerActions([
                                                \Filament\Forms\Components\Actions\Action::make('approved')
                                                    ->icon('heroicon-o-check')
                                                    ->color(Color::Green)
                                                    ->iconButton()
                                                    ->action(function ($record,$arguments){
                                                        $record->update([
                                                            "$arguments[id]_status"=>1
                                                        ]);
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('disapproved')
                                                    ->icon('heroicon-o-x-mark')
                                                    ->color(Color::Red)
                                                    ->iconButton()
                                                    ->action(function ($record,$arguments){
                                                        $record->update([
                                                            "$arguments[id]_status"=>2
                                                        ]);
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('comment')
                                                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                                    ->color(Color::Gray)
                                                    ->iconButton()
                                                    ->form([
                                                        TextInput::make('comment')
                                                    ])
                                                    ->modalWidth(MaxWidth::Small)
                                                    ->action(function ($data,$record,$arguments){
                                                        \App\Models\RecruitmentApplicationFileComment::create([
                                                            'application_id' => $record->id,
                                                            'comment' => $data['comment'],
                                                            'filename' => $arguments['id'],
                                                            'id_number' => Auth::user()->id_number
                                                        ]);
                                                        \App\Models\ApplicantLog::create([
                                                            'activity' => 'Commented by '.Auth::user()->name,
                                                            'message'=>$data['comment'] ,
                                                            'id_number' => Auth::user()->id_number,
                                                            'applicant_id' => $record->id,
                                                            'type'=>'1'
                                                        ]);

                                                        Notification::make()
                                                            ->title('Created successfully')
                                                            ->success()
                                                            ->send();
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('deletecomment')
                                                    ->requiresConfirmation()
                                            ])
                                    ])
                                ])
                        ])
                        ->hidden(fn($record) => $record->application_status == 0 ? false : true),
//                    Action::make('Check Filessssssss')
//                        ->modalHeading(function ($record) {
//                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
//                        })
//                        ->extraModalActions([
//                            Action::make('extraButton')
//                                ->label('Approved and proceed to validator')
//                                ->color(Color::Green)
//                                ->action(function ($record, $action) {
//                                    \App\Models\ApplicantLog::create([
//                                        'activity' => 'Approved(Check Requirements) by ' . Auth::user()->name,
//                                        'message' => "Pending => Validate",
//                                        'id_number' => Auth::user()->id_number,
//                                        'applicant_id' => $record->id,
//                                        'type' => '1'
//                                    ]);
//                                    $record->update([
//                                        'application_status' => 1
//                                    ]);
//                                    Notification::make()
//                                        ->title('Transfer Data successfully')
//                                        ->success()
//                                        ->send();
//                                    sleep(1);
//                                    return redirect()->route('recruitment.application.table', ['job_title' => $this->job_title, 'id' => $this->job_id, 'activeTab' => $this->activeTab, 'tableFilters' => $this->tableFilters]);
//                                })->disabled(fn($record) => $record->movs_status != 0 && $record->letter_of_intent_status != 0 && $record->pds_status != 0  && $record->prc_status != 0 && $record->tor_status != 0 && $record->training_attended_status != 0 && $record->certificate_of_employment_status != 0 && $record->latest_appointment_status != 0 && $record->performance_rating_status != 0 && $record->cav_status != 0   ? false  : true),
//
//                        ])
//                        ->color(Color::Yellow)->icon('heroicon-o-eye')
//                        ->hidden(fn($record) => $record->application_status == 0 ? false : true)
//                        ->form(function ($record) {
//                            return $this->allApplicantAttachment($record);
//                        })
//                        ->modalSubmitAction(false)->modalCancelAction(false)
//                        ->closeModalByClickingAway(false)->extraAttributes([
//                            'id' => 'edit-xx'
//                        ])->modalWidth(MaxWidth::ScreenLarge),
                     ######################################### View  action ##########################################
                    Action::make('View')
                        ->slideOver()
                        ->modalWidth(MaxWidth::Full)
                        ->modalHeading(function ($record) {
                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
                        })
                        ->color(Color::Blue)
                        ->icon('heroicon-o-eye')
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->form([
                            Grid::make([
                                'default'=>2,
                                'sm'=>2
                            ])
                                ->schema([
                                    Group::make([
                                        Select::make('select')->label('Select Attachment')->options(function () {
                                            $allCases = RecruitmentLabelEnum::cases();
                                            $exceptOneCases = array_filter($allCases, fn($case) => $case !== RecruitmentLabelEnum::MOVS);
                                            $x = [];
                                            foreach ($exceptOneCases as $exceptOneCase) {
                                                $x[$exceptOneCase->value] = \App\Enums\RecruitmentLabelEnum::tryFrom($exceptOneCase->value)->shortName();
                                            }
                                            return $x;
                                        })->live(),
                                        Hidden::make('token')->reactive(),
                                        PdfViewerField::make('file')
                                            ->label(fn(Get $get) => !!$get('select') ? $get('select') : '')
                                            ->fileUrl(function (Get $get, $record, Set $set) {
                                                $set('token', true);
                                                if (!!$get('select'))
                                                {
                                                    $value = \App\Enums\RecruitmentLabelEnum::tryFrom($get('select'))?->getColumn();
                                                    if (!!$record->$value) {
                                                        $set('token', false);
                                                        $batchinfo = $record->batchInfo->id;
                                                        $batchName = $record->batchInfo->batch_name;
                                                        $jobInfo = $record->jobInfo->id;
                                                        $jobTitle = $record->jobInfo->job_title;
                                                        $filePath = "public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value;
                                                        $filePathUpdate = "public/recruitment/application/$jobTitle/$batchName/$record->email/" . $record->$value;

                                                        if (Storage::exists($filePath)) {

                                                            return Storage::url("public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value);
                                                        } else if(Storage::exists($filePathUpdate)) {
                                                            return Storage::url($filePathUpdate);

                                                        }

                                                        // $batchinfo = $record->batchInfo->id;
                                                        // $jobInfo = $record->jobInfo->id;

                                                        // return Storage::url("public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value);
                                                    }
                                                    $set('token', true);
                                                    return "";
                                                }
                                                $set('token', true);
                                                return "";
                                            })->minHeight('70svh'),
                                    ]),
                                    Group::make([
                                        ViewField::make('rating')
                                            ->view('livewire.recruitment.assets.attachment_table')
                                            ->registerActions([
                                                \Filament\Forms\Components\Actions\Action::make('approved')
                                                    ->icon('heroicon-o-check')
                                                    ->color(Color::Green)
                                                    ->iconButton()
                                                    ->action(function ($record,$arguments){
                                                        $record->update([
                                                            "$arguments[id]_status"=>1
                                                        ]);
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('disapproved')
                                                    ->icon('heroicon-o-x-mark')
                                                    ->color(Color::Red)
                                                    ->iconButton()
                                                    ->action(function ($record,$arguments){
                                                        $record->update([
                                                            "$arguments[id]_status"=>2
                                                        ]);
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('comment')
                                                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                                    ->color(Color::Gray)
                                                    ->iconButton()
                                                    ->form([
                                                        TextInput::make('comment')
                                                    ])
                                                    ->modalWidth(MaxWidth::Small)
                                                    ->action(function ($data,$record,$arguments){
                                                        \App\Models\RecruitmentApplicationFileComment::create([
                                                            'application_id' => $record->id,
                                                            'comment' => $data['comment'],
                                                            'filename' => $arguments['id'],
                                                            'id_number' => Auth::user()->id_number
                                                        ]);
                                                        \App\Models\ApplicantLog::create([
                                                            'activity' => 'Commented by '.Auth::user()->name,
                                                            'message'=>$data['comment'] ,
                                                            'id_number' => Auth::user()->id_number,
                                                            'applicant_id' => $record->id,
                                                            'type'=>'1'
                                                        ]);

                                                        Notification::make()
                                                            ->title('Created successfully')
                                                            ->success()
                                                            ->send();
                                                    }),
                                                \Filament\Forms\Components\Actions\Action::make('deletecomment')
                                                    ->requiresConfirmation()
                                            ])
                                    ])
                                ])
                        ])
                        ->hidden(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? false : true),
//                    Action::make('View')
//                        ->modalHeading(function ($record) {
//                            return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
//                        })
//                        ->color(Color::Blue)->icon('heroicon-o-eye')
//                        ->hidden(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? false : true)
//                        ->form(function ($record) {
//                            return $this->allApplicantAttachment($record);
//                        })
//
//                        ->modalSubmitAction(false)
//                        ->modalCancelAction(false)
//                        ->closeModalByClickingAway(false)
//                        ->extraAttributes([
//                            'id' => 'edit-xx'
//                        ])
//                        ->modalWidth(MaxWidth::ScreenLarge),
                    // ####################################### Update information #################################################
                    EditAction::make('Updates')
                        ->modalHeading(fn($record): string => "Edit Applicant Information ($record->fname $record->lname)")
                        ->label('Update Information')
                        ->hidden(function(){
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value)) return false;
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)) return true;

                        })
                        ->mutateRecordDataUsing(function ($data, $record) {

                            $check = \App\Models\RecruitmentApplicationEligibility::where('application_code', $record->application_code)->first();
                            if ($check) {
                                $data['education'] = json_decode($check->education, true);
                                $data['training'] = json_decode($check->training, true);
                                $data['experience'] = json_decode($check->experience, true);
                                $data['eligibility'] = json_decode($check->eligibility, true);
                            } else {
                                $data['education'] = [''];
                                $data['training'] = [''];
                                $data['experience'] = [''];
                                $data['eligibility'] = [''];
                            }
                            $data['education_status'] = $check?->education_status;
                            $data['education_remarks'] = $check?->education_remarks;
                            $data['training_status'] = $check?->training_status;
                            $data['training_remarks'] = $check?->training_remarks;
                            $data['experience_status'] = $check?->experience_status;
                            $data['experience_remarks'] = $check?->experience_remarks;
                            $data['eligibility_status'] = $check?->eligibility_status;
                            $data['eligibility_remarks'] = $check?->eligibility_remarks;


                            return $data;
                        })
                        ->form([

                            Grid::make([
                                'default' => 1,
                                'sm' => 1,
                                'md' => 2
                            ])->schema([
                                Group::make([
                                    Select::make('select')->label('Select Attachment')->options(function () {
                                        $allCases = RecruitmentLabelEnum::cases();
                                        $exceptOneCases = array_filter($allCases, fn($case) => $case !== RecruitmentLabelEnum::MOVS);
                                        $x = [];
                                        foreach ($exceptOneCases as $exceptOneCase) {
                                            $x[$exceptOneCase->value] = \App\Enums\RecruitmentLabelEnum::tryFrom($exceptOneCase->value)->shortName();
                                        }
                                        return $x;
                                    })->live(),
                                    Hidden::make('token')->reactive(),
                                    PdfViewerField::make('file')
                                        ->label(fn(Get $get) => !!$get('select') ? $get('select') : '')
                                        ->fileUrl(function (Get $get, $record, Set $set) {
                                            $set('token', true);
                                            if (!!$get('select')) {
                                                $value = \App\Enums\RecruitmentLabelEnum::tryFrom($get('select'))?->getColumn();
                                                if (!!$record->$value) {
                                                    $set('token', false);

                                                    $batchinfo = $record->batchInfo->id;
                                                    $batchName = $record->batchInfo->batch_name;
                                                    $jobInfo = $record->jobInfo->id;
                                                    $jobTitle = $record->jobInfo->job_title;
                                                    $filePath = "public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value;
                                                    $filePathUpdate = "public/recruitment/application/$jobTitle/$batchName/$record->email/" . $record->$value;

                                                    if (Storage::exists($filePath)) {

                                                        return Storage::url("public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value);
                                                    } else if(Storage::exists($filePathUpdate)) {
                                                        return Storage::url($filePathUpdate);

                                                    }

                                                    // $batchinfo = $record->batchInfo->id;
                                                    // $jobInfo = $record->jobInfo->id;

                                                    // return Storage::url("public/recruitment/application/$jobInfo/$batchinfo/$record->email/" . $record->$value);
                                                }
                                                $set('token', true);
                                                return "";
                                            }
                                            $set('token', true);
                                            return "";
                                        })->minHeight('70svh'),

                                    Placeholder::make('no attachment')->extraAttributes(['class' => 'text-red-500'])->hidden(fn(Get $get) => !!$get('token') ? false : true)

                                ]),
                                // ViewField::make('attachment')->view('livewire.recruitment.assets.attachments'),
                                Group::make([
                                    Fieldset::make('Education')
                                        ->schema([

                                            Repeater::make('education')
                                                ->label(false)
                                                ->simple(
                                                    Textarea::make('education')->required()

                                                )
                                                ->defaultItems(3)->columnSpan(fn(Get $get) => !!$get('education') ? 3 : 5),
                                            Textarea::make('education_remarks')->hidden(fn(Get $get) => !!$get('education') ? false : true),
                                            Select::make('education_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('education') ? false : true),
                                        ])->columns(5)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                    Fieldset::make('Training')
                                        ->schema([
                                            Repeater::make('training')
                                                ->label(false)
                                                ->schema([
                                                    Textarea::make('title')->required()->columnSpan(2),
                                                    Textarea::make('hours')->required()->columnSpan(2),

                                                ])
                                                ->columnSpan(fn(Get $get) => !!$get('training') ? 4 : 7)->columns(4)->defaultItems(3),
                                            Textarea::make('training_remarks')->columnSpan(2)->hidden(fn(Get $get) => !!$get('training') ? false : true),
                                            Select::make('training_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('training') ? false : true)

                                        ])->columns(7)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                    Fieldset::make('Experience')
                                        ->schema([
                                            Repeater::make('experience')
                                                ->label(false)
                                                ->schema([
                                                    Textarea::make('details')->required()->columnSpan(2),
                                                    Textarea::make('years')->required()->columnSpan(2),
                                                ])
                                                ->columnSpan(fn(Get $get) => !!$get('experience') ? 4 : 7)->columns(4)->collapsible()->defaultItems(1),
                                            Textarea::make('experience_remarks')->columnSpan(2)->hidden(fn(Get $get) => !!$get('experience') ? false : true),
                                            Select::make('experience_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('experience') ? false : true)
                                        ])->columns(7)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                    Fieldset::make('Eligibility')
                                        ->schema([
                                            Repeater::make('eligibility')
                                                ->label(false)
                                                ->simple(
                                                    Textarea::make('title')->required(),
                                                )
                                                ->defaultItems(1)->columnSpan(fn(Get $get) => !!$get('eligibility') ? 3 : 5),
                                            Textarea::make('eligibility_remarks')->hidden(fn(Get $get) => !!$get('eligibility') ? false : true),
                                            Select::make('eligibility_status')->options([
                                                2 =>  \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED->value,
                                                4 =>  \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED->value,
                                            ])->default(2)->required()->hidden(fn(Get $get) => !!$get('eligibility') ? false : true),
                                        ])->columns(5)->disabled(fn($record) => $record->application_status == 2 || $record->application_status == 4 ? true : false),
                                ])->extraAttributes(['class' => 'border-2 p-5 bg-gray-100 dark:bg-transparent']),

                            ])


                        ])
                        ->action(function ($data, $record) {

                            $education = json_encode($data['education']);

                            $training = json_encode($data['training']);
                            $experience = json_encode($data['experience']);
                            $eligibility = json_encode($data['eligibility']);
                            $check = \App\Models\RecruitmentApplicationEligibility::where('application_code', $record->application_code)->first();
                            $data = [
                                'application_code' => $record->application_code,
                                'education' => $education,
                                'education_status' => !!data_get($data, 'education_status') ? $data['education_status'] : null,
                                'education_remarks' => !!data_get($data, 'education_remarks') ? $data['education_remarks'] : null,
                                'training_status' => !!data_get($data, 'training_status') ? $data['training_status'] : null,
                                'training_remarks' => !!data_get($data, 'training_remarks') ? $data['training_remarks'] : null,
                                'experience_status' => !!data_get($data, 'experience_status') ? $data['experience_status'] : null,
                                'experience_remarks' => !!data_get($data, 'experience_remarks') ? $data['experience_remarks'] : null,
                                'eligibility_status' => !!data_get($data, 'eligibility_status') ? $data['eligibility_status'] : null,
                                'eligibility_remarks' => !!data_get($data, 'eligibility_remarks') ? $data['eligibility_remarks'] : null,
                                'training' => $training,
                                'experience' => $experience,
                                'eligibility' =>  $eligibility,
                            ];
                            if ($check) {
                                $check->update($data);
                            } else {
                                \App\Models\RecruitmentApplicationEligibility::create($data);
                            }
                            $finalMessage = implode(',<br> ', array_map(function ($k, $v) {
                                return "$k: $v";
                            }, array_keys($data), $data));
                            \App\Models\ApplicantLog::create([
                                'activity' => 'Updated by ' . Auth::user()->name . '(UPDATE INFORMATION)',
                                'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'>
                                    $finalMessage
                                <br></main>
                                "),
                                'id_number' => Auth::user()->id_number,
                                'applicant_id' => $record->id,
                                'type' => '1'
                            ]);

                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                        })
                        ->modalWidth(MaxWidth::Full)->color(Color::Green)
                        ->hidden(fn($record) => $record->application_status == 1 || $record->application_status == 2 || $record->application_status == 4 ? false : true),
                    // ####################################### Activity log Action #################################################
                    Action::make('logs')
                        ->label('Activity Logs')
                        ->icon('heroicon-o-clock')
                        ->modalContent(function ($record) {
                            // $logs = \App\Models\ApplicantLog::with('employeeInfo')->where('applicant_id', $record->id)->orderByDesc('id')->get();
                            $logs = $record->activities;
                            return view('livewire.recruitment.activity_log', compact('logs'));
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->color(Color::Gray)->modalWidth(MaxWidth::ScreenExtraLarge),

                    // ####################################### APPLICANT IES #################################################
                    Action::make('ies')
                        ->label('Applicant IES FILE')
                        ->extraModalActions([

                            EditAction::make('statusx')
                                ->icon('heroicon-o-arrow-up-tray')
                                ->modalHeading('Upload File')
                                ->color(Color::Amber)
                                ->label('Upload File')
                                ->form([

                                    FileUpload::make('ies_file')
                                        ->directory('recruitment/application/ies')->acceptedFileTypes(['application/pdf'])->preserveFilenames()->getUploadedFileNameForStorageUsing(
                                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                                ->prepend(time() . '-/-'),
                                        )
                                ])
                                ->modalWidth(MaxWidth::Small)
                                ->modalSubmitActionLabel('Upload')
                                ->action(function ($data, $record) {

                                    $record->update([
                                        'ies_file'=>$data['ies_file']
                                    ]);
                                    Notification::make()
                                        ->title('Uploaded Successfully')
                                        ->success()
                                        ->send();
                                }),

                        ])
                        ->hidden(function(){
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT->value)) return false;
                            if(Auth::user()->can(\App\Enums\UserManagement\PermissionEnum::RECRUITMENT_VIEW->value)) return true;


                        })
                        ->icon('heroicon-o-arrow-up-tray')
                        ->modalHeading(fn($record) => "$record->fname $record->mname $record->lname")
                        ->form([
                            PdfViewerField::make('IES WITH SIGNED')
                            ->label('IES WITH SIGN')
                                   ->minHeight('70svh')
                                   ->fileUrl(function ($record){



                                        return Storage::url("public/$record->ies_file");

                                   })->hidden(fn($record): bool => !!$record->ies_file ? false : true),
                        ])->modalSubmitAction(false)->modalCancelAction(false),
                ])->extraAttributes(['title' => 'Action button'])
            ])
            ->bulkActions($this->bulkAction())
            ->checkIfRecordIsSelectableUsing(function ($record) {

                // CHECK IF APPLICANT AY MERON NG EDUCATION,TRAINING,EXPERIENCE,ELIGIBILITY DATA PAG WALA PA NAKA DISABLE LANG YUNG CHECKBOX
                if ($this->activeTab != 'validator') {
                    return true;
                } else {
                    return !!$record->eligibilityInfo  ? true : false;
                }
            })
            ->recordClasses(function ( $record){
               return $record->batchInfo?->hired_applicant_id == $record?->application_code ? 'hired' : null;

            })
            ->paginationPageOptions(['1', '5', '10', '20', '30', 'all'])
            ->striped()
            ->defaultSort('lname', 'asc');
    }




    public function mount($job_title, $job_id)
    {

        $slug = str_replace('-', ' ', $job_title);
        $slug = strtolower($slug);
        $this->job_title = Str::upper($slug);
        $this->job_id = $job_id;

        $this->batches = RecruitmentJobBatch::where('job_id', $job_id)->get();
    }
    public function updated($property)
    {
        if ($property == 'batch') {
            $this->changeBatch();
            $this->resetPage();
            $this->resetTable();


            $this->deselectAllTableRecords();
            $this->activeTab = 'all';
        }
    }
    // ############# update job information ##########################
    public function modalFormUpdateJobAction()
    {
        return \Filament\Actions\EditAction::make('modalFormUpdateJob')
            ->record($this->jobInfo)
            ->size('xs')
            ->icon('heroicon-o-pencil-square')
            ->label("Update Position")
            ->modalHeading(fn($record) => "Update - $record->job_title")
            ->slideOver()
            ->mutateRecordDataUsing(function (array $data, $record): array {

                $data['batch'] = $this->currentBatch?->batch_name;
                $data['closing_date'] = $this->currentBatch?->closing_date;
                $data['posting_date'] = $this->currentBatch?->posting_date;
                // $data['status_of_hiring'] = $record->batchInfo?->status;

                return $data;
            })
            ->form([

                Fieldset::make('Basic Information of the Position')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Select::make('status_of_appointment')->options([
                                'Permanent' => 'Permanent',
                                'Contractual' => 'Contractual',
                                'Contract of Service' => 'Contract of Service',
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
                    ])->fileAttachmentsDirectory('recruitment/job')->extraAttributes([
                        'style' => 'max-height:30rem'
                    ])->grow(false)


            ])
            ->action(function ($data, $record) {
                $this->currentBatch?->update([
                    'closing_date' => $data['closing_date'],
                    'posting_date' => $data['posting_date'],

                ]);
                $plantilla = !!data_get($data, 'plantilla_item') ? $data['plantilla_item'] : '';
                \App\Models\RecruitmentJobActivity::create([
                    'activity' => 'Updated by ' . Auth::user()->name,
                    'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'><p class='font-bold'>$data[job_title] - " . $this->currentBatch?->batch_name . "<p><br>
                        job_title => $data[job_title]<br>
                        status_of_hiring => $data[status_of_hiring]<br>
                        status_of_appointment => $data[status_of_appointment]<br>
                        plantilla_item =>  $plantilla<br>
                        salary_grade => $data[salary_grade]<br>
                        place_of_assignment => $data[place_of_assignment]<br>

                        application_code => $data[application_code]<br>
                        education => $data[education]<br>
                        training => $data[training]<br>
                        experience => $data[experience]<br>
                        eligibility => $data[eligibility]<br>

                    </main>"),
                    'id_number' => Auth::user()->id_number,
                    'type' => '1',
                    'job_id' => $record->job_id
                ]);
                $arr = [
                    'job_title' => $data['job_title'],
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
                    $record->update($arr);
                } else {

                    $job =  $record->update($arr);
                }
                \App\Models\RecruitmentMonitoring::where('batch_id', $this->currentBatch?->batch_id)->update([
                    'job_id' =>  $record->job_id,
                    'unfilled_position' => $data['job_title'],
                    'dbm_plantilla_item_number' =>  $plantilla,
                    'deadline_on_the_submmision_of_application' => Carbon::parse($data['closing_date'])->format('F d, Y'),
                    'date_of_publication' => Carbon::parse($data['posting_date'])->format('F d, Y'),
                    'issuance_of_regional_memo' => Carbon::parse($data['posting_date'])->format('F d, Y'),
                ]);

                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
            })
            ->modalWidth(MaxWidth::ScreenMedium)->color(Color::Green)
            ->tooltip('Update Basic Details of Position(position title,platilla item, posting date, closing date etc.)');
    }
    // ############# change batch  ##########################
    public function modalFormChangeBatchAction()
    {
        return \Filament\Actions\EditAction::make('modalFormChangeBatch')
            ->record($this->jobInfo)
            ->size('xs')
            ->label('Change Batch')
            ->icon('heroicon-o-arrow-path')
            ->modalHeading(fn($record) => "Change Batch - $record->job_title")
            ->mutateRecordDataUsing(function (array $data, $record): array {
                $this->options = [];
                $data['batch'] = $record->batchInfo?->batch_id;

                return $data;
            })
            ->form([
                Select::make('batch')
                    ->options(function ($record) {
                        $oldOption = RecruitmentJobBatch::where('job_id', $record->job_id)->orderByDesc('id')->get()->pluck('batch_name', 'batch_id')->all();
                        foreach ($oldOption as $key => $option) {
                            $this->options[$key] = $option;
                        }
                        return $this->options;
                    })
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('batch_no')->label('Batch name')->required()->rules('required'),
                    ])

                    ->createOptionUsing(function (array $data, $record): String {

                        $id = RecruitmentJobBatch::create([
                            'job_id' => $record->job_id,
                            'batch_name' => $data['batch_no'],
                            'status' => 0,
                            'batch_id' => Str::uuid(),
                        ]);
                        \App\Models\RecruitmentMonitoring::create([
                            'job_id' =>  $record->job_id,
                            'batch_id' => $id->batch_id,
                            'unfilled_position' => $record->job_title,
                            'dbm_plantilla_item_number' => $record->plantilla_item,

                        ]);
                        return $id->batch_id;
                    })->live()->required()
                    ->editOptionForm([
                        TextInput::make('batch_no')
                            ->required(),

                    ])->fillEditOptionActionFormUsing(function (Get $get) {
                        $info =  RecruitmentJobBatch::select('batch_id', 'batch_name')->where('batch_id', $get('batch'))->first();
                        return [
                            'batch_no' => $info?->batch_name
                        ];
                    })->updateOptionUsing(function ($data, Get $get) {
                        RecruitmentJobBatch::select('batch_id', 'batch_name')->where('batch_id', $get('batch'))->update([
                            'batch_name' => $data['batch_no']
                        ]);
                    }),
            ])
            ->modalWidth(MaxWidth::Small)
            ->action(function ($data, $record) {

                foreach ($this->options as $key => $option) {

                    if (Str::isUuid($key)) {

                        RecruitmentJobBatch::where('batch_id', '=', $key)->update([
                            'status' => $key == $data['batch'] ? 1 : 0,
                        ]);
                    } else {
                        RecruitmentJobBatch::create([
                            'job_id' => $record->job_id,
                            'batch_name' => $option,
                            'status' => $key == $data['batch'] ? 1 : 0,
                            'batch_id' => Str::uuid(),
                        ]);
                    }
                }
                \App\Models\RecruitmentJobActivity::create([
                    'activity' => 'Batch Update by ' . Auth::user()->name,
                    'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'><p class='font-bold'>$record->job_title - " . $record->batchInfo?->batch_name . "<p><br></main>
                 "),
                    'id_number' => Auth::user()->id_number,
                    'type' => '1',
                    'job_id' => $record->job_id
                ]);

                sleep(1);
                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->send();
            })
            ->color(Color::Orange)
            ->tooltip('CHANGE CURRENT BATCH / EDIT BATCH / ADD NEW BATCH');
    }
    // ############# PSB & OTHER INFORMATION  ##########################
    public function modalFormPsbAndOtherInformationAction()
    {
        return \Filament\Actions\EditAction::make('modalFormPsbAndOtherInformation')
            ->record($this->jobInfo)
            ->size('xs')
            ->slideOver()
            ->mutateRecordDataUsing(function (array $data, $record): array {
                $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::where('job_id', $record->job_id)->where('batch_id', $this->currentBatch?->batch_id)->first();

                $data['initial_evaluation_report'] = $otherInformation?->initial_evaluation;
                $data['open_ranking'] = $otherInformation?->open_ranking;
                $data['venue'] = $otherInformation?->venue;
                $data['exam'] = $otherInformation?->exam;
                $data['interview'] = $otherInformation?->interview;
                $data['type'] = $otherInformation?->type;
                $data['category'] = $otherInformation?->category;
                $data['min_requirements_education'] = $otherInformation?->min_requirements_education;
                $data['min_requirements_training'] = $otherInformation?->min_requirements_training;
                $data['min_requirements_experience'] = $otherInformation?->min_requirements_experience;

                if ($otherInformation) {
                    $data['psb'] = \App\Models\RecruitmentJobPsb::select('otherinformation_id', 'id_number')->where('otherinformation_id', $otherInformation->id)->get()->pluck('id_number')->toArray();
                }

                return $data;
            })
            ->modalHeading(fn($record) => "Update - PSB & other information($record->job_title)")
            ->label('PSB & other information')
            ->icon('heroicon-o-shield-check')
            ->form([
                Grid::make([
                    'default' => 2
                ])->schema([
                    Group::make([
                        Section::make('PSB DETAILS')->schema([
                            Select::make('psb')->label('Select PSB')
                                ->multiple()
                                ->options(User::select('name', 'id_number')->get()->pluck('name', 'id_number')),
                            TextInput::make('venue'),
                            DateTimePicker::make('initial_evaluation_report'),
                            DateTimePicker::make('open_ranking'),
                            DateTimePicker::make('exam'),
                            DateTimePicker::make('interview'),
                        ]),
                    ]),
                    Group::make([
                        Section::make('IER DETAILS')->schema([
                            Select::make('type')
                                ->options([
                                    'Related-Teaching Positions' => 'Related-Teaching Positions',
                                    'Non-Teaching Positions' => 'Non-Teaching Positions',
                                ])->live()->required()->rules(['required']),

                            Select::make('category')
                                ->options(function (Get $get) {
                                    if (!!$get('type') && $get('type') == 'Related-Teaching Positions') {
                                        return [
                                            'SG 11-15' => 'SG 11-15',
                                            'SG 16-23 and SG-27' => 'SG 16-23 and SG-27',
                                            'SG-24(Chief)' => 'SG-24(Chief)',
                                        ];
                                    } elseif (!!$get('type') && $get('type') == 'Non-Teaching Positions') {
                                        return [
                                            'General Services' => 'General Services',
                                            'SG 1-9 (None-General Services)' => 'SG 1-9 (None-General Services)',
                                            'SG 10-22 and SG 27' => 'SG 10-22 and SG 27',
                                            'SG-24(Chief)' => 'SG-24(Chief)',
                                        ];
                                    }
                                })->hidden(fn(Get $get) => !!$get('type') ? false : true)->required()->rules(['required']),
                            Grid::make([
                                'default' => 3
                            ])->schema([
                                TextInput::make('min_requirements_education')->numeric()->minValue(1)->required()->rules(['required']),
                                TextInput::make('min_requirements_training')->numeric()->minValue(1)->required()->rules(['required']),
                                TextInput::make('min_requirements_experience')->numeric()->minValue(1)->required()->rules(['required']),
                            ])

                        ]),
                    ])

                ])
            ])
            ->color(Color::Blue)
            ->action(function ($data, $record) {

                $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::query()->where('job_id', $record->job_id)->where('batch_id', $this->currentBatch?->batch_id)->first();
                if ($otherInformation) {

                    $otherInformation->update([
                        'initial_evaluation' => $data['initial_evaluation_report'],
                        'venue' => $data['venue'],
                        'open_ranking' => $data['open_ranking'],
                        'exam' => $data['exam'],
                        'interview' => $data['interview'],
                        'type' => $data['type'],
                        'category' => $data['category'],
                        'min_requirements_education' => $data['min_requirements_education'],
                        'min_requirements_training' => $data['min_requirements_training'],
                        'min_requirements_experience' => $data['min_requirements_experience'],

                    ]);
                } else {
                    $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::create([
                        'initial_evaluation' => $data['initial_evaluation_report'],
                        'venue' => $data['venue'],
                        'open_ranking' => $data['open_ranking'],
                        'exam' => $data['exam'],
                        'interview' => $data['interview'],
                        'type' => $data['type'],
                        'category' => $data['category'],
                        'min_requirements_education' => $data['min_requirements_education'],
                        'min_requirements_training' => $data['min_requirements_training'],
                        'min_requirements_experience' => $data['min_requirements_experience'],
                        'batch_id' => $this->currentBatch?->batch_id,
                        'job_id' => $record?->job_id,
                    ]);
                }
                \App\Models\RecruitmentJobPsb::query()->where('otherinformation_id', $otherInformation->id)->delete();
                $users = [];
                $datetime = !!$data['open_ranking'] ? Carbon::parse($data['open_ranking'])->format('M d, Y h:i:s A') : '';
                $datetimeier = !!$data['initial_evaluation_report'] ? Carbon::parse($data['initial_evaluation_report'])->format('M d, Y h:i:s A') : '';
                foreach ($data['psb'] as $key => $psb) {

                    Notification::make()
                        ->icon('heroicon-o-folder')
                        ->iconColor(Color::Yellow)
                        ->title('Assigned Job')
                        ->body(new HtmlString("$record->job_title - " . $this->currentBatch?->batch_name . "<br> <strong>Open ranking: " . $datetime . "</strong>" . "<br> <strong>IER: " . $datetimeier . "</strong>"))
                        ->success()
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('view')
                                ->url(route('recruitment.psb.applicant', ['job_title' => $record->job_title, 'job_batch' => $this->currentBatch?->batch_id, 'job_id' => $record->job_id])),
                            \Filament\Notifications\Actions\Action::make('markAsRead')
                                ->link()
                                ->color(Color::Red)
                                ->markAsRead(),
                        ])
                        ->sendToDatabase(User::where('id_number', $psb)->first());
                    $user = User::where('id_number', $psb)->first();
                    $users[] = $user->name;
                    \App\Models\RecruitmentJobPsb::create([
                        'id_number' => $psb,
                        'batch_id' => $this->currentBatch?->batch_id,
                        'job_id' => $record?->job_id,
                        'otherinformation_id' => $otherInformation->id,
                    ]);
                }
                $finaluser = implode(', ', $users);
                \App\Models\RecruitmentJobActivity::create([
                    'activity' => 'Updated by ' . Auth::user()->name . '(PSB & Other Information)',
                    'message' => new htmlString("<main class='text-gray-500 dark:text-gray-400'>
                    'PSB' => ($finaluser)<br>
                    'initial_evaluation' => $data[initial_evaluation_report]<br>
                    'open_ranking' => $data[open_ranking]<br>
                    'exam' => $data[exam]<br>
                    'interview' => $data[interview]<br>
                    </main>"),
                    'id_number' => Auth::user()->id_number,
                    'type' => '1',
                    'job_id' => $record->job_id
                ]);


                Notification::make()
                    ->title('Updated successfully')
                    ->success()
                    ->duration(2000)
                    ->send();
            })
            ->modalWidth(MaxWidth::Full)
            ->tooltip("SELECT PSB / UPDATE EIR DETAILS");
    }
    // ############# ACTIVITY LOG ##########################
    public function modalFormActivityLogAction()
    {
        return \Filament\Actions\EditAction::make('modalFormActivityLog')
            ->record($this->jobInfo)
            ->size('xs')
            ->label('Activity Logs')
            ->modalHeading(fn($record) => "$record->job_title")
            ->icon('heroicon-o-clock')
            ->modalContent(function ($record) {
                $logs = \App\Models\RecruitmentJobActivity::where('job_id', $record->job_id)->orderByDesc('id')->get();
                return view('livewire.recruitment.activity_log', compact('logs'));
            })
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->color(Color::Gray)
            ->tooltip("ACTIVITY LOGS");
    }
    // ############# CAR FILE ##########################
    public function modalFormCarFileAction()
    {
        return \Filament\Actions\EditAction::make('modalFormCarFile')
            ->record($this->jobInfo)
            ->label('CAR FILE')
            ->size('xs')
            ->extraModalActions([
                \Filament\Actions\EditAction::make('statusx')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->modalHeading('Upload File')
                    ->color(Color::Amber)
                    ->label('Upload File')
                    ->mutateRecordDataUsing(function (array $data, $record): array {


                        $data['car_file'] = $this->currentBatch?->car_file;
                        $data['notification_letter'] = $this->currentBatch?->notification_letter;
                        $data['hired_applicant_id'] = $this->currentBatch?->hired_applicant_id;
                        return $data;
                    })
                    ->form([

                        FileUpload::make('car_file')
                            ->directory('recruitment/application/car')->acceptedFileTypes(['application/pdf'])->preserveFilenames()->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName()),
                            ),
                        Select::make('hired_applicant_id')
                            ->label('Hired')
                            ->options(function ($record) {
                                $batch = $this->currentBatch?->batch_id;
                                $job_id = $record->job_id;
                                $applicants = \App\Models\RecruitmetJobApplication::where('job_id', $job_id)->where('batch_id', $batch)->where('application_status', 2)->get();
                                $applicantArray = [];
                                foreach ($applicants as $applicant) {
                                    $applicantArray[$applicant->application_code] = "$applicant->fname $applicant->mname $applicant->lname";
                                }

                                return $applicantArray;
                            })
                            ->searchable()->required()->rules('required'),
                        FileUpload::make('notification_letter')
                            ->directory('recruitment/application/notification_letter')->acceptedFileTypes(['application/pdf'])->preserveFilenames()->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName()),
                            )
                    ])
                    ->modalWidth(MaxWidth::Small)
                    ->modalSubmitActionLabel('Upload')
                    ->action(function ($data, $record) {

                        $this->currentBatch->update([
                            'car_file' => $data['car_file'],
                            'hired_applicant_id' => $data['hired_applicant_id'],
                            'notification_letter' => $data['notification_letter'],
                        ]);
                        Notification::make()
                            ->title('Uploaded Successfully')
                            ->success()
                            ->send();
                    }),

            ])
            ->icon('heroicon-o-arrow-up-tray')
            ->modalHeading(fn($record) => "$record->job_title")
            ->form([
                Grid::make([
                    'default' => 2,
                    'sm' => 1,
                    'md' => 2
                ])->schema([
                    PdfViewerField::make('CAR WITH SIGNED')
                        ->label('CAR WITH SIGN')
                        ->minHeight('70svh')
                        ->fileUrl(function ($record) {
                            $file = $this->currentBatch?->car_file;
                            return Storage::url("public/$file");
                        })->hidden(fn($record): bool => !!$this->currentBatch?->car_file ? false : true),
                    PdfViewerField::make('notification_letter')
                        ->label(fn($record) => "NOTIFICATION LETTER (" . $this->currentBatch?->hiredInfo?->fname . " " . $this->currentBatch?->hiredInfo?->mname . " " . $this->currentBatch?->hiredInfo?->lname . ")")
                        ->minHeight('70svh')
                        ->fileUrl(function ($record) {
                            $file = $this->currentBatch?->notification_letter;
                            return Storage::url("public/$file");
                        })->hidden(fn($record): bool => !!$this->currentBatch?->notification_letter ? false : true),
                ])

            ])
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->modalWidth(MaxWidth::Full)
            ->tooltip("Upload the signed car document, upload the notification letter, and select the hired applicant.");
    }

    ######################### PSB GRADING ######################
    public function modalFormPsbGradingAction()
    {
        return \Filament\Actions\EditAction::make('modalFormPsbGrading')
            ->record($this->jobInfo)
            ->icon('heroicon-o-star')
            ->size('xs')
            ->label('PSB GRADING')
            ->url(route('recruitment.psb_personnel_grading', ['job_id' => $this->job_id, 'job_title' => $this->job_title,'job_batch'=>$this->batch]))
            ->tooltip("Monitor applicant grades.");
    }

    ######################### CHANGE BATCH FILTER ######################
    public function changeBatch()
    {
        $this->currentBatch = RecruitmentJobBatch::with('hiredInfo')->where('batch_id', $this->batch)->first();
        $this->psbMembers = \App\Models\RecruitmentJobPsb::with('psbInformation')->where('job_id', $this->job_id)->where('batch_id', $this->batch)->get();
        $this->jobInfo = \App\Models\Recruitment_Job::with(['batchInfo' => function ($q) {
            $q->where('status', 1)->with(['hiredInfo' => function ($q) {
                $q->select('fname', 'mname', 'lname', 'application_code');
            }]);
        }])->withCount(['allApplicant' => function ($q) {
            $q->where('batch_id', $this->batch);
        }])->where('job_id', $this->job_id)->first();
    }
    public function render()
    {
        $this->changeBatch();
        $allCount = \App\Models\RecruitmetJobApplication::query()->select('job_id','batch_id')->where('job_id', $this->job_id)->where('batch_id', $this->batch)->get()->count();
        $checkFileCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 0)->where('batch_id', $this->batch)->where('job_id', $this->job_id)->get()->count();
        $validatorCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 1)->where('batch_id', $this->batch)->where('job_id', $this->job_id)->get()->count();
        $qualifiedCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 2)->where('batch_id', $this->batch)->where('job_id', $this->job_id)->get()->count();
        $notqualifiedCount = \App\Models\RecruitmetJobApplication::query()->where('application_status', 4)->where('batch_id', $this->batch)->where('job_id', $this->job_id)->get()->count();
        return view('livewire.recruitment.view-job-information',compact('checkFileCount', 'validatorCount', 'qualifiedCount', 'allCount', 'notqualifiedCount'))->title($this->job_title);
    }
}


