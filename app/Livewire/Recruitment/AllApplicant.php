<?php

namespace App\Livewire\Recruitment;

use Carbon\Carbon;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;

class AllApplicant extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;
    #[Url()]
    public $activeTab = 'all';
    public function changeTab($value)
    {
        $this->tableSearch = '';
          $this->resetPage();
           $this->deselectAllTableRecords();
           sleep(1);

        $this->activeTab = $value;
    }
    public function table(Table $table): Table
    {
        if ($this->activeTab == 'checkfile') {
            $type = 1;
            $query = \App\Models\RecruitmetJobApplication::query()->with('jobInfo','batchInfo')->where('application_status', 0);

        } elseif ($this->activeTab == 'validator') {
            $type = 2;

            $query = \App\Models\RecruitmetJobApplication::query()->with('jobInfo','batchInfo')->where('application_status', 1);
        } elseif ($this->activeTab == 'qualified') {
            $type = 3;

            $query = \App\Models\RecruitmetJobApplication::query()->with('jobInfo','batchInfo')->where('application_status', 2);
        } elseif ($this->activeTab == 'all') {
            $type = 0;

            $query = \App\Models\RecruitmetJobApplication::query()->with('jobInfo','batchInfo');
        }

        return $table
            ->query($query)

            ->columns([
                TextColumn::make('jobInfo.job_title')->label('JOB')->state(fn($record)=> $record->jobInfo?->job_title)->searchable(),

                TextColumn::make('application_code')->label('Applicant Code')->searchable(),
                TextColumn::make('batch_id')->label('Batch')->state(fn ($record) => $record->batchInfo?->batch_name),
                TextColumn::make('fullname')->label('Applicant Name')->searchable(['fname', 'lname'])->sortable(['lname'])->state(fn ($record) =>new HtmlString( $record?->lname . ',<br> ' . $record?->fname . ' ' . $record?->mname) ),
                TextColumn::make('email')->label('Applicant Email')->copyable()
                    ->copyMessage('Email address copied')->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('mobile_number')->label('Applicant Mobile Number')->toggleable(isToggledHiddenByDefault: false)->extraAttributes(['class'=>' break-all break-words  w-[2rem] overflow-hidden'])->wrap(),
                TextColumn::make('address')->label('Applicant Address')->toggleable(isToggledHiddenByDefault: false)->extraAttributes(['class'=>' break-all break-words  w-[2rem] overflow-hidden'])->wrap(),
                TextColumn::make('created_at')->label('Submited At')->state(fn ($record) => Carbon::parse($record->created_at)->format('M d, Y h:m:s A'))->toggleable(isToggledHiddenByDefault: false),
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

            ])
            ->actions([

                ViewAction::make()->url(fn ($record) => route('recruitment.view_job',
                    ['job_title' => $record->jobInfo?->job_title, 'job_id' => $record->job_id,'batch'=> $record->batchInfo?->batch_id,'tableSearch'=>$record->application_code,'tableFilters' =>  [
                    'batch' => [
                        'application_code' => $record->batchInfo?->batch_id,
                    ],
                ] ]))->extraAttributes(['wire:navigate'=>'true']),

            ])
            ->bulkActions([

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
                                if($record->application_status == 0)
                                {
                                    $status = 'Pending';
                                }elseif($record->application_status == 1)
                                {
                                    $status = 'Validate';
                                }elseif($record->application_status == 2)
                                {
                                    $status = 'Qualified';
                                }
                                elseif($record->application_status == 4)
                                {
                                    $status = 'Not Qualified';
                                }
                                $values = [
                                    $record->jobInfo?->job_title,
                                    $record->jobInfo?->plantilla_item,
                                    $record->application_code,
                                    $record->fname.' '.$record->mname.' '.$record->lname,
                                    $record->email,
                                    $record->sex,
                                    !!$record->birthdate ? Carbon::parse($record->birthdate)->format('F d, Y') : '',
                                    $record->mobile_number,
                                    $record->address ,
                                    $status ,
                                    !!$record->created_at ? Carbon::parse($record->created_at)->format('F d, Y A') : '' ,

                                ];
                                $sheet->fromArray($values, null, 'A' . $i);
                                $sheet->getStyle('A' . $i)->applyFromArray($styleArray);
                            } else {
                                if($record->application_status == 0)
                                {
                                    $status = 'Pending';
                                }elseif($record->application_status == 1)
                                {
                                    $status = 'Validate';
                                }elseif($record->application_status == 2)
                                {
                                    $status = 'Qualified';
                                }
                                elseif($record->application_status == 4)
                                {
                                    $status = 'Not Qualified';
                                }
                                $sheet->setCellValue('A' . $i, $record->jobInfo?->job_title);
                                $sheet->setCellValue('B' . $i, $record->jobInfo?->plantilla_item);
                                $sheet->setCellValue('C' . $i, $record->application_code);
                                $sheet->setCellValue('D' . $i,  $record->fname.' '.$record->mname.' '.$record->lname);
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
                        $fileName = 'Applicants( '.Carbon::now()->format('Y-m-d') . ").xlsx";
                        $writer->save(storage_path('app/public/' . $fileName));


                        return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
                    })->deselectRecordsAfterCompletion()
                    ->color(Color::Red)
            ])
            ->recordClasses(function ( $record){
                return $record->batchInfo?->hired_applicant_id == $record?->application_code ? 'hired' : null;

            })
            ->paginationPageOptions(['1', '5', '10', '20', '30', 'all'])->striped()->defaultSort('created_at', 'desc') ;
    }

    #[Title('RSA - All Applicant')]
    public function render()
    {

        $allCount = \App\Models\RecruitmetJobApplication::query()->get()->count();

        return view('livewire.recruitment.all-applicant', compact('allCount'));
    }
}
