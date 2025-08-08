<?php

namespace App\Livewire\Recruitment;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Font;


class PsbPersonnelGrading extends Component
{
    use \App\Traits\RecruitmentPsbTrait;

    public $job_title = '';
    public $job_id = '';
    public $batch = '';
    public $job_batch = '';
    public $applicantData = '';
    public $type = '';
    public $category = '';

    public function mount($job_title, $job_id, $job_batch)
    {

        $this->job_title = $job_title;
        $this->job_id = $job_id;
        $this->job_batch = $job_batch;
        $this->applicantData = \App\Models\RecruitmentJobPsb::query()
            ->with([
                'jobInfos' => function ($q) {
                    $q->select('job_id', 'place_of_assignment', 'salary_grade');
                },
                'applicants' => function ($q) {
                    $q->select('application_status', 'job_id', 'batch_id', 'fname', 'lname', 'mname', 'id', 'mobile_number', 'application_code')->where('application_status', 1)->orWhere('application_status', 2)->orWhere('application_status', 1);
                },
                'psbInformation' => function ($q) {
                    $q
                        ->select('name', 'id_number');
                },
                'psbOtherInformation' => function ($q) {
                    $q->where('job_id', $this->job_id)->with('applicants');
                },

            ])
            ->where('job_id', $job_id)
            ->where('batch_id', $job_batch)
            ->get();

        $otherInformation = \App\Models\RecruitmentJobOtherInfotmation::select('job_id', 'batch_id', 'type', 'category')
            ->where('job_id', $job_id)
            ->where('batch_id', $job_batch)
            ->first();
        $batchData =  \App\Models\RecruitmentJobBatch::where('status',1)->where('job_id',$job_id)->first();
        $this->batch = $batchData?->batch_id;

        $this->type = $otherInformation?->type;
        $this->category = $otherInformation?->category;
    }
    public function applicantPrintPdf($applicant, $psb)
    {

        $grade = \App\Models\RecruitmentPsbGrade::query()->where('id_number', $psb['id_number'])->where('applicant_id', $applicant['application_code'])->where('batch_id', $applicant['batch_id'])->first();

        $name = $psb['psb_information']['name'];
        $upperName = Str::upper("$applicant[fname] $applicant[mname] $applicant[lname]");
        $type = $psb['psb_other_information']['type'];
        $category = $psb['psb_other_information']['category'];
        $min_requirements_education = $psb['psb_other_information']['min_requirements_education'];
        $min_requirements_training = $psb['psb_other_information']['min_requirements_training'];
        $min_requirements_experience = $psb['psb_other_information']['min_requirements_experience'];

        $computation = '';
        if ($grade) {
            $total = (float)$grade?->education - (float)$min_requirements_education;
            $computation = "$grade?->education - $min_requirements_education = $total";
        }
        $computationTraining = '';
        if ($grade) {
            $total = (float)$grade?->training - (float)$min_requirements_training;
            $computationTraining = "$grade?->training - $min_requirements_training = $total";
        }

        // experience
        $computationexperience = '';
        if ($grade) {
            $total = (float)$grade?->experience - (float)$min_requirements_experience;
            $computationexperience = "$grade?->experience - $min_requirements_experience = $total";
        }
        // performance
        $computationperformance = '';
        if ($grade) {

            $wa = $this->performanceWeightAllocation($type, $category);
            $performanceType = $grade?->performance_type == 'Position with experience requirement' ? 5 : 100;
            $total = (float)$grade?->performance / (float)$performanceType * $wa;
            $computationperformance = "$grade?->performance/$performanceType * $wa = $total";
        }

        if ($category == 'General Services') { // OUTSTANDING
            $outstanding = [
                'total' => $grade?->outstanding,
                'remarks_a' => "$grade?->outstanding_a <br/> $grade?->outstanding_a_remarks",
                'remarks2_a' => "$grade?->outstanding2_a <br/> $grade?->outstanding2_a_remarks",
                'remarks3_a' => "$grade?->outstanding3_a <br/> $grade?->outstanding3_a_remarks",
                'remarks_b' => "$grade?->outstanding_b <br/> $grade?->outstanding_b_remarks",
                'remarks_c' => "$grade?->outstanding_c <br/> $grade?->outstanding_c_remarks",
                'remarks_d' => "$grade?->outstanding_d <br/> $grade?->outstanding_d_remarks",
                'remarks_e' => "$grade?->outstanding_e <br/> $grade?->outstanding_e_remarks",
                'potential_total' => $grade?->potential_total,
//                'sub_total'=>
            ];
        } else {
            $outstanding = [
                'total' => $grade?->outstanding,
                'remarks_a' => "$grade?->outstanding_a <br/> $grade?->outstanding_a_remarks",
                'remarks2_a' => "$grade?->outstanding2_a <br/> $grade?->outstanding2_a_remarks",

                'remarks_b' => "$grade?->outstanding_b <br/> $grade?->outstanding_b_remarks",
                'remarks_c' => "$grade?->outstanding_c <br/> $grade?->outstanding_c_remarks",
                'remarks_d' => "$grade?->outstanding_d <br/> $grade?->outstanding_d_remarks",
                'remarks_e' => "$grade?->outstanding_e <br/> $grade?->outstanding_e_remarks",
                'potential_total' => $grade?->potential_total,
                'l_and_d_remarks' => $grade?->l_and_d_remarks,
                'l_and_d' => $grade?->l_and_d,

            ];
        }

        $file = "$type" . '_' . "$category";
        $pdf = Pdf::loadView("livewire.recruitment.assets.pdf_template.$file", [
            'grade' => $grade,
            'name' => $upperName,
            'type' => $type,
            'category' => $category,
            'min_requirements_education' => $min_requirements_education,
            'min_requirements_training' => $min_requirements_training,
            'min_requirements_experience' => $category,
            'position' => $this->job_title,
            'contact_number' => $applicant['mobile_number'],
            'place_of_assignment' => $psb['job_infos']['place_of_assignment'],
            'sg_level' => explode('/', $psb['job_infos']['salary_grade'])[0],
            'education' => [
                'remarks' => $grade?->education_remarks,
                'total' => $grade?->education_total,
                'computation' => $computation,
            ],
            'training' => [
                'remarks' => $grade?->training_remarks,
                'total' => $grade?->training_total,
                'computation' => $computationTraining,
            ],
            'experience' => [
                'remarks' => $grade?->experience_remarks,
                'total' => $grade?->experience_total,
                'computation' => $computationexperience,
            ],
            'performance' => [
                'remarks' => $grade?->performance_remarks,
                'total' => $grade?->performance_total,
                'computation' => $computationperformance,
            ],
            'application_of_education_remarks' => "$grade?->application_of_education_a <br> $grade?->application_of_education_a_remarks",
            'application_of_education' => $grade?->application_of_education,
            'l_and_d_remarks' => $grade?->l_and_d_remarks,
            'l_and_d' => $grade?->l_and_d,
            'outstanding' => $outstanding

        ])->setPaper('A4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->download();
        },  "$upperName - $name - individual Evaluation.pdf");
    }
    public function applicantPrint($applicant, $psb)
    {

        $grades = \App\Models\RecruitmentPsbGrade::query()->whereHas('psbsInfo')->with(['jobOtherInformation', 'psbInfo'])->where('applicant_id', $applicant['application_code'])->where('batch_id', $applicant['batch_id'])->get();
        $firstGrade = $grades?->first();


        $type = $firstGrade?->jobOtherInformation?->type;
        $category = $firstGrade?->jobOtherInformation?->category;
        $min_requirements_education = $firstGrade?->jobOtherInformation?->min_requirements_education;
        $min_requirements_training = $firstGrade?->jobOtherInformation?->min_requirements_training;
        $min_requirements_experience = $firstGrade?->jobOtherInformation?->min_requirements_experience;
        $subtotal = 0;

        if(!!$type) {
            $templatePath = public_path("/gradesheet/$category - $type.xlsx");
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($templatePath);
            $sheet = $spreadsheet->getSheet(0);
            $sheet->setCellValue('C5', "");

            $i = 1;
            foreach ($grades as $key => $grade) {
                $psbName = $grade->psbInfo?->name;

                if ($i > 1) {

                    $clonedWorksheet = clone $sheet;
//                    $clonedWorksheet->setTitle("$psbName");
                    $clonedWorksheet->setTitle("PSB $i");
                    $spreadsheet->addSheet($clonedWorksheet);
                    $sheet = $clonedWorksheet;
                } else {
//                    $sheet->setTitle("$psbName");
                     $sheet->setTitle("PSB $i");
                }


                $applicantName = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $upperName = Str::upper("$applicant[lname], $applicant[fname] $applicant[mname]");
                $applicantName->createTextRun("Name of Applicant : ")->getFont()->setBold(false);
                $applicantName->createTextRun($upperName)->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE);
                $sheet->getCell('B5')->setValue($applicantName);
                // Position
                $position = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $position->createTextRun("Position Applied For : ")->getFont()->setBold(false);
                $position->createTextRun($this->job_title)->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE);
                $sheet->getCell('B6')->setValue($position);
                // MOBILE NUMBER
                $contactNumber = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $contactNumber->createTextRun("Contact Number : ")->getFont()->setBold(false);
                $contactNumber->createTextRun($applicant['mobile_number'])->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE);
                $sheet->getCell('B8')->setValue($contactNumber);
                // PLACE OF ASSIGNMENT
                $division = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $division->createTextRun("Office : ")->getFont()->setBold(false);
                $division->createTextRun($psb['job_infos']['place_of_assignment'])->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE);
                $sheet->getCell('B7')->setValue($division);
                // SG Group
                $group = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                $group->createTextRun("Job Group/SG-Level : ")->getFont()->setBold(false);
                $group->createTextRun(explode('/', $psb['job_infos']['salary_grade'])[0])->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE);
                $sheet->getCell('B9')->setValue($group);


                // // education
                $sheet->setCellValue('D13', $grade?->education_remarks);
                $sheet->setCellValue('F13', $grade?->education_total);
                if ($grade) {
                    $total = (float)$grade?->education - (float)$min_requirements_education;
                    $sheet->setCellValue('E13', "$grade?->education - $min_requirements_education = $total");
                }
                // traning
                $sheet->setCellValue('D14', $grade?->training_remarks);
                $sheet->setCellValue('F14', $grade?->training_total);
                if ($grade) {
                    $total = (float)$grade?->training - (float)$min_requirements_training;
                    $sheet->setCellValue('E14', "$grade?->training - $min_requirements_training = $total");
                }
                // experience
                $sheet->setCellValue('D15', $grade?->experience_remarks);
                $sheet->setCellValue('F15', $grade?->experience_total);
                if ($grade) {
                    $total = (float)$grade?->experience - (float)$min_requirements_experience;
                    $sheet->setCellValue('E15', "$grade?->experience - $min_requirements_experience = $total");
                }


                $sheet->setCellValue('D16', value: $grade?->performance_remarks);
                $sheet->setCellValue('F16', $grade?->performance_total);
                if ($grade) {

                    $wa = $this->performanceWeightAllocation($type, $category);
                    $performanceType = $grade?->performance_type == 'Position with experience requirement' ? 5 : 100;
                    $total = (float)$grade?->performance / (float)$performanceType * $wa;
                    if($grade?->performance_type == 'Summa Cum Laude' ||  $grade?->performance_type == 'Magna Cum Laude' ||  $grade?->performance_type == 'Cum Laude')
                    {
                        $sheet->setCellValue('E16', "$grade?->performance_total");
                    }else{
                        $sheet->setCellValue('E16', "$grade?->performance/$performanceType * $wa = $total");
                    }
                }

                $sheet->setCellValue('F17', $grade?->outstanding);

                $subtotal = (float)$grade?->education_total + (float)$grade?->training_total+ (float)$grade?->experience_total+ (float)$grade?->performance_total+ (float)$grade?->outstanding+ (float)$grade?->application_of_education + (float)$grade?->l_and_d + (float)$grade?->potential_total;

                if ($category == 'General Services') { // OUTSTANDING
                    $sheet->setCellValue('E17', "$grade?->outstanding_a \n $grade?->outstanding_a_remarks");
                    $sheet->setCellValue('E19', "$grade?->outstanding2_a \n $grade?->outstanding2_a_remarks");
                    $sheet->setCellValue('E20', "$grade?->outstanding3_a \n $grade?->outstanding3_a_remarks");
                    $sheet->setCellValue('E22', "$grade?->outstanding_b \n $grade?->outstanding_b_remarks");
                    $sheet->setCellValue('E23', value: "$grade?->outstanding_c \n $grade?->outstanding_c_remarks");
                    $sheet->setCellValue('E24', "$grade?->outstanding_d \n $grade?->outstanding_d_remarks");
                    $sheet->setCellValue('E25', "$grade?->outstanding_e \n $grade?->outstanding_e_remarks");
                    $sheet->setCellValue('F17', "$grade?->outstanding");
                    $sheet->setCellValue('F26', $grade?->potential_total);
                    $positionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $positionDown->createTextRun("to me based on my qualifications and submitted documentary requirements for the ")->getFont()->setBold(false);
                    $positionDown->createTextRun($this->job_title)->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B32')->setValue($positionDown);
                    $divisionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $divisionDown->createTextRun("under ")->getFont()->setBold(false);
                    $divisionDown->createTextRun($psb['job_infos']['place_of_assignment'] . " .")->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B33')->setValue($divisionDown);

                    $applicantNameDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $upperName = Str::upper("$applicant[fname] $applicant[mname] $applicant[lname]");
                    $applicantNameDown->createTextRun($upperName)->getFont()->setBold(true)->setSize(12);
                    $sheet->getCell('E38')->setValue($applicantNameDown);


                    $sheet->setCellValue('F27', $subtotal);
                }
                else if ($category == 'SG 16-23 and SG-27' || $category == 'SG 10-22 and SG-27') {
                    // OUTSTANDING
                    $sheet->setCellValue('E17', "$grade?->outstanding_a \n $grade?->outstanding_a_remarks");
                    $sheet->setCellValue('E20', "$grade?->outstanding_b \n $grade?->outstanding_b_remarks");
                    $sheet->setCellValue('E21', "$grade?->outstanding_c \n $grade?->outstanding_c_remarks");
                    $sheet->setCellValue('E22', "$grade?->outstanding_d \n $grade?->outstanding_d_remarks");
                    $sheet->setCellValue('E23', "$grade?->outstanding_e \n $grade?->outstanding_e_remarks");
                    $sheet->setCellValue('F17', "$grade?->outstanding");
                    //Application of Education
                    $sheet->setCellValue('E25', "$grade?->application_of_education_a \n $grade?->application_of_education_a_remarks");
                    $sheet->setCellValue('F24', $grade?->application_of_education);
                    // L and D
                    $sheet->setCellValue('E27', $grade?->l_and_d_remarks);
                    $sheet->setCellValue('F27', $grade?->l_and_d);

                    $sheet->setCellValue('F28', $grade?->potential_total);

                    $positionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $positionDown->createTextRun("to me based on my qualifications and submitted documentary requirements for the ")->getFont()->setBold(false);
                    $positionDown->createTextRun($this->job_title)->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B34')->setValue($positionDown);
                    $divisionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $divisionDown->createTextRun("under ")->getFont()->setBold(false);
                    $divisionDown->createTextRun($psb['job_infos']['place_of_assignment'] . " .")->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B35')->setValue($divisionDown);

                    $applicantNameDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $upperName = Str::upper("$applicant[fname] $applicant[mname] $applicant[lname]");
                    $applicantNameDown->createTextRun($upperName)->getFont()->setBold(true)->setSize(12);
                    $sheet->getCell('E40')->setValue($applicantNameDown);
                    $sheet->setCellValue('F31', $subtotal);
                }
                else if ($category == 'SG-24(Chief)' && $type == 'Related-Teaching Positions') {
                    // OUTSTANDING
                    $sheet->setCellValue('E17', "$grade?->outstanding_a \n $grade?->outstanding_a_remarks");
                    $sheet->setCellValue('E20', "$grade?->outstanding2_a \n $grade?->outstanding2_a_remarks");
                    $sheet->setCellValue('E22', "$grade?->outstanding_b \n $grade?->outstanding_b_remarks");
                    $sheet->setCellValue('E23', "$grade?->outstanding_c \n $grade?->outstanding_c_remarks");
                    $sheet->setCellValue('E24', "$grade?->outstanding_d \n $grade?->outstanding_d_remarks");
                    $sheet->setCellValue('E25', "$grade?->outstanding_e \n $grade?->outstanding_e_remarks");
                    $sheet->setCellValue('F17', "$grade?->outstanding");
                    //Application of Education
                    $sheet->setCellValue('E26', "$grade?->application_of_education_a \n $grade?->application_of_education_a_remarks");
                    $sheet->setCellValue('F26', $grade?->application_of_education);
                    // L and D
                    $sheet->setCellValue('E30', $grade?->l_and_d_remarks);
                    $sheet->setCellValue('F30', $grade?->l_and_d);

                    $sheet->setCellValue('F31', $grade?->potential_total);

                    $positionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $positionDown->createTextRun("to me based on my qualifications and submitted documentary requirements for the ")->getFont()->setBold(false);
                    $positionDown->createTextRun($this->job_title)->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B37')->setValue($positionDown);
                    $divisionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $divisionDown->createTextRun("under ")->getFont()->setBold(false);
                    $divisionDown->createTextRun($psb['job_infos']['place_of_assignment'] . " .")->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B38')->setValue($divisionDown);

                    $applicantNameDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $upperName = Str::upper("$applicant[fname] $applicant[mname] $applicant[lname]");
                    $applicantNameDown->createTextRun($upperName)->getFont()->setBold(true)->setSize(12);
                    $sheet->getCell('E43')->setValue($applicantNameDown);
                    $sheet->setCellValue('F32', $subtotal);
                }
                elseif ($category == 'SG 11-15') {
                    // OUTSTANDING
                    $sheet->setCellValue('E17', "$grade?->outstanding_a \n $grade?->outstanding_a_remarks");
                    $sheet->setCellValue('E19', "$grade?->outstanding2_a \n $grade?->outstanding2_a_remarks");
                    $sheet->setCellValue('E21', "$grade?->outstanding_b \n $grade?->outstanding_b_remarks");
                    $sheet->setCellValue('E22', "$grade?->outstanding_c \n $grade?->outstanding_c_remarks");
                    $sheet->setCellValue('E23', "$grade?->outstanding_d \n $grade?->outstanding_d_remarks");
                    $sheet->setCellValue('E24', "$grade?->outstanding_e \n $grade?->outstanding_e_remarks");
                    $sheet->setCellValue('F17', "$grade?->outstanding");
                    //Application of Education
                    $sheet->setCellValue('E26', "$grade?->application_of_education_a \n $grade?->application_of_education_a_remarks");
                    $sheet->setCellValue('F25', $grade?->application_of_education);
                    // L and D
                    $sheet->setCellValue('E29', $grade?->l_and_d_remarks);
                    $sheet->setCellValue('F29', $grade?->l_and_d);

                    $sheet->setCellValue('F30', $grade?->potential_total);

                    $positionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $positionDown->createTextRun("to me based on my qualifications and submitted documentary requirements for the ")->getFont()->setBold(false);
                    $positionDown->createTextRun($this->job_title)->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B36')->setValue($positionDown);
                    $divisionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $divisionDown->createTextRun("under ")->getFont()->setBold(false);
                    $divisionDown->createTextRun($psb['job_infos']['place_of_assignment'] . " .")->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B37')->setValue($divisionDown);

                    $applicantNameDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $upperName = Str::upper("$applicant[fname] $applicant[mname] $applicant[lname]");
                    $applicantNameDown->createTextRun($upperName)->getFont()->setBold(true)->setSize(12);
                    $sheet->getCell('E42')->setValue($applicantNameDown);
                    $sheet->setCellValue('F31', $subtotal);
                }
                else {
                    // OUTSTANDING
                    $sheet->setCellValue('E17', "$grade?->outstanding_a \n $grade?->outstanding_a_remarks");
                    $sheet->setCellValue('E19', "$grade?->outstanding2_a \n $grade?->outstanding2_a_remarks");
                    $sheet->setCellValue('E21', "$grade?->outstanding_b \n $grade?->outstanding_b_remarks");
                    $sheet->setCellValue('E22', "$grade?->outstanding_c \n $grade?->outstanding_c_remarks");
                    $sheet->setCellValue('E23', "$grade?->outstanding_d \n $grade?->outstanding_d_remarks");
                    $sheet->setCellValue('E24', "$grade?->outstanding_e \n $grade?->outstanding_e_remarks");
                    $sheet->setCellValue('F17', "$grade?->outstanding");
                    //Application of Education
                    $sheet->setCellValue('E26', "$grade?->application_of_education_a \n $grade?->application_of_education_a_remarks");
                    $sheet->setCellValue('F25', $grade?->application_of_education);
                    // L and D
                    $sheet->setCellValue('E29', $grade?->l_and_d_remarks);
                    $sheet->setCellValue('F29', $grade?->l_and_d);


                    $sheet->setCellValue('F30', $grade?->potential_total);

                    $positionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $positionDown->createTextRun("to me based on my qualifications and submitted documentary requirements for the ")->getFont()->setBold(false);
                    $positionDown->createTextRun($this->job_title)->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B36')->setValue($positionDown);
                    $divisionDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $divisionDown->createTextRun("under ")->getFont()->setBold(false);
                    $divisionDown->createTextRun($psb['job_infos']['place_of_assignment'] . " .")->getFont()->setBold(true)->setUnderline(Font::UNDERLINE_SINGLE)->setSize(10);
                    $sheet->getCell('B37')->setValue($divisionDown);

                    $applicantNameDown = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
                    $upperName = Str::upper("$applicant[fname] $applicant[mname] $applicant[lname]");
                    $applicantNameDown->createTextRun($upperName)->getFont()->setBold(true)->setSize(12);
                    $sheet->getCell('E42')->setValue($applicantNameDown);
                    $sheet->setCellValue('F31', $subtotal);
                }
                $i++;
            }

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            $fileName = "$applicant[lname], $applicant[fname] $applicant[mname] - $this->job_title.xlsx";
            $directoryPath = storage_path('app/public/grades/');

            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 755, true); // 0755 is the permission
            }

            $writer->save(storage_path('app/public/grades/'.$fileName));


            return response()->download(storage_path('app/public/grades/'.$fileName));
        }
        else{
            Notification::make()
                ->title('Warning')
                ->danger()
                ->body('No Grade Found')
                ->persistent()
                ->send();
        }
    }


    public function car($type, $potential = false)
    {
        $getGrades = \App\Models\RecruitmentPsbGrade::with(['applicantInfo' => function ($q) {
            $q->select('application_code', 'fname', 'mname', 'lname');
        }])->where('job_id', $this->job_id)->where('batch_id', $this->job_batch)->get()->groupBy('applicant_id');

        $templatePath = public_path("/excel/CAR.xlsx");
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($templatePath);
        $car = $spreadsheet->getSheet(0);

        // car code

        $styleArray = $car->getStyle('A8')->exportArray();
        $educ = $this->educationWeightAllocation($this->type, $this->category) . "pts";
        $training = $this->trainingWeightAllocation($this->type, $this->category) . "pts";
        $experienceWeightAllocation = $this->experienceWeightAllocation($this->type, $this->category) . "pts";
        $performanceWeightAllocation = $this->performanceWeightAllocation($this->type, $this->category) . "pts";
        $outstandingAccomplishmentWeightAllocation = $this->outstandingAccomplishmentWeightAllocation($this->type, $this->category) . "pts";
        $applicationOfEducationWeightAllocation = $this->applicationOfEducationWeightAllocation($this->type, $this->category) . "pts";
        $learningAndDevelopmentWeightAllocation = $this->learningAndDevelopmentWeightAllocation($this->type, $this->category) . "pts";
        $potentialWeightAllocation = $this->potentialWeightAllocation($this->type, $this->category) . "pts";
        $car->setCellValue('B4',  "Position:   $this->job_title");
        $car->setCellValue('E7',  "Education \n ($educ)");
        $car->setCellValue('F7',  "Training \n ($training)");
        $car->setCellValue('G7',  "Experience \n ($experienceWeightAllocation)");
        $car->setCellValue('H7',  "Performance \n ($performanceWeightAllocation)");
        $car->setCellValue('I7',  "Outstanding Accomplishments \n ($outstandingAccomplishmentWeightAllocation)");
        $car->setCellValue('J7',  "Application of Education \n ($applicationOfEducationWeightAllocation)");
        $car->setCellValue('K7',  "Application of L&D \n ($learningAndDevelopmentWeightAllocation)");
        $car->setCellValue('L7',  "Potential \n ($potentialWeightAllocation)");
        $x = 1;
        $i = 8;

        foreach ($getGrades as $applicantData) {
            $applicant = $applicantData->first();

            if ($i > 8) {
                $car->insertNewRowBefore($i);

                $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;
                $total += $potential ? (float)$applicantData->sum('potential_total') : 0;
                $values = [
                    '',
                    $x,
                    $type == 'with' || $type == 'withpotential' ? $applicant->applicantInfo?->lname . ' ' . $applicant->applicantInfo?->fname . ' ' . $applicant->applicantInfo?->mname : '',
                    $applicant->applicant_id,
                    $applicant->education_total,
                    $applicant->training_total,
                    $applicant->experience_total,
                    $applicant->performance_total,
                    $applicant->outstanding,
                    $applicant->application_of_education,
                    $applicant->l_and_d,
                    $potential ? $applicantData->sum('potential_total') : '',
                    $total
                ];

                $car->fromArray($values, null, 'A' . $i);

                $car->getStyle('A' . $i)->applyFromArray($styleArray);
            } else {
                $total = (float)$applicant->education_total + (float)$applicant->training_total + (float)$applicant->experience_total + (float)$applicant->performance + (float)$applicant->outstanding + (float)$applicant->application_of_education + (float)$applicant->l_and_d;
                $total += $potential ? (float)$applicantData->sum('potential_total') : 0;
                $car->setCellValue('B' . $i, $x);
                $car->setCellValue('C' . $i,  $type == 'with' || $type == 'withpotential' ? $applicant->applicantInfo?->lname . ' ' . $applicant->applicantInfo?->fname . ' ' . $applicant->applicantInfo?->mname : '');
                $car->setCellValue('D' . $i, $applicant->applicant_id);
                $car->setCellValue('E' . $i,  $applicant->education_total);
                $car->setCellValue('F' . $i, $applicant->training_total);
                $car->setCellValue('G' . $i, $applicant->experience_total);
                $car->setCellValue('H' . $i,  $applicant->performance_total);
                $car->setCellValue('I' . $i, $applicant->outstanding);
                $car->setCellValue('J' . $i, $applicant->application_of_education);
                $car->setCellValue('K' . $i, $applicant->l_and_d);
                $car->setCellValue('L' . $i,  $potential ? $applicantData->sum('potential_total') : '');
                $car->setCellValue('M' . $i, $total);
            }
            $x++;
            $i++;
        }

        // $car->fromArray($values, null, 'A' . $i);
        // $car->getStyle('A' . $i)->applyFromArray($styleArray);


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = $potential ? "CAR WITH POTENTIAL- $this->job_title.xlsx" : "CAR - $this->job_title.xlsx";
        $writer->save(storage_path('app/public/' . $fileName));


        return response()->download(storage_path('app/public/' . $fileName));
    }

    public function wp_potential()
    {
        $getGrades = \App\Models\RecruitmentPsbGrade::with(['applicantInfo' => function ($q) {
            $q->select('application_code', 'fname', 'mname', 'lname');
        }, 'psbInfo' => function ($q) {
            $q->select('id_number', 'name')->orderBy('name');
        }])->where('job_id', $this->job_id)->where('batch_id', $this->job_batch)->orderByDesc('id_number')->get()->groupBy('applicant_id');



        $templatePath = public_path("/excel/WP-POTENTIAL.xlsx");
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($templatePath);
        $car = $spreadsheet->getSheet(0);


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
        $car->setCellValue('B2', Carbon::now()->format('M d, Y'));
        foreach ($getGrades as $applicantData) {

            $first = true;

            foreach ($applicantData as $key => $applicantsGroup) {

                if ($loopCount == 1) {
                    if ($potential > 6) {
                        $car->insertNewRowBefore($potential);


                        $values = [
                            Str::acronym($applicantsGroup?->psbInfo?->name),
                            $applicantsGroup?->we,
                            $applicantsGroup?->wst,
                            $applicantsGroup?->bei,
                            (float)$applicantsGroup?->we + (float)$applicantsGroup?->wst + (float)$applicantsGroup?->bei
                        ];

                        $car->fromArray($values, null, 'A' . $potential);
                        $car->getStyle("A$potential")->applyFromArray($lastRow);
                        if ($applicantData->last() === $applicantsGroup) {

                            $potential++;
                            $we =  $applicantData?->where('we', '!=', null)->sum('we');
                            $wst =   $applicantData?->where('wst', '!=', null)->sum('wst');
                            $bei = $applicantData?->where('bei', '!=', null)->sum('bei');
                            $car->setCellValue('B' . $potential, $we);
                            $car->setCellValue('C' . $potential, $wst);
                            $car->setCellValue('D' . $potential, $bei);
                            $car->setCellValue('E' . $potential, (float)$we + (float)$wst + (float)$bei);
                        }
                    } else {

                        $car->setCellValue('A' . $potential, Str::acronym($applicantsGroup?->psbInfo?->name));
                        $car->setCellValue('D' . $i, $applicantsGroup->applicant_id);
                        $car->setCellValue('B' . $potential, $applicantsGroup?->we);
                        $car->setCellValue('C' . $potential, $applicantsGroup?->wst);
                        $car->setCellValue('D' . $potential, $applicantsGroup?->bei);
                        $car->setCellValue('E' . $potential, (float)$applicantsGroup?->we + (float)$applicantsGroup?->wst + (float)$applicantsGroup?->bei);
                        if ($applicantData->last() === $applicantsGroup) {

                            $potential++;
                            $we =  $applicantData?->where('we', '!=', null)->sum('we');
                            $wst =   $applicantData?->where('wst', '!=', null)->sum('wst');
                            $bei = $applicantData?->where('bei', '!=', null)->sum('bei');
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
                            $applicantsGroup->applicant_id,
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
                        Str::acronym($applicantsGroup?->psbInfo?->name),
                        $applicantsGroup?->we,
                        $applicantsGroup?->wst,
                        $applicantsGroup?->bei,
                        (float)$applicantsGroup?->we + (float)$applicantsGroup?->wst + (float)$applicantsGroup?->bei
                    ];

                    $car->fromArray($values, null, 'A' . $potential);
                    $car->getStyle("A$potential")->applyFromArray($lastRow);
                    $car->getStyle("B$potential:D$potential")->applyFromArray($grade);
                    $car->getStyle("E$potential")->applyFromArray($gradeTotal);
                    if ($applicantData->last() === $applicantsGroup) {
                        $potential++;
                        $car->insertNewRowBefore($potential);
                        $we =  $applicantData?->where('we', '!=', null)->sum('we');
                        $wst =   $applicantData?->where('wst', '!=', null)->sum('wst');
                        $bei = $applicantData?->where('bei', '!=', null)->sum('bei');

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
    public function grade($user, $psb, $batch)
    {

        $check = \App\Models\RecruitmentPsbGrade::query()->where('id_number', $psb)->where('applicant_id', $user)->first();
        return $check ? true : false;
    }
    #[Title('PSB GRADING MONITORING')]
    public function render()
    {

        return view('livewire.recruitment.psb-personnel-grading');
    }
}
