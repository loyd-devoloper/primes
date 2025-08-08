<?php

namespace App\Exports;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Address;
use App\Models\UserInfo;
use Drawing\FormControl;
use App\Models\Eligibility;
use App\Traits\CellMapTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Sheet;
use App\Traits\ActivityTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Style\Color;


use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class UsersExport implements WithEvents,WithMultipleSheets
{
    // use Exportable;
    use CellMapTrait;
    use ActivityTrait;
    public function sheets(): array
    {
        $sheets = [];

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] =  $month;
        }

        return $sheets;
    }



    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile(public_path('CS Form No. 212 Personal Data Sheet revised(1).xlsx'));

                 $spreadsheet = $event->writer->reopen($templateFile, Excel::XLSX);

                // $spreadsheet->setActiveSheetIndex(0);
                // $sheet = $event->writer->getSheet(0);
                // $sheet4 =  $spreadsheet->getSheet(3);
                // $sheet2 = $event->writer->getSheet(1);
                // $sheet3 = $event->writer->getSheet(2);
                $sheet = $spreadsheet->getSheet(0);
                $sheet2 = $spreadsheet->getSheet(1);
                $sheet3 = $spreadsheet->getSheet(2);
                $sheet4 = $spreadsheet->getSheet(3);


                $userinfo = User::with(['userInfo', 'skillHobbies', 'learningAndDevelopment', 'civilServiceEligibility', 'workExperience', 'voluntaryAndInvolvement', 'educationalBackground', 'familyBackground', 'familyBackgroundChildren', 'otherInfo'])->where('id_number', Auth::user()->id_number)->first();
                $drawing = new Drawing();
                $path = storage_path('app/public/' . $userinfo->otherinfo?->e_sig); // path to the image
                $drawing->setName('drawing');
                $drawing->setDescription('drawing Logo');
                $drawing->setPath($path);
                $drawing->setCoordinates('D60');
                $drawing->setWidth(211);
                $drawing->setHeight(100);
                // $drawing->setOffsetX(-65);
                // $drawing->setOffsetY(-40);
                $drawing->setWorksheet($sheet);

                // if ($userinfo  && !!$userinfo->otherinfo?->e_sig) {


                //     $drawing2 = new Drawing();
                //     $drawing2->setName('drawing2');
                //     $drawing2->setDescription('drawing2 Logo');
                //     $drawing2->setPath( $path);
                //     $drawing2->setCoordinates('F47');
                //     $drawing2->setWidth(211);
                //     $drawing2->setHeight(100);
                //     $drawing2->setOffsetX(-65);
                //     $drawing2->setOffsetY(-40);

                //     $drawing2->setWorksheet($sheet2);



                //     $drawing3 = new Drawing();
                //     $drawing3->setName('drawing3');
                //     $drawing3->setDescription('drawing3 Logo');
                //     $drawing3->setPath( $path);
                //     $drawing3->setCoordinates('D50');
                //     $drawing3->setWidth(211);
                //     $drawing3->setHeight(100);
                //     $drawing3->setOffsetX(30);
                //     $drawing3->setOffsetY(-40);

                //     $drawing3->setWorksheet($sheet3);
                // }


                // if ($userinfo) {

                //     if (empty($userinfo->otherInfo) == false) $this->otherInfo($sheet4, $userinfo->otherInfo);
                //     if (empty($userinfo->voluntaryAndInvolvement) == false) $this->voluntaryAndInvolvement($sheet3, $userinfo->voluntaryAndInvolvement);
                //     if (empty($userinfo->learningAndDevelopment) == false) $this->learningAndDevelopment($sheet3, $userinfo->learningAndDevelopment);
                //     if (empty($userinfo->skillHobbies) == false) $this->skils($sheet3, $userinfo->skillHobbies);

                //     if (empty($userinfo->civilServiceEligibility) == false) $this->civilServiceEligibility($sheet2, $userinfo->civilServiceEligibility);
                //     if (empty($userinfo->workExperience) == false) $this->workExperience($sheet2, $userinfo->workExperience);

                //     if (empty($userinfo->userInfo) == false) $this->personalInformation($sheet, $userinfo->userInfo);
                //     if (empty($userinfo->familyBackgroundChildren) == false && empty($userinfo->familyBackground) == false) $this->familyBackground($sheet, $userinfo->familyBackground, $userinfo->familyBackgroundChildren);
                //     if (empty($userinfo->educationalBackground) == false) $this->educationalBackground($sheet, $userinfo->educationalBackground);
                // }


                // if ($userinfo  && !!$userinfo->otherinfo?->e_sig) {

                //     $drawing2 = new Drawing();
                //     $drawing2->setName('drawing2');
                //     $drawing2->setDescription('drawing2 Logo');
                //     $drawing2->setPath(storage_path('app/public/' . $userinfo->otherinfo?->e_sig));
                //     $drawing2->setCoordinates('F47');
                //     $drawing2->setWidth(211);
                //     $drawing2->setHeight(100);
                //     $drawing2->setOffsetX(-65);
                //     $drawing2->setOffsetY(-40);

                //     $drawing2->setWorksheet($sheet2);

                //     $drawing = new Drawing();
                //     $drawing->setName('drawing');
                //     $drawing->setDescription('drawing Logo');
                //     $drawing->setPath(storage_path('app/public/' . $userinfo->otherinfo?->e_sig));
                //     $drawing->setCoordinates('F60');
                //     $drawing->setWidth(211);
                //     $drawing->setHeight(100);
                //     // $drawing->setOffsetX(-65);
                //     // $drawing->setOffsetY(-40);
                //     $drawing->setWorksheet($sheet);

                //     $drawing3 = new Drawing();
                //     $drawing3->setName('drawing3');
                //     $drawing3->setDescription('drawing3 Logo');
                //     $drawing3->setPath(storage_path('app/public/' . $userinfo->otherinfo?->e_sig));
                //     $drawing3->setCoordinates('D50');
                //     $drawing3->setWidth(211);
                //     $drawing3->setHeight(100);
                //     $drawing3->setOffsetX(30);
                //     $drawing3->setOffsetY(-40);

                //     $drawing3->setWorksheet($sheet3);
                // }


                // return $event->writer->setActiveSheetIndex(0);
            }
        ];
    }

    public function personalInformation($sheet, $userinfo)
    {


        // $userinfo = DB::table('tbl_users_info')->where('id_number', '123456')->first();
        $permanent =  Address::where('id_number', Auth::user()->id_number)->where('type', 'PERMANENT')->first();
        $residentials =  Address::where('id_number', Auth::user()->id_number)->where('type', 'RESIDENTIAL')->first();


        // $sheet->setCellValue('D16', 1);

        $this->checkboxCell($sheet, $userinfo, 'sex', 'D16', 'Male');
        $this->checkboxCell($sheet, $userinfo, 'sex', 'E16', 'Female');
        $this->checkboxCell($sheet, $userinfo, 'civil_status', 'D17', 'Single');
        $this->checkboxCell($sheet, $userinfo, 'civil_status', 'E17', 'Married');
        $this->checkboxCell($sheet, $userinfo, 'civil_status', 'D18', 'Widowed');
        $this->checkboxCell($sheet, $userinfo, 'civil_status', 'E18', 'Seperated');

        $this->checkboxCell($sheet, $userinfo, 'civil_status', 'D20', 'Others');



        if ($userinfo->civil_status == 'Solo Parent') {
            $this->checkboxCell($sheet, $userinfo, 'civil_status', 'D20', 'Solo Parent');
            $sheet->setCellValue('D21', 'Solo Parent');
        }


        $this->checkboxCell($sheet, $userinfo, 'citizenship', 'J13', 'Filipino');




        $this->cellMapWithStyle($sheet, $userinfo, 'lname', 'D10', 2, 10, false);
        $this->cellMapWithStyle($sheet, $userinfo, 'fname', 'D11', 2, 10, false);
        $this->cellMapWithStyle($sheet, $userinfo, 'mname', 'D12', 2, 10, false);
        if (!!$userinfo->name_extension) {
            $this->cellMapWithStyle($sheet, $userinfo, 'name_extension', 'L11', 1, 10, false);
        }
        // $this->cellMapWithStyle($sheet, $userinfo, 'birth_date', 'D13', 2, 10);

        $value =  !!$userinfo->birth_date ? Carbon::parse(Crypt::decryptString($userinfo->birth_date))->format('m/d/Y') : null;
        $sheet->setCellValue('D13', $value);
        $this->cellMapWithStyle($sheet, $userinfo, 'place_birth', 'D15', 1, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'height', 'D22', 1, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'weight', 'D24', 1, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'blood_type', 'D25', 1, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'gsis_no', 'D27', 2, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'pag_ibig_no', 'D29', 2, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'philhealth_no', 'D31', 2, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'sss_no', 'D32', 2, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'tin_no', 'D33', 2, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'agency_employee_no', 'D34', 2, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'telephone_no', 'I32', 2, 10);
        $this->cellMapWithStyle($sheet, $userinfo, 'mobile_no', 'I33', 2, 10);

        // RESIDENTIALS ADDRESS
        $this->cellMapWithStyle($sheet, $permanent, 'house_no', 'I17', 2, 10);
        $this->cellMapWithStyle($sheet, $permanent, 'street', 'L17', 2, 10);
        $this->cellMapWithStyle($sheet, $permanent, 'subdivision', 'I19', 2, 10);
        $this->cellMapWithStyle($sheet, $permanent, 'brgy', 'L19', 2, 10);
        $this->cellMapWithStyle($sheet, $permanent, 'city', 'I22', 2, 10);
        $this->cellMapWithStyle($sheet, $permanent, 'province', 'L22', 2, 10);
        $this->cellMapWithStyle($sheet, $permanent, 'zipcode', 'I24', 2, 10);

        $this->cellMapWithStyle($sheet, $residentials, 'house_no', 'I25', 2, 10);
        $this->cellMapWithStyle($sheet, $residentials, 'street', 'L25', 2, 10);
        $this->cellMapWithStyle($sheet, $residentials, 'subdivision', 'I27', 2, 10);
        $this->cellMapWithStyle($sheet, $residentials, 'brgy', 'L27', 2, 10);
        $this->cellMapWithStyle($sheet, $residentials, 'city', 'I29', 2, 10);
        $this->cellMapWithStyle($sheet, $residentials, 'province', 'L29', 2, 10);
        $this->cellMapWithStyle($sheet, $residentials, 'zipcode', 'I31', 2, 10);
        $sheet->setCellValue('I34', Auth::user()->email);
        //     $sheet->getStyle('I34')->getFont()->setBold(true);
        //    $sheet->getStyle('I34')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //     $sheet->getStyle('I34')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        //     $sheet->getStyle('I34')->getFont()->setSize(10);


    }
    // DONE
    public function familyBackground($sheet, $familyBackground, $childrens)
    {

        // Family background
        // $familyBackground = DB::table('tbl_family_background')->where('id_number', '123456')->first();
        $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_lname', 'D36', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_fname', 'D37', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_mname', 'D38', 2, 10);
        if (!!$familyBackground->spouse_extension) {
            $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_extension', 'G37', 1, 10);
        }
        $this->cellMapWithStyle($sheet, $familyBackground, 'occupation', 'D39', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'business_name', 'D40', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'business_address', 'D41', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'telephone_no', 'D42', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'father_lname', 'D43', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'father_fname', 'D44', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'father_mname', 'D45', 2, 10);
        if (!!$familyBackground->father_extension) {
            $this->cellMapWithStyle($sheet, $familyBackground, 'father_extension', 'G44', 1, 10);
        }

        $this->cellMapWithStyle($sheet, $familyBackground, 'mother_maiden_name', 'D46', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'mother_lname', 'D47', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'mother_fname', 'D48', 2, 10);
        $this->cellMapWithStyle($sheet, $familyBackground, 'mother_mname', 'D49', 2, 10);

        // CHILDREN
        // $childrens = DB::table('tbl_children')->where('id_number', '123456')->get();
        $i = 37;
        foreach ($childrens as $child) {
            $value =  !!$child->child_birth_date ?  Crypt::decryptString($child->child_birth_date) : null;
            $final =  !!$child->child_birth_date ?  Carbon::parse($value)->format('m/d/Y') : null;
            $sheet->setCellValue('M' . $i, $final);
            $this->cellMapWithStyle($sheet, $child, 'child_name', 'I' . $i, 2, 10);
            // $this->cellMapWithStyle($sheet, $child, 'child_birth_date', 'M'.$i, 1, 10);
            $i++;
        }
    }
    // done
    public function educationalBackground($sheet, $educationalBackgrounds)
    {
        // $educationalBackgrounds = DB::table('tbl_educational_background')->where('id_number', '123456')->get();
        foreach ($educationalBackgrounds as $educ) {
            $cellNum = '';
            if ($educ->level == 'SECONDARY') {
                $cellNum = '54';
            } else if ($educ->level === 'ELEMENTARY') {
                $cellNum = '55';
            } else if ($educ->level === 'VOCATIONAL') {
                $cellNum = '56';
            } else if ($educ->level === 'COLLEGE') {
                $cellNum = '57';
            } else if ($educ->level === 'GRADUATE STUDIES') {
                $cellNum = '58';
            }
            $this->cellMapWithStyle($sheet, $educ, 'school_name', 'D' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $educ, 'course_education', 'G' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $educ, 'from', 'J' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $educ, 'to', 'K' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $educ, 'unit_earned', 'L' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $educ, 'year_graduated', 'M' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $educ, 'academic_honor_received', 'N' . $cellNum, 1, 10);
        }
        $sheet->setCellValue('L60', Carbon::now()->format('Y-m-d'));
        // $sheet->getStyle('L60')->getFont()->setBold(true);
        // $sheet->getStyle('L60')->getFont()->setSize(10);

    }
    // done
    public function civilServiceEligibility($sheet, $eligibilitys)
    {
        $i = 5;

        foreach ($eligibilitys as $eligibility) {
            $this->cellMapWithStyle($sheet, $eligibility, 'license_title', 'A' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $eligibility, 'rating', 'F' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $eligibility, 'date_examination', 'G' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $eligibility, 'place_examination', 'I' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $eligibility, 'license_number', 'L' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $eligibility, 'date_validity', 'M' . $i, 1, 10);
            $i++;
        }
    }
    // done
    public function workExperience($sheet, $workExperience)
    {

        $i = 18;
        foreach ($workExperience as $exp) {
            $value =  !!$exp->from ? Carbon::parse($exp->from)->format('m/d/Y') : null;
            $sheet->setCellValue('A' . $i, $value);

            if (!!$exp->to) {
                if ($exp->to != 'PRESENT') {
                    $to = Carbon::parse($exp->to)->format('m/d/Y');
                } else {
                    $to = $exp->to;
                }
            } else {
                $to = null;
            }
            $sheet->setCellValue('C' . $i, $to);
            // $this->cellMapWithStyle($sheet, $exp, 'from', 'A' . $i, 1, 10);
            // $this->cellMapWithStyle($sheet, $exp, 'to', 'C' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $exp, 'position_title', 'D' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $exp, 'company', 'G' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $exp, 'monthly_salary', 'J' . $i, 2, 10);

            if (!!$exp->salary_grade && !!$exp->salary_step) {
                $sheet->setCellValue('K' . $i, $exp->salary_grade . '-' . $exp->salary_step);
            } elseif (!!$exp->salary_grade && $exp->salary_step == null) {
                $sheet->setCellValue('K' . $i, $exp->salary_grade . '-0');
            } elseif ($exp->salary_grade == null && !!$exp->salary_step) {
                $sheet->setCellValue('K' . $i, '0-' . $exp->salary_step);
            }
            // $this->cellMapWithStyle($sheet, $exp, 'salary_grade', 'K' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $exp, 'status_appointment', 'L' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $exp, 'govt_services', 'M' . $i, 1, 10);
            $i++;
        }

        $sheet->setCellValue('J47', Carbon::now()->format('Y-m-d'));
        // $sheet->getStyle('J47')->getFont()->setBold(true);
        // $sheet->getStyle('J47')->getFont()->setSize(10);
        // $sheet->getStyle('J47')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


    }
    // done
    public function voluntaryAndInvolvement($sheet, $voluntaryAndInvolvement)
    {

        $i = 6;
        foreach ($voluntaryAndInvolvement as $vol) {


            $sheet->setCellValue('A' . $i, " $vol->name_organization / $vol->address_organization");
            $value =  !!$vol->from ? Carbon::parse($vol->from)->format('m/d/Y') : null;
            $sheet->setCellValue('E' . $i, $value);
            // $this->cellMapWithStyle($sheet, $vol, 'from', 'E' . $i, 1, 10);
            $value =  !!$vol->to ? Carbon::parse($vol->to)->format('m/d/Y') : null;
            $sheet->setCellValue('F' . $i, $value);
            // $this->cellMapWithStyle($sheet, $vol, 'to', 'F' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $vol, 'number_hours', 'G' . $i, 1, 10);

            $sheet->setCellValue('H' . $i, " $vol->position / $vol->nature_work");

            $i++;
        }
    }
    // done
    public function learningAndDevelopment($sheet, $learningAndDevelopment)
    {

        $i = 18;

        foreach ($learningAndDevelopment as $learning) {


            $this->cellMapWithStyle($sheet, $learning, 'title', 'A' . $i, 1, 10);
            $value =  !!$learning->from ? Carbon::parse($learning->from)->format('m/d/Y') : null;
            $sheet->setCellValue('E' . $i, $value);
            $value =  !!$learning->from ? Carbon::parse($learning->from)->format('m/d/Y') : null;
            $sheet->setCellValue('F' . $i, $value);
            // $this->cellMapWithStyle($sheet, $learning, 'from', 'E' . $i, 1, 10);
            // $this->cellMapWithStyle($sheet, $learning, 'to', 'F' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $learning, 'number_hours', 'G' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $learning, 'type_ld', 'H' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $learning, 'conducted_by', 'I' . $i, 1, 10);
            $i++;
        }
    }
    // done
    public function skils($sheet, $skills)
    {

        $i = 42;

        foreach ($skills as $skill) {


            $this->cellMapWithStyle($sheet, $skill, 'skills_hobbies', 'A' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $skill, 'recognition', 'C' . $i, 1, 10);
            $this->cellMapWithStyle($sheet, $skill, 'membership_organization', 'I' . $i, 1, 10);

            $i++;
        }
        $sheet->setCellValue('I50', Carbon::now()->format('Y-m-d'));
        $sheet->getStyle('I50')->getFont()->setBold(true);
        $sheet->getStyle('I50')->getFont()->setSize(10);
    }


    public function otherInfo($sheet, $otherInfo)
    {



        $this->checkboxCell($sheet, $otherInfo, 'no34_a', 'H6', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no34_a', 'J6', 'N');


        $this->checkboxCell($sheet, $otherInfo, 'no34_b', 'H8', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no34_b', 'J8', 'N');
        if ($otherInfo->no34_b == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no34_b_yes_details', 'H11', 1, 10, false);
        }

        $this->checkboxCell($sheet, $otherInfo, 'no35_a', 'H13', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no35_a', 'J13', 'N');
        if ($otherInfo->no35_a == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no35_a_yes_details', 'H15', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no35_b', 'H18', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no35_b', 'J18', 'N');

        if ($otherInfo->no35_b == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no35_b_date_filed', 'K20', 1, 10, false);
            $this->cellMapWithStyle($sheet, $otherInfo, 'no35_b_case_status', 'K21', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no36_a', 'H23', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no36_a', 'J23', 'N');
        if ($otherInfo->no36_a == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no36_a_yes_details', 'H25', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no37_a', 'H27', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no37_a', 'J27', 'N');
        if ($otherInfo->no37_a == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no37_a_yes_details', 'H29', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no38_a', 'H31', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no38_a', 'J31', 'N');
        if ($otherInfo->no38_a == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no38_a_yes_details', 'K32', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no38_b', 'H34', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no38_b', 'J34', 'N');
        if ($otherInfo->no38_b == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no38_b_yes_details', 'K35', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no39_a', 'H37', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no39_a', 'J37', 'N');
        if ($otherInfo->no39_a == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no39_a_yes_details', 'H39', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no40_a', 'H43', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no40_a', 'J43', 'N');
        if ($otherInfo->no40_a == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no40_a_yes_details', 'L44', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no40_b', 'H45', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no40_b', 'J45', 'N');
        if ($otherInfo->no40_b == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no40_b_yes_details', 'L46', 1, 10, false);
        }
        $this->checkboxCell($sheet, $otherInfo, 'no40_c', 'H47', 'Y');
        $this->checkboxCell($sheet, $otherInfo, 'no40_c', 'J47', 'N');
        if ($otherInfo->no40_c == 'Y') {

            $this->cellMapWithStyle($sheet, $otherInfo, 'no40_c_yes_details', 'L48', 1, 10, false);
        }


        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref1_name', 'A52', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref1_address', 'F52', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref1_tel', 'G52', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref2_name', 'A53', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref2_address', 'F53', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref2_tel', 'G53', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref3_name', 'A54', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref3_address', 'F54', 1, 10);
        $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref3_tel', 'G54', 1, 10);


        $eligibility = Eligibility::where('id_number', Auth::user()->id_number)->first();
        if ($eligibility) {
            $this->cellMapWithStyle($sheet, $eligibility, 'type', 'D61', 1, 10, false);
            $this->cellMapWithStyle($sheet, $eligibility, 'license_number', 'D62', 1, 10, false);
            $this->cellMapWithStyle($sheet, $eligibility, 'date_validity', 'D64', 1, 10, false);
        }
        if (!!Auth::user()->profile) {

            $widthInCm = 4.5; // desired width in cm

            $heightInCm = 3.5; // desired height in cm


            $widthInPixels = $widthInCm * 37.7952756;

            $heightInPixels = $heightInCm * 37.7952756;
            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Company Logo');

            $drawing->setPath(storage_path('app/public/' . Auth::user()->profile));
            $drawing->setCoordinates('K51');
            $drawing->setWidth(round($widthInPixels));
            $drawing->setHeight(round($heightInPixels));


            $worksheetHeight = $sheet->getHighestRow(); // e.g., 50

            $worksheetWidth = $sheet->getHighestColumn(); // get the highest column letter


            $worksheetWidthInPixels = 0;

            for ($i = 'A'; $i <= $worksheetWidth; $i++) {

                $worksheetWidthInPixels += $sheet->getColumnDimension($i)->getWidth() * 37.7952756;
            }


            $worksheetHeightInPixels = 0;

            for ($i = 1; $i <= $worksheetHeight; $i++) {

                $worksheetHeightInPixels += $sheet->getRowDimension($i)->getRowHeight() * 37.7952756;
            }


            // Calculate the offset values to center the image

            // $offsetX = ($worksheetWidthInPixels - $widthInPixels) / 2;

            // $offsetY = ($worksheetHeightInPixels - $heightInPixels) / 2;
            // $drawing->setWidth(180);
            // $drawing->setHeight(180);
            $offsetX = 17.02 * 37.7952756;

            $offsetY = 21.27 * 37.7952756;


            $drawing->setOffsetX(35);

            $drawing->setOffsetY(100);
            $drawing->setWorksheet($sheet);
        }

        if (!!$otherInfo->e_sig) {

            $drawing = new Drawing();
            $drawing->setName('sadad');
            $drawing->setDescription('Company sadad');

            $drawing->setPath(storage_path('app/public/' . $otherInfo->e_sig));
            $drawing->setCoordinates('F61');
            $drawing->setWidth(211);
            $drawing->setHeight(100);
            $drawing->setOffsetX(45);
            $drawing->setOffsetY(-20);
            $drawing->setWorksheet($sheet);
        }

        $sheet->setCellValue('F64', Carbon::now()->format('Y-m-d'));
        $sheet->setCellValue('E67', Carbon::now()->format('Y-m-d'));

    }
}
