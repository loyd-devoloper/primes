<?php

namespace App\Livewire\Recruitment;

use Carbon\Carbon;

use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use App\Livewire\Recruitment\Job;
use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class RsaMonitoring extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;
    #[Url]
    public ?array $tableFilters = null;
    public function table(Table $table): Table
    {

        return $table

            ->query(\App\Models\RecruitmentJobBatch::query()->with('jobInfo', 'jobOtherInformation', 'monitoring')->where('posting_date', '!=', null))

            ->heading('RSA MONITORING')
            ->filters([

                Filter::make('PostingDate')->form([
                    TextInput::make('date')->label('Posting Date')->placeholder('ex: 2022')->default(Carbon::now()->format('Y'))


                ])->query(function ($query, array $data) {
                    return $query
                        ->when(
                            $data['date'],
                            fn($query, $date)  => $query->whereYear('posting_date', $date),
                        );
                })->indicateUsing(function (array $data): ?string {
                    if (! $data['date']) {
                        return null;
                    }

                    return 'Posting Date: ' . $data['date'];
                }),

            ])

            ->deferFilters()
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                // TextColumn::make('allApplicant')  ->listWithLineBreaks()->limitList(2)
                // ->expandableLimitedList(),
                TextColumn::make('jobInfo.job_title')->label('Position Title')->searchable()->sortable(),
                TextColumn::make('batch_name')->label('Batch'),
                TextColumn::make('jobInfo.plantilla_item')->label('Plantilla Item')->searchable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('posting_date')->label('Posting Date')->formatStateUsing(fn($state) => !!$state ? Carbon::parse($state)->format('M d, Y h:i:s A') : null)->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('closing_date')->label('Closing Date')->toggleable(isToggledHiddenByDefault: false)->formatStateUsing(fn($state) => !!$state ? Carbon::parse($state)->format('M d, Y h:i:s A') : null),
                TextColumn::make('monitoring.status')->label('status')->badge()->formatStateUsing(fn($state) => \App\Enums\MonitoringStatusEnum::tryFrom($state)?->getLabel())->color(fn($state) => \App\Enums\MonitoringStatusEnum::tryFrom($state)?->getColor()),
            ])

            ->deferLoading()
            ->deselectAllRecordsWhenFiltered(false)
            ->actions([
                EditAction::make('Updated Details')
                    ->label('Updated Details')
                    ->color(Color::Green)
                    ->modalHeading('Update Details')
                    ->mutateRecordDataUsing(function ($data, $record) {

                        $check = \App\Models\RecruitmentMonitoring::where('batch_id', $record->batch_id)->where('job_id', $record->job_id)->first();
                        $data = [
                            'unfilled_position' => $check?->unfilled_position,
                            'dbm_plantilla_item_number' =>  $check?->dbm_plantilla_item_number,
                            'salary_grade' => $check?->salary_grade,
                            'year_of_vacancy_posting' => $check?->year_of_vacancy_posting,
                            'date_of_publication' => $check?->date_of_publication,
                            'issuance_of_regional_memo' => $check?->issuance_of_regional_memo,
                            'deadline_on_the_submmision_of_application' => $check?->deadline_on_the_submmision_of_application,
                            'initial_evaluation_applicants_hrmpsb' => $check?->initial_evaluation_applicants_hrmpsb,
                            'initial_evaluation_of_applicants_end_user' => $check?->initial_evaluation_of_applicants_end_user,
                            'recruitment_remarks' => $check?->recruitment_remarks,


                            'office_memo_to_the_hrmpsb' => $check?->office_memo_to_the_hrmpsb,
                            'open_ranking_assessment' => $check?->open_ranking_assessment,
                            'hrmpsb_deliberation' => $check?->hrmpsb_deliberation,


                            'car' => $check?->car,
                            'memo_to_and_memo_for' => $check?->memo_to_and_memo_for,
                            'minutes_of_the_meeting' => $check?->minutes_of_the_meeting,
                            'justification_resolution' => $check?->justification_resolution,
                            'assesment_with_the_applicant' => $check?->assesment_with_the_applicant,
                            'letter_to_the_successfull_candidate' => $check?->letter_to_the_successfull_candidate,
                            'selection_remarks' => $check?->selection_remarks,


                            'appointment' => $check?->appointment,
                            'pdf' => $check?->pdf,
                            'cert_of_assumtion_to_duty' => $check?->cert_of_assumtion_to_duty,
                            'supporting_documents' => $check?->supporting_documents,
                            'placement_remarks' => $check?->placement_remarks,

                            'to_csc_of_rizal' => $check?->to_csc_of_rizal,
                            'to_csc_of_remarks' => $check?->to_csc_of_remarks,
                            'turn_around_time' => $check?->turn_around_time,

                        ];
                        return $data;
                    })
                    ->form([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make('RECRUITMENT')
                                    ->icon('heroicon-o-user-group')
                                    ->schema([
                                        Grid::make([
                                            'default' => 2
                                        ])->schema([
                                            TextInput::make('unfilled_position')->label('UNFILLED POSITION'),
                                            TextInput::make('dbm_plantilla_item_number')->label('DBM PLANTILLA ITEM NUMBER'),
                                            TextInput::make('salary_grade')->label('SALARY GRADE/FUNCTIONAL DIVISION CONCERNED'),
                                            TextInput::make('year_of_vacancy_posting')->label('YEAR OF VACANCY POSTING'),
                                            DatePicker::make('date_of_publication')->label('DATE OF PUBLICATION/POSTING'),
                                            DatePicker::make('issuance_of_regional_memo')->label('ISSUANCE OF REGIONAL MEMO'),
                                            DatePicker::make('deadline_on_the_submmision_of_application')->label('DEADLINE ON THE SUBMISSION OF APPLICATION'),
                                            DatePicker::make('initial_evaluation_applicants_hrmpsb')->label('INITIAL EVALUATION  OF APPLICANTS BY THE HRMPSB'),
                                            DatePicker::make('initial_evaluation_of_applicants_end_user')->label('INITIAL EVALUATION OF APPLICANTS WITH THE END-USER'),
                                            Textarea::make('recruitment_remarks')->label('REMARKS, if any')->columnSpanFull(),
                                        ])

                                    ]),
                                Tabs\Tab::make('SELECTION')
                                    ->icon('heroicon-o-shield-check')
                                    ->schema([
                                        Grid::make([
                                            'default' => 2
                                        ])->schema([
                                            TextInput::make('office_memo_to_the_hrmpsb')->label('OFFICE MEMO TO THE HRMPSB FOR THE ASSESSMENT & OPEN RANKING WITH THE APPLICANTS'),
                                            DatePicker::make('open_ranking_assessment')->label('OPEN RANKING/ASSESSMENT, WRITTEN EXAMINATION AND INTERVIEW'),
                                            DatePicker::make('hrmpsb_deliberation')->label('HRMPSB DELIBERATION'),
                                            Fieldset::make('DOCUMENTS TO PREPARE')
                                                ->schema([
                                                    Grid::make([
                                                        'default' => 2
                                                    ])->schema([
                                                        DatePicker::make('car')->label('CAR'),
                                                        DatePicker::make('memo_to_and_memo_for')->label('MEMO TO AND MEMO FOR'),
                                                        DatePicker::make('minutes_of_the_meeting')->label('MINUTES OF THE MEETING'),
                                                        DatePicker::make('justification_resolution')->label('JUSTIFICATION/RESOLUTION (IF ANY)'),
                                                        DatePicker::make('letter_to_the_successfull_candidate')->label('LETTER TO THE SUCCESSFUL CANDIDATE (compliance of requirements)'),


                                                    ])

                                                ]),
                                            Textarea::make('selection_remarks')->label('REMARKS, if any')->columnSpanFull(),
                                        ])

                                    ]),
                                Tabs\Tab::make('PLACEMENT')
                                    ->icon('heroicon-o-user-circle')
                                    ->schema([
                                        Grid::make([
                                            'default' => 2
                                        ])->schema([
                                            DatePicker::make('appointment')->label('APPOINTMENT'),
                                            DatePicker::make('pdf')->label('PDF'),
                                            DatePicker::make('cert_of_assumtion_to_duty')->label('OATH OF OFFICE/CERT OF ASSUMPTION TO DUTY'),
                                            TextInput::make('supporting_documents')->label('ADDITIONAL/SUPPORTING DOCUMENTS'),
                                            TextInput::make('placement_remarks')->label('REMARKS, if any (Placement)')->columnSpanFull(),

                                            DatePicker::make('to_csc_of_rizal')->label('TO CSC FO- RIZAL email advance copy to: cscforizal.transmittal@gmail.com(optional)')->columnSpanFull(),
                                            Textarea::make('to_csc_of_remarks')->label('REMARKS, if any')->columnSpanFull(),
                                            TextInput::make('turn_around_time')->label('TURN-AROUND TIME: FROM PUBLICATION UP TO FILLING-UP OF POSITION PER APPOINTMENT ISSUED (DATE APPROVED BY THE APPOINTING AUTHORITY)')->columnSpanFull(),

                                        ])

                                    ])
                            ])->extraAttributes(['class'=>'monitoringTab'])

                    ])
                    ->action(function ($data, $record) {
                        $check = \App\Models\RecruitmentMonitoring::where('batch_id', $record->batch_id)->where('job_id', $record->job_id)->first();
                        $arr = [
                            'unfilled_position' => $data['unfilled_position'],
                            'dbm_plantilla_item_number' => $data['dbm_plantilla_item_number'],
                            'salary_grade' => $data['salary_grade'],
                            'year_of_vacancy_posting' => $data['year_of_vacancy_posting'],
                            'date_of_publication' => $data['date_of_publication'],
                            'issuance_of_regional_memo' => $data['issuance_of_regional_memo'],
                            'deadline_on_the_submmision_of_application' => $data['deadline_on_the_submmision_of_application'],
                            'initial_evaluation_applicants_hrmpsb' => $data['initial_evaluation_applicants_hrmpsb'],
                            'initial_evaluation_of_applicants_end_user' => $data['initial_evaluation_of_applicants_end_user'],
                            'recruitment_remarks' => $data['recruitment_remarks'],

                            'office_memo_to_the_hrmpsb' => $data['office_memo_to_the_hrmpsb'],
                            'open_ranking_assessment' => $data['open_ranking_assessment'],
                            'hrmpsb_deliberation' => $data['hrmpsb_deliberation'],
                            'car' => $data['car'],
                            'memo_to_and_memo_for' => $data['memo_to_and_memo_for'],
                            'minutes_of_the_meeting' => $data['minutes_of_the_meeting'],
                            'justification_resolution' => $data['justification_resolution'],

                            'letter_to_the_successfull_candidate' => $data['letter_to_the_successfull_candidate'],
                            'selection_remarks' => $data['selection_remarks'],


                            'appointment' => $data['appointment'],
                            'pdf' => $data['pdf'],
                            'cert_of_assumtion_to_duty' => $data['cert_of_assumtion_to_duty'],
                            'supporting_documents' => $data['supporting_documents'],
                            'placement_remarks' => $data['placement_remarks'],

                            'to_csc_of_rizal' => $data['to_csc_of_rizal'],
                            'to_csc_of_remarks' => $data['to_csc_of_remarks'],
                            'turn_around_time' => $data['turn_around_time'],

                            'job_id' => $record->job_id,
                            'batch_id' => $record->batch_id,
                        ];
                        if ($check) {
                            $check->update($arr);
                        } else {
                            \App\Models\RecruitmentMonitoring::create($arr);
                        }
                    })
                    ->modalWidth(MaxWidth::ScreenTwoExtraLarge),
                EditAction::make('status')
                    ->icon('heroicon-o-arrow-path')
                    ->modalHeading('Update Status')
                    ->color(Color::Amber)
                    ->label('Status')
                    ->mutateRecordDataUsing(function ($data, $record) {
                        $data['status'] = $record->monitoring?->status;
                        return $data;
                    })
                    ->form([
                        Select::make('status')
                            ->options(\App\Enums\MonitoringStatusEnum::class)
                            ->required()

                    ])
                    ->action(function ($data, $record) {
                        \App\Models\RecruitmentMonitoring::where('batch_id', $record->batch_id)->where('job_id', $record->job_id)->update([
                            'status' => $data['status'],
                        ]);
                    })
                    ->modalWidth(MaxWidth::Small),
                Action::make('Files')
                    ->extraModalActions([

                        EditAction::make('statusx')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->modalHeading('Upload File')
                            ->color(Color::Amber)
                            ->label('Upload File')
                            ->form([

                                FileUpload::make('file')
                                    ->directory('recruitment/monitoring')->required()->acceptedFileTypes(['application/pdf'])->preserveFilenames()->getUploadedFileNameForStorageUsing(
                                        fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                            ->prepend(Str::uuid() . '-/-'),
                                    )
                            ])
                            ->modalWidth(MaxWidth::Small)
                            ->modalSubmitActionLabel('Upload')
                            ->action(function ($data, $record) {

                                \App\Models\RecruitmentMonitoringFileUpload::create([
                                    'job_id' => $record->job_id,
                                    'batch_id' => $record->batch_id,
                                    'file' => $data['file'],
                                ]);
                                Notification::make()
                                    ->title('Uploaded Successfully')
                                    ->success()
                                    ->send();
                            }),

                    ])
                    ->icon('heroicon-o-arrow-up-tray')
                    ->modalHeading(fn($record) => $record->jobInfo?->job_title)
                    ->color(Color::Gray)
                    ->label('Files')
                    ->form(function ($record) {
                        $files = \App\Models\RecruitmentMonitoringFileUpload::where('batch_id', $record->batch_id)->where('job_id', $record->job_id)->orderByDesc('id')->get();
                        $x = [];
                        foreach ($files as $file) {
                            $label = explode('-/-', $file->file)[1];
                            $x[] = Grid::make(5)->schema([
                                Placeholder::make('dsasdad')->columnSpan(4)->label($label),
                                \Filament\Forms\Components\Actions::make([

                                    \Filament\Forms\Components\Actions\Action::make($file->file)
                                        ->label($label)
                                        ->extraAttributes(['title' => 'View Attachment'])
                                        ->icon('heroicon-o-eye')
                                        ->iconButton()
                                        ->modalContent(function ($record) use ($file) {

                                            $link = 'storage/' . $file->file;

                                            return view('livewire.recruitment.step1.check-file.pdf-viewer', compact('link'));
                                        })
                                        ->modalSubmitAction(false)
                                        ->modalCancelAction(false)
                                        ->modalWidth(MaxWidth::ScreenExtraLarge)

                                        ->closeModalByClickingAway(false),
                                    \Filament\Forms\Components\Actions\Action::make($file->id . 'delete')
                                        ->label('Delete File')
                                        ->color(Color::Red)
                                        ->icon('heroicon-o-trash')
                                        ->iconButton()
                                        ->requiresConfirmation()
                                        ->action(function ($record) use ($file) {
                                            $file->delete();
                                            $this->resetTable();
                                            Notification::make()
                                                ->title('Deleted Successfully')
                                                ->success()
                                                ->send();
                                        })

                                ])->extraAttributes(['style' => 'width:fit-content;margin-left:auto'])

                            ]);
                        }
                        return $x;
                    })->modalSubmitAction(false)->modalCancelAction(false)
            ])
            ->bulkActions([
                BulkAction::make('export RSA Monitoring')->label('Export RSA Monitoring')->action(function ($records) {

                    $templatePath = public_path('/sample RSA monitoring Final.xlsx');
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    $spreadsheet = $reader->load($templatePath);
                    $sheet = $spreadsheet->getSheet(0);

                    $styleArray = $sheet->getStyle(cellCoordinate: 'A8')->exportArray();
                    $x = 1;
                    $i = 8;
                    $y = !!$this->tableFilters['PostingDate']['date'] ? $this->tableFilters['PostingDate']['date'] : 'All';
                    $sheet->setCellValue('B4', "CY $y");
                    foreach ($records as $record) {
                        if ($i > 8) {

                            $sheet->insertNewRowBefore($i);
                            $sheet->mergeCells("F$i:G$i");
                            $values = [
                                $x,
                                $record->monitoring?->unfilled_position,
                                $record->monitoring?->dbm_plantilla_item_number,
                                $record->monitoring?->salary_grade,

                                $record->monitoring?->year_of_vacancy_posting,
                                $this->changeFormat($record->monitoring?->date_of_publication),
                                // $this->changeFormat($record->monitoring?->issuance_of_regional_memo),
                                $this->changeFormat($record->monitoring?->deadline_on_the_submmision_of_application),
                                '',
                                $this->changeFormat($record->monitoring?->initial_evaluation_applicants_hrmpsb),
                                $this->changeFormat($record->monitoring?->initial_evaluation_of_applicants_end_user),
                                $record->monitoring?->recruitment_remarks,
                                '',
                                $record->monitoring?->office_memo_to_the_hrmpsb,
                                $this->changeFormat($record->monitoring?->open_ranking_assessment),
                                $this->changeFormat($record->monitoring?->hrmpsb_deliberation),
                                $this->changeFormat($record->monitoring?->car),
                                $this->changeFormat($record->monitoring?->memo_to_and_memo_for),
                                $this->changeFormat($record->monitoring?->minutes_of_the_meeting),
                                $this->changeFormat($record->monitoring?->justification_resolution),
                                $this->changeFormat($record->monitoring?->letter_to_the_successfull_candidate),
                                $record->monitoring?->selection_remarks,

                                $this->changeFormat($record->monitoring?->appointment),
                                $this->changeFormat($record->monitoring?->pdf),
                                $this->changeFormat($record->monitoring?->cert_of_assumtion_to_duty),
                                $record->monitoring?->supporting_documents,
                                $record->monitoring?->placement_remarks,
                                $this->changeFormat($record->monitoring?->to_csc_of_rizal),
                                $record->monitoring?->to_csc_of_remarks,
                                $record->monitoring?->turn_around_time,

                            ];
                            $sheet->fromArray($values, null, 'A' . $i);
                            $sheet->getStyle('A' . $i)->applyFromArray($styleArray);
                        } else {
                            $sheet->setCellValue('A' . $i,  $x);

                            $sheet->setCellValue('B' . $i,  $record->monitoring?->unfilled_position);

                            $sheet->setCellValue('C' . $i, $record->monitoring?->dbm_plantilla_item_number);

                            $sheet->setCellValue('D' . $i, $record->monitoring?->salary_grade);

                            $sheet->setCellValue('E' . $i, $record->monitoring?->year_of_vacancy_posting);

                            $sheet->setCellValue('F' . $i, $this->changeFormat($record->monitoring?->date_of_publication));

                            // $sheet->setCellValue('G' . $i, $this->changeFormat($record->monitoring?->issuance_of_regional_memo));

                            $sheet->setCellValue('H' . $i, $this->changeFormat($record->monitoring?->deadline_on_the_submmision_of_application));
                            $sheet->setCellValue('I' . $i, '');

                            $sheet->setCellValue('J' . $i, $this->changeFormat($record->monitoring?->initial_evaluation_applicants_hrmpsb));

                            $sheet->setCellValue('K' . $i, $this->changeFormat($record->monitoring?->initial_evaluation_of_applicants_end_user));

                            $sheet->setCellValue('L' . $i, $record->monitoring?->recruitment_remarks);


                            $sheet->setCellValue('M' . $i, '');
                            $sheet->setCellValue('N' . $i, $record->monitoring?->office_memo_to_the_hrmpsb);
                            $sheet->setCellValue('O' . $i, $this->changeFormat($record->monitoring?->open_ranking_assessment));
                            $sheet->setCellValue('P' . $i, $this->changeFormat($record->monitoring?->hrmpsb_deliberation));
                            $sheet->setCellValue('Q' . $i, $this->changeFormat($record->monitoring?->car));
                            $sheet->setCellValue('R' . $i, $this->changeFormat($record->monitoring?->memo_to_and_memo_for));
                            $sheet->setCellValue('S' . $i, $this->changeFormat($record->monitoring?->minutes_of_the_meeting));
                            $sheet->setCellValue('T' . $i, $this->changeFormat($record->monitoring?->justification_resolution));
                            $sheet->setCellValue('U' . $i, $this->changeFormat($record->monitoring?->letter_to_the_successfull_candidate));
                            $sheet->setCellValue('V' . $i, $record->monitoring?->selection_remarks);



                            $sheet->setCellValue('W' . $i, $this->changeFormat($record->monitoring?->appointment));
                            $sheet->setCellValue('X' . $i, $this->changeFormat($record->monitoring?->pdf));
                            $sheet->setCellValue('Y' . $i, $this->changeFormat($record->monitoring?->cert_of_assumtion_to_duty));
                            $sheet->setCellValue('Z' . $i, $record->monitoring?->supporting_documents);
                            $sheet->setCellValue('AA' . $i, $record->monitoring?->placement_remarks);
                            $sheet->setCellValue('AB' . $i, $this->changeFormat($record->monitoring?->to_csc_of_rizal));
                            $sheet->setCellValue('AC' . $i, $record->monitoring?->to_csc_of_remarks);
                            $sheet->setCellValue('AD' . $i, $record->monitoring?->turn_around_time);
                        }
                        $x++;
                        $i++;
                    }

                    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

                    $fileName = "RSA Monitoring - $y.xlsx";
                    $writer->save(storage_path('app/public/' . $fileName));


                    return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
                })
            ])
            ->defaultSort('created_at', 'desc');
    }

    // CHANGE DATE FORMAT
    public function changeFormat($date)
    {
        return !!$date ? Carbon::parse($date)->format('F d, Y') : '';
    }
    #[Title('RSA - Monitoring')]
    public function render()
    {

        return view('livewire.recruitment.rsa-monitoring');
    }
}
