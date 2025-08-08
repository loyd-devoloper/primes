<?php

namespace App\Livewire\Recruitment;

use App\Traits\RecruitmentPsbTrait;
use Carbon\Carbon;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Filament\Actions\EditAction;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use App\Enums\RecruitmentLabelEnum;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Traits\RecruitmentAttachmentFunctionTrait;
use Joaopaulolndev\FilamentPdfViewer\Forms\Components\PdfViewerField;

class PsbApplicant extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use RecruitmentAttachmentFunctionTrait;
    use RecruitmentPsbTrait;
    use InteractsWithActions;

    public $job_title = '';
    public $job_id = '';

    public $allData = null;
    #[Url()]
    public $tableSearch = '';
    #[Url]
    public ?array $tableFilters = null;


    public $totals = 'dsadsadsadsad';

    public $arrData;

    public function table(Table $table): Table
    {


        $query = \App\Models\RecruitmetJobApplication::query()->with(['myGrade' => function ($q) {
            $q->where('id_number', Auth::user()->id_number);
        },'applicantGrades' => function ($q) {
            $q->with('psbInfo');
        }, 'eligibilityInfo', 'activities', 'activitiesEmail', 'batchInfo', 'jobInfo', 'jobOtherInformation' => fn($q) => $q->where('job_id', $this->job_id)])
            ->whereHas('jobInfo', function ($q) {
                $q->where('status_of_hiring', '1');
            })->where(function ($q) {
                $q->where('application_status', 1)->orWhere('application_status', 2);
            })->where('job_id', $this->job_id);

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('application_code')
                    ->label('Applicant Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('batch_id')
                    ->label('Batch')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->state(fn($record) => $record->batchInfo?->batch_name),
                TextColumn::make('fullname')
                    ->label('Applicant Name')
                    ->searchable(['fname', 'lname', 'mname'])
//                    ->sortable(['lname'])
                    ->state(fn($record) => new HtmlString($record?->lname . ',<br> ' . $record?->fname . ' ' . $record?->mname)),

                TextColumn::make('email')
                    ->label('Applicant Email')
                    ->searchable()->copyable()->state(fn($record) => $record?->email)
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mobile_number')
                    ->label('Applicant Mobile Number')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->state(fn($record) => $record?->mobile_number),
                TextColumn::make('address')
                    ->label('Applicant Address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->state(fn($record) => $record?->address)
                    ->extraAttributes(['class' => ' break-all break-words  w-[2rem] overflow-hidden'])
                    ->wrap(),
                TextColumn::make('myGrade')
                    ->state(function ($record): array {
                        $education = $record?->myGrade?->education_total;
                        $traning = $record?->myGrade?->training_total;
                        $experience = $record?->myGrade?->experience_total;
                        $performance = $record?->myGrade?->performance_total;
                        $outstanding = $record?->myGrade?->outstanding;
                        $application_of_education = $record?->myGrade?->application_of_education;
                        $l_and_d = $record?->myGrade?->l_and_d;
                        $we = $record?->myGrade?->we;
                        $wst = $record?->myGrade?->wst;
                        $bei = $record?->myGrade?->bei;
                        $count =  $record?->applicantGrades->where('potential_total','!=', null)->where('potential_total','!=', 0)->count();
                        $subtotal = (float)$record?->myGrade?->education_total + (float)$record?->myGrade?->training_total + (float)$record?->myGrade?->experience_total + (float)$record?->myGrade?->performance_total + (float)$record?->myGrade?->outstanding + (float)$record?->myGrade?->application_of_education + (float)$record?->myGrade?->l_and_d;
                        $subtotal += $count != 0 ? (float)$record?->applicantGrades->sum('potential_total') / $count : 0;
                        $formatedSubTotal = number_format($subtotal,2,'.',',');
                        return ["Education: $education", "Training: $traning", "Experience: $experience", "Performance: $performance", "Outstanding: $outstanding", "Application of Education: $application_of_education", "Application of L&D: $l_and_d","WE: $we","WST: $wst","Bei: $bei", "Sub total:  $formatedSubTotal"];
                    })
                    ->listWithLineBreaks()
                    ->limitList(1)
                    ->badge()
                    ->color(Color::Green)
                    ->expandableLimitedList(),

                TextColumn::make('applicantGrades')
                    ->label('Final Points')
                    ->state(function ($record) {
                    $totalqs = 0;
                    $totalPotential = 0;
                    $count =  $record?->applicantGrades->where('potential_total','!=', null)->where('potential_total','!=', 0)->count();
                    $totalPotential = (float)$record?->myGrade?->education_total + (float)$record?->myGrade?->training_total + (float)$record?->myGrade?->experience_total + (float)$record?->myGrade?->performance_total + (float)$record?->myGrade?->outstanding + (float)$record?->myGrade?->application_of_education + (float)$record?->myGrade?->l_and_d;
                    $totalPotential += $count != 0 ? (float)$record?->applicantGrades->sum('potential_total') / $count : 0;


                    return number_format($totalPotential,2,'.',',');

                })
                    ->sortable(),
                // TextColumn::make('created_at')->label('Submited At')->state(fn($record) => Carbon::parse($record->created_at)->format('M d, Y h:m:s A'))->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('application_status')
                    ->label('Applicant Status')
                    ->state(function ($record) {
                        return match ($record->application_status) {
                            0 => \App\Enums\RecruitmemtApplicantStatusEnum::PENDING,
                            1 => \App\Enums\RecruitmemtApplicantStatusEnum::VALIDATE,
                            2 => \App\Enums\RecruitmemtApplicantStatusEnum::QUALIFIED,
                            4 => \App\Enums\RecruitmemtApplicantStatusEnum::NOT_QUALIFIED,
                        };
                    })
                    ->badge()
                    ->color(function ($record) {
                        return match ($record->application_status) {
                            0 => Color::Yellow,
                            1 => Color::Blue,
                            2 => Color::Green,
                            4 => Color::Red,
                        };
                    }),

            ])
            ->actions([

                // ######################################### View  action ##########################################
               Action::make('View')
                    ->modalHeading(function ($record) {
                        return new HtmlString("<h1 class='text-black dark:text-white'> $record->fname $record->lname</h1> <h1 class='text-black dark:text-white'>$record->email</h1>");
                    })
                    ->color(Color::Blue)->icon('heroicon-o-eye')
                    ->slideOver()
                    ->form(
                        [

                            Split::make([
                                Section::make([
                                    Select::make('select')->label('Select Attachments')
                                        ->searchable()
                                        ->options(function () {
                                            $allCases = RecruitmentLabelEnum::cases();

                                            $exceptOneCases = array_filter($allCases, fn($case) => $case !== RecruitmentLabelEnum::MOVS);

                                            $x = [];
                                            foreach ($exceptOneCases as $exceptOneCase) {

                                                $x[$exceptOneCase->value] =\App\Enums\RecruitmentLabelEnum::tryFrom($exceptOneCase->value)->shortName();
                                            }
                                            return $x;
                                        })->live(),
                                    Hidden::make('token')->reactive(),
                                    PdfViewerField::make('file')
                                        ->reactive()
                                        ->label(fn(Get $get) => !!$get('select') ? '' : '')
                                        ->fileUrl(function (Get $get, $record, Set $set) {
                                            $set('token', true);
                                            if (!!$get('select')) {
                                                $value = RecruitmentLabelEnum::tryFrom($get('select'))?->getColumn();
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
                                        })
                                        ->minHeight('64svh'),
                                    Placeholder::make('no attachment')->extraAttributes(['class' => 'text-red-500'])->hidden(fn(Get $get) => !!$get('token') ? false : true)

                                ])->id('attachmentContainer')->extraAttributes(['wire:ignore.self' => true, 'class' => 'border-black ']),
                                Section::make([
                                    Placeholder::make('created')->label(function ($record) {

                                        $type = $record?->jobOtherInformation?->type;
                                        $category = $record?->jobOtherInformation?->category ;
                                        $newCategory = $category == 'SG 1-9 (None-General Services)' ? 'SG 1-9 (Non-General Services)' : $category;
                                        return "INDIVIDUAL EVALUATION SHEET (IES) - $newCategory  $type";
                                    })->content(function ($record) {
                                        $position = $record->jobInfo?->job_title;
                                        $category = $record?->jobOtherInformation?->category;
                                        $newCategory = $category == 'SG 1-9 (None-General Services)' ? 'SG 1-9 (Non-General Services)' : $category;
                                        return new HtmlString(
                                            "
                                        <p class='psbAllicantInformationDesign'>Name of Applicant: <span class='underline font-bold'>$record->lname, $record->fname $record->mname</span></p>
                                        <p class='psbAllicantInformationDesign'>Position Applied For : <span class='underline font-bold'>$position</span></p>
                                        <p class='psbAllicantInformationDesign'>Contact Number :  <span class='underline font-bold'>$record->mobile_number</span></p>
                                        <p class='psbAllicantInformationDesign'>Job Group/SG-Level :  <span class='underline font-bold'> $newCategory </span> <span></span></p>
                                        "
                                        );
                                    }),
                                    ViewField::make('EDUCATION')
                                        ->view('livewire.recruitment.assets.psb_grading')
                                        ->extraAttributes(['class' => 'overflow-y-auto max-h-[20svh] !bg-red-500'])
                                        ->registerActions([
                                            \Filament\Forms\Components\Actions\Action::make('BulkActions')
                                                ->requiresConfirmation()
                                                ->action(function () {
                                                    dd($this->arrData);
                                            })
                                        ])


                                ])->extraAttributes(['class' => ' border-2 overflow-y-auto max-h-[20svh] p-5 bg-gray-100 dark:bg-transparent'])
                            ])->extraAttributes(['class' => 'gradeContainer ', 'wire:ignore.self' => true]),
                        ]

                    )
                    ->modalSubmitAction(false)


                    ->modalCancelActionLabel('Close')
                    ->closeModalByClickingAway(false)
                    ->extraAttributes([
                        'id' => 'edit-xx'
                    ])

                    ->modalWidth(MaxWidth::Full),


            ])
            ->paginationPageOptions(['1', '5', '10', '20', '30', 'all'])->striped()
            ->defaultSort('lname', 'asc');
    }

    public function saveGrade($data)
    {

        $data['id_number'] = Auth::user()->id_number;
        $jobId = $data['job_id'];
        $batchId = $data['batch_id'];
        $applicantId = $data['applicant_id'];
        \App\Models\RecruitmentPsbGrade::updateOrCreate(
            [
                'job_id' => $jobId,
                'batch_id' => $batchId,
                'id_number' => Auth::user()->id_number,
                'applicant_id' => $applicantId
            ],
            $data
        );
        Notification::make()
            ->title('Updated successfully')
            ->success()
            ->send();
    }

    public function saveGradeBulk($data)
    {

        $psbs = \App\Models\RecruitmentJobPsb::query()->where('job_id', $data['job_id'])->where('batch_id', $data['batch_id'])->get();

        foreach ($psbs as $psb)
        {
            $data['id_number'] = $psb?->id_number;
            $jobId = $data['job_id'];
            $batchId = $data['batch_id'];
            $applicantId = $data['applicant_id'];
            $checkPsbGrade = \App\Models\RecruitmentPsbGrade::query()
                ->where('job_id', $jobId)
                ->where('id_number',  $psb?->id_number)
                ->where('batch_id', $batchId)
                ->where('applicant_id', $applicantId)
                ->first();
            $alwaysNew = $data;
            if (array_key_exists('bei', $alwaysNew)) {
                unset($alwaysNew['bei']);
            }
            if (array_key_exists('potential_total', $alwaysNew)) {
                unset($alwaysNew['potential_total']);
            }
            if (!!$checkPsbGrade?->bei || (float)$checkPsbGrade?->bei != 0)
            {




                if (!!$alwaysNew['we'] && !!$alwaysNew['wst'])
                {
                    $total = (float)$checkPsbGrade->bei + (float)$alwaysNew['we']  + (float)$alwaysNew['wst'];
                    $alwaysNew['potential_total'] = $total;
                }else if(!!$alwaysNew['we'] && ( $alwaysNew['wst'] == '' ||  $alwaysNew['wst'] == 0))
                {
                    $total = (float)$checkPsbGrade->bei + (float)$alwaysNew['we'];
                    $alwaysNew['potential_total'] = $total;
                }else if(!!$alwaysNew['wst'] && ( $data['we'] == '' ||  $alwaysNew['we'] == 0))
                {
                    $total = (float)$checkPsbGrade->bei + (float)$alwaysNew['wst'];
                    $alwaysNew['potential_total'] = $total;
                }


            }else{
                if (array_key_exists('we', $alwaysNew)) {
                    unset($alwaysNew['we']);
                }
                if (array_key_exists('wst', $alwaysNew)) {
                    unset($alwaysNew['wst']);
                }

            }




            \App\Models\RecruitmentPsbGrade::updateOrCreate(
                [
                    'job_id' => $jobId,
                    'batch_id' => $batchId,
                    'id_number' => $psb?->id_number,
                    'applicant_id' => $applicantId
                ],
                $alwaysNew
            );
        }


        Notification::make()
            ->title('Updated successfully')
            ->success()
            ->send();
    }

    public function save()
    {
        dd('dsadad');
    }

    #[Title('PSB - Applicant')]
    public function render()
    {
        $validatorCount = \App\Models\RecruitmetJobApplication::query()->whereHas('batchInfo', function ($q) {
            $q->where('status', 1);
        })->where('application_status', 2)->where('job_id', $this->job_id)->get()->count();
        return view('livewire.recruitment.psb-applicant', compact('validatorCount'));
    }
}
