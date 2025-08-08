<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Address;
use App\Traits\CellMapTrait;
use Illuminate\Support\Facades\Log;
use App\Traits\ActivityTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class ExportController extends Controller
{
    use CellMapTrait;
    use ActivityTrait;
    public function index()
    {
        return view('export');
    }

    // done
    public function personalInformation($sheet, $userinfo)
    {


        $permanent =  Address::where('id_number', Auth::user()->id_number)->where('type', 'PERMANENT')->first();
        $residentials =  Address::where('id_number', Auth::user()->id_number)->where('type', 'RESIDENTIAL')->first();

        if ($userinfo) {
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




            $this->cellMapWithStyle($sheet, $userinfo, 'lname', 'D10', 1, 10, false);
            $this->cellMapWithStyle($sheet, $userinfo, 'fname', 'D11', 1, 10, false);
            $this->cellMapWithStyle($sheet, $userinfo, 'mname', 'D12', 1, 10, false);
            if (!!$userinfo->name_extension && $userinfo->name_extension != 'N/A') {
                $this->cellMapWithStyle($sheet, $userinfo, 'name_extension', 'L11', 1, 10, false);
                $richText = new RichText();
                $richText->createText('');

                $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)     ');
                $extension->getFont()->setSize(7);

                $n___A = $richText->createTextRun($userinfo->name_extension);
                $n___A->getFont()->setSize(9);
                $n___A->getFont()->setBold(true);
                $sheet->getCell('L11')->setValue($richText);
            } else {
                $richText = new RichText();
                $richText->createText('');

                $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)   ');
                $extension->getFont()->setSize(7);
                $n___A = $richText->createTextRun(" N/A");
                $n___A->getFont()->setSize(9);
                $n___A->getFont()->setBold(true);
                $sheet->getCell('L11')->setValue($richText);
            }


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
        } else {
            $sheet->setCellValue('D10', 'N/A');
            $sheet->setCellValue('D11', 'N/A');
            $sheet->setCellValue('D12', 'N/A');
            $sheet->setCellValue('D13', 'N/A');
            $sheet->setCellValue('D15', 'N/A');
            $sheet->setCellValue('D22', 'N/A');
            $sheet->setCellValue('D24', 'N/A');
            $sheet->setCellValue('D25', 'N/A');
            $sheet->setCellValue('D27', 'N/A');
            $sheet->setCellValue('D29', 'N/A');
            $sheet->setCellValue('D31', 'N/A');
            $sheet->setCellValue('D32', 'N/A');
            $sheet->setCellValue('D33', 'N/A');
            $sheet->setCellValue('D34', 'N/A');
            $sheet->setCellValue('I32', 'N/A');
            $sheet->setCellValue('I33', 'N/A');
        }

        // RESIDENTIALS ADDRESS
        if ($permanent) {
            $this->cellMapWithStyle($sheet, $permanent, 'house_no', 'I17', 2, 10);
            $this->cellMapWithStyle($sheet, $permanent, 'street', 'L17', 2, 10);
            $this->cellMapWithStyle($sheet, $permanent, 'subdivision', 'I19', 2, 10);
            $this->cellMapWithStyle($sheet, $permanent, 'brgy', 'L19', 2, 10);
            $this->cellMapWithStyle($sheet, $permanent, 'city', 'I22', 2, 10);
            $this->cellMapWithStyle($sheet, $permanent, 'province', 'L22', 2, 10);
            $this->cellMapWithStyle($sheet, $permanent, 'zipcode', 'I24', 2, 10);
        } else {
            $sheet->setCellValue('I17', 'N/A');
            $sheet->setCellValue('L17', 'N/A');
            $sheet->setCellValue('I19', 'N/A');
            $sheet->setCellValue('L19', 'N/A');
            $sheet->setCellValue('I22', 'N/A');
            $sheet->setCellValue('L22', 'N/A');
            $sheet->setCellValue('I24', 'N/A');
        }

        if ($residentials) {
            $this->cellMapWithStyle($sheet, $residentials, 'house_no', 'I25', 2, 10);
            $this->cellMapWithStyle($sheet, $residentials, 'street', 'L25', 2, 10);
            $this->cellMapWithStyle($sheet, $residentials, 'subdivision', 'I27', 2, 10);
            $this->cellMapWithStyle($sheet, $residentials, 'brgy', 'L27', 2, 10);
            $this->cellMapWithStyle($sheet, $residentials, 'city', 'I29', 2, 10);
            $this->cellMapWithStyle($sheet, $residentials, 'province', 'L29', 2, 10);
            $this->cellMapWithStyle($sheet, $residentials, 'zipcode', 'I31', 2, 10);
        } else {
            $sheet->setCellValue('I25', 'N/A');
            $sheet->setCellValue('L25', 'N/A');
            $sheet->setCellValue('I27', 'N/A');
            $sheet->setCellValue('L27', 'N/A');
            $sheet->setCellValue('I29', 'N/A');
            $sheet->setCellValue('L29', 'N/A');
            $sheet->setCellValue('I31', 'N/A');
        }
        $sheet->setCellValue('I34', Auth::user()->email);
    }
    // FIX N/A DONE
    public function familyBackground($sheet, $familyBackground, $childrens)
    {


        if ($familyBackground) {
            $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_lname', 'D36', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_fname', 'D37', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_mname', 'D38', 2, 10);
            if (!!$familyBackground->spouse_extension && $familyBackground->spouse_extension != 'N/A') {
                // $this->cellMapWithStyle($sheet, $familyBackground, 'spouse_extension', 'G37', 1, 10);
                $richText = new RichText();
                $richText->createText('');

                $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)');
                $extension->getFont()->setSize(7);
                $n___A = $richText->createTextRun(" " . $familyBackground->spouse_extension);
                $n___A->getFont()->setSize(7);
                $n___A->getFont()->setBold(true);
                $sheet->getCell('G37')->setValue($richText);
            } else {
                $richText = new RichText();
                $richText->createText('');

                $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)');
                $extension->getFont()->setSize(7);
                $n___A = $richText->createTextRun(" N/A");
                $n___A->getFont()->setSize(7);
                $n___A->getFont()->setBold(true);
                $sheet->getCell('G37')->setValue($richText);
            }
            $this->cellMapWithStyle($sheet, $familyBackground, 'occupation', 'D39', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'business_name', 'D40', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'business_address', 'D41', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'telephone_no', 'D42', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'father_lname', 'D43', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'father_fname', 'D44', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'father_mname', 'D45', 2, 10);
            if (!!$familyBackground->father_extension && $familyBackground->father_extension != 'N/A') {
                $this->cellMapWithStyle($sheet, $familyBackground, 'father_extension', 'G44', 1, 10);
                $richText = new RichText();
                $richText->createText('');

                $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)');
                $extension->getFont()->setSize(7);
                $n___A = $richText->createTextRun(" " . $familyBackground->father_extension);
                $n___A->getFont()->setSize(7);
                $n___A->getFont()->setBold(true);
                $sheet->getCell('G44')->setValue($richText);
            } else {
                $richText = new RichText();
                $richText->createText('');

                $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)');
                $extension->getFont()->setSize(7);
                $n___A = $richText->createTextRun(" N/A");
                $n___A->getFont()->setSize(7);
                $n___A->getFont()->setBold(true);
                $sheet->getCell('G44')->setValue($richText);
            }


            $this->cellMapWithStyle($sheet, $familyBackground, 'mother_lname', 'D47', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'mother_fname', 'D48', 2, 10);
            $this->cellMapWithStyle($sheet, $familyBackground, 'mother_mname', 'D49', 2, 10);
        } else {
            $sheet->setCellValue('D36', 'N/A');
            $sheet->setCellValue('D37', 'N/A');
            $sheet->setCellValue('D38', 'N/A');
            // $sheet->setCellValue('G37', 'N/A');
            $richText = new RichText();
            $richText->createText('');

            $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)');
            $extension->getFont()->setSize(7);
            $n___A = $richText->createTextRun(" N/A");
            $n___A->getFont()->setSize(7);
            $n___A->getFont()->setBold(true);
            $sheet->getCell('G37')->setValue($richText);
            $sheet->setCellValue('D39', 'N/A');
            $sheet->setCellValue('D40', 'N/A');
            $sheet->setCellValue('D41', 'N/A');
            $sheet->setCellValue('D42', 'N/A');
            $sheet->setCellValue('D43', 'N/A');
            $sheet->setCellValue('D44', 'N/A');
            $sheet->setCellValue('D45', 'N/A');
            $sheet->setCellValue('D47', 'N/A');
            $sheet->setCellValue('D48', 'N/A');
            $sheet->setCellValue('D49', 'N/A');
            $richText = new RichText();
            $richText->createText('');

            $extension = $richText->createTextRun('NAME EXTENSION (JR., SR)');
            $extension->getFont()->setSize(7);
            $n___A = $richText->createTextRun(" N/A");
            $n___A->getFont()->setSize(7);
            $n___A->getFont()->setBold(true);
            $sheet->getCell('G44')->setValue($richText);
        }

        if ($childrens->count() > 0) {
            $i = 37;
            foreach ($childrens as $child) {
                $value =  !!$child->child_birth_date ?  Crypt::decryptString($child->child_birth_date) : null;
                $final =  !!$child->child_birth_date ?  Carbon::parse($value)->format('m/d/Y') : null;
                $sheet->setCellValue('M' . $i, $final);
                $this->cellMapWithStyle($sheet, $child, 'child_name', 'I' . $i, 2, 10);

                $i++;
            }
        } else {

            $sheet->setCellValue('I37', 'N/A');
            $sheet->setCellValue('M37', 'N/A');
        }
    }
    // FIX N/A DONE
    public function educationalBackground($sheet, $educationalBackgrounds)
    {

        $secondary = $educationalBackgrounds->where('level', 'SECONDARY')->first();
        $elementary = $educationalBackgrounds->where('level', 'ELEMENTARY')->first();
        $vocational = $educationalBackgrounds->where('level', 'VOCATIONAL')->first();
        $college = $educationalBackgrounds->where('level', 'COLLEGE')->first();
        $studies = $educationalBackgrounds->where('level', 'GRADUATE STUDIES')->first();
        if ($elementary) {
            $cellNum = '54';
            $this->cellMapWithStyle($sheet, $elementary, 'school_name', 'D' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $elementary, 'course_education', 'G' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $elementary, 'from', 'J' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $elementary, 'to', 'K' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $elementary, 'unit_earned', 'L' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $elementary, 'year_graduated', 'M' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $elementary, 'academic_honor_received', 'N' . $cellNum, 1, 10);
        } else {
            $cellNum = '54';
            $sheet->setCellValue('D' . $cellNum, 'N/A');
            $sheet->setCellValue('G' . $cellNum, 'N/A');
            $sheet->setCellValue('J' . $cellNum, 'N/A');
            $sheet->setCellValue('K' . $cellNum, 'N/A');
            $sheet->setCellValue('L' . $cellNum, 'N/A');
            $sheet->setCellValue('M' . $cellNum, 'N/A');
            $sheet->setCellValue('N' . $cellNum, 'N/A');
        }
        if ($secondary) {
            $cellNum = '55';
            $this->cellMapWithStyle($sheet, $secondary, 'school_name', 'D' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $secondary, 'course_education', 'G' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $secondary, 'from', 'J' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $secondary, 'to', 'K' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $secondary, 'unit_earned', 'L' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $secondary, 'year_graduated', 'M' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $secondary, 'academic_honor_received', 'N' . $cellNum, 1, 10);
        } else {
            $cellNum = '55';
            $sheet->setCellValue('D' . $cellNum, 'N/A');
            $sheet->setCellValue('G' . $cellNum, 'N/A');
            $sheet->setCellValue('J' . $cellNum, 'N/A');
            $sheet->setCellValue('K' . $cellNum, 'N/A');
            $sheet->setCellValue('L' . $cellNum, 'N/A');
            $sheet->setCellValue('M' . $cellNum, 'N/A');
            $sheet->setCellValue('N' . $cellNum, 'N/A');
        }
        if ($vocational) {
            $cellNum = '56';
            $this->cellMapWithStyle($sheet, $vocational, 'school_name', 'D' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $vocational, 'course_education', 'G' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $vocational, 'from', 'J' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $vocational, 'to', 'K' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $vocational, 'unit_earned', 'L' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $vocational, 'year_graduated', 'M' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $vocational, 'academic_honor_received', 'N' . $cellNum, 1, 10);
        } else {
            $cellNum = '56';
            $sheet->setCellValue('D' . $cellNum, 'N/A');
            $sheet->setCellValue('G' . $cellNum, 'N/A');
            $sheet->setCellValue('J' . $cellNum, 'N/A');
            $sheet->setCellValue('K' . $cellNum, 'N/A');
            $sheet->setCellValue('L' . $cellNum, 'N/A');
            $sheet->setCellValue('M' . $cellNum, 'N/A');
            $sheet->setCellValue('N' . $cellNum, 'N/A');
        }
        if ($college) {
            $cellNum = '57';
            $this->cellMapWithStyle($sheet, $college, 'school_name', 'D' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $college, 'course_education', 'G' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $college, 'from', 'J' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $college, 'to', 'K' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $college, 'unit_earned', 'L' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $college, 'year_graduated', 'M' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $college, 'academic_honor_received', 'N' . $cellNum, 1, 10);
        } else {
            $cellNum = '57';
            $sheet->setCellValue('D' . $cellNum, 'N/A');
            $sheet->setCellValue('G' . $cellNum, 'N/A');
            $sheet->setCellValue('J' . $cellNum, 'N/A');
            $sheet->setCellValue('K' . $cellNum, 'N/A');
            $sheet->setCellValue('L' . $cellNum, 'N/A');
            $sheet->setCellValue('M' . $cellNum, 'N/A');
            $sheet->setCellValue('N' . $cellNum, 'N/A');
        }
        if ($studies) {
            $cellNum = '58';
            $this->cellMapWithStyle($sheet, $studies, 'school_name', 'D' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $studies, 'course_education', 'G' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $studies, 'from', 'J' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $studies, 'to', 'K' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $studies, 'unit_earned', 'L' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $studies, 'year_graduated', 'M' . $cellNum, 1, 10);
            $this->cellMapWithStyle($sheet, $studies, 'academic_honor_received', 'N' . $cellNum, 1, 10);
        } else {
            $cellNum = '58';
            $sheet->setCellValue('D' . $cellNum, 'N/A');
            $sheet->setCellValue('G' . $cellNum, 'N/A');
            $sheet->setCellValue('J' . $cellNum, 'N/A');
            $sheet->setCellValue('K' . $cellNum, 'N/A');
            $sheet->setCellValue('L' . $cellNum, 'N/A');
            $sheet->setCellValue('M' . $cellNum, 'N/A');
            $sheet->setCellValue('N' . $cellNum, 'N/A');
        }

        $sheet->setCellValue('L60', Carbon::now()->format('m/d/Y'));
    }
    // FIX N/A DONE
    public function civilServiceEligibility($sheet, $eligibilitys)
    {
        $i = 5;
        if ($eligibilitys->count() > 0) {

            foreach ($eligibilitys as $eligibility) {
                $this->cellMapWithStyle($sheet, $eligibility, 'license_title', 'A' . $i, 1, 10);
                $this->cellMapWithStyle($sheet, $eligibility, 'rating', 'F' . $i, 1, 10);
                $sheet->setCellValue('G' . $i, Carbon::parse($eligibility->date_examination)->format('m/d/Y'));
                // $this->cellMapWithStyle($sheet, $eligibility, 'date_examination', 'G' . $i, 1, 10);
                $this->cellMapWithStyle($sheet, $eligibility, 'place_examination', 'I' . $i, 1, 10);
                $this->cellMapWithStyle($sheet, $eligibility, 'license_number', 'L' . $i, 1, 10);
                // $this->cellMapWithStyle($sheet, $eligibility, 'date_validity', 'M' . $i, 1, 10);
                $sheet->setCellValue('M' . $i, Carbon::parse($eligibility->date_validity)->format('m/d/Y'));
                $i++;
            }
        } else {
            $sheet->setCellValue('A5', 'N/A');
            $sheet->setCellValue('F5', 'N/A');
            $sheet->setCellValue('G5', 'N/A');
            $sheet->setCellValue('I5', 'N/A');
            $sheet->setCellValue('L5', 'N/A');
            $sheet->setCellValue('M5', 'N/A');
        }
    }
    // FIX N/A DONE
    public function workExperience($sheet, $workExperience)
    {

        $i = 18;
        if ($workExperience->count() > 0) {
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

                $this->cellMapWithStyle($sheet, $exp, 'status_appointment', 'L' . $i, 1, 10);
                $this->cellMapWithStyle($sheet, $exp, 'govt_services', 'M' . $i, 1, 10);
                $i++;
            }
        } else {
            $sheet->setCellValue('A18', 'N/A');
            $sheet->setCellValue('C18', 'N/A');
            $sheet->setCellValue('D18', 'N/A');
            $sheet->setCellValue('G18', 'N/A');
            $sheet->setCellValue('J18', 'N/A');
            $sheet->setCellValue('K18', 'N/A');
            $sheet->setCellValue('L18', 'N/A');
            $sheet->setCellValue('M18', 'N/A');
        }

        $sheet->setCellValue('J47', Carbon::now()->format('m/d/Y'));
    }
    // done
    public function voluntaryAndInvolvement($sheet, $voluntaryAndInvolvement, $spreadSheet)
    {

        $i = 6;
        if ($voluntaryAndInvolvement->count() > 0) {
            $create = false;
            foreach ($voluntaryAndInvolvement as $vol) {

                if ($voluntaryAndInvolvement->count() > 7) {
                    if ($create == false) {
                        $clonedWorksheet = clone $sheet;
                        $clonedWorksheet->setTitle('C(3.1)');
                        $spreadSheet->addSheet($clonedWorksheet);
                        $create = true;
                    }
                }
                if ($i >= 13) {
                    $sheet5 = $spreadSheet->getSheetByName('C(3.1)');

                    $sheet5->setCellValue('A' . $i - 7,   strtoupper(" $vol->name_organization / $vol->address_organization"));
                    $value =  !!$vol->from ? Carbon::parse($vol->from)->format('m/d/Y') : null;
                    $sheet5->setCellValue('E' . $i - 7, $value);

                    $value =  !!$vol->to ? Carbon::parse($vol->to)->format('m/d/Y') : null;
                    $sheet5->setCellValue('F' . $i - 7, strtoupper($value));

                    $this->cellMapWithStyle($sheet5, $vol, 'number_hours', 'G' . $i - 7, 1, 10);

                    $sheet5->setCellValue('H' . $i - 7, strtoupper(" $vol->position / $vol->nature_work") );

                    $i++;
                } else {
                    $sheet->setCellValue('A' . $i, strtoupper(" $vol->name_organization / $vol->address_organization"));
                    $value =  !!$vol->from ? Carbon::parse($vol->from)->format('m/d/Y') : null;
                    $sheet->setCellValue('E' . $i, $value);

                    $value =  !!$vol->to ? Carbon::parse($vol->to)->format('m/d/Y') : null;
                    $sheet->setCellValue('F' . $i,strtoupper($value));

                    $this->cellMapWithStyle($sheet, $vol, 'number_hours', 'G' . $i, 1, 10);

                    $sheet->setCellValue('H' . $i,strtoupper(" $vol->position / $vol->nature_work") );

                    $i++;
                }
            }
        } else {
            $sheet->setCellValue('A6', "N/A");
            $sheet->setCellValue('E6', "N/A");
            $sheet->setCellValue('F6', "N/A");
            $sheet->setCellValue('G6', "N/A");
            $sheet->setCellValue('H6', "N/A");
        }
    }
    // done
    public function learningAndDevelopment($sheet, $learningAndDevelopment, $spreadSheet)
    {

        $i = 18;

        if ($learningAndDevelopment->count() > 0) {
            foreach ($learningAndDevelopment as $learning) {
                if ($learningAndDevelopment->count() > 21 && $spreadSheet->getSheetByName('C(3.1)') == null) {
                    $clonedWorksheet = clone $sheet;
                    $clonedWorksheet->setTitle('C(3.1)');
                    $spreadSheet->addSheet($clonedWorksheet);
                }

                if ($i >= 39) {
                    $sheet5 = $spreadSheet->getSheetByName('C(3.1)');
                    $this->cellMapWithStyle($sheet5, $learning, 'title', 'A' . $i - 21, 1, 10);
                    $value =  !!$learning->from ? Carbon::parse($learning->from)->format('m/d/Y') : null;
                    $sheet5->setCellValue('E' . $i - 21, strtoupper($value));
                    $value =  !!$learning->to ? Carbon::parse($learning->to)->format('m/d/Y') : null;
                    $sheet5->setCellValue('F' . $i - 21, strtoupper($value));

                    $this->cellMapWithStyle($sheet5, $learning, 'number_hours', 'G' . $i - 21, 1, 10);
                    $this->cellMapWithStyle($sheet5, $learning, 'type_ld', 'H' . $i - 21, 1, 10);
                    $this->cellMapWithStyle($sheet5, $learning, 'conducted_by', 'I' . $i - 21, 1, 10);
                    $i++;
                } else {
                    $this->cellMapWithStyle($sheet, $learning, 'title', 'A' . $i, 1, 10);
                    $value =  !!$learning->from ? Carbon::parse($learning->from)->format('m/d/Y') : null;
                    $sheet->setCellValue('E' . $i, strtoupper($value));
                    $value =  !!$learning->to ? Carbon::parse($learning->to)->format('m/d/Y') : null;
                    $sheet->setCellValue('F' . $i, strtoupper($value));

                    $this->cellMapWithStyle($sheet, $learning, 'number_hours', 'G' . $i, 1, 10);
                    $this->cellMapWithStyle($sheet, $learning, 'type_ld', 'H' . $i, 1, 10);
                    $this->cellMapWithStyle($sheet, $learning, 'conducted_by', 'I' . $i, 1, 10);
                    $i++;

                }
            }
        } else {
            $sheet->setCellValue('A18', "N/A");
            $sheet->setCellValue('E18', "N/A");
            $sheet->setCellValue('F18', "N/A");
            $sheet->setCellValue('G18', "N/A");
            $sheet->setCellValue('H18', "N/A");
            $sheet->setCellValue('I18', "N/A");
        }
    }
    // done
    public function skils($sheet, $skills, $spreadSheet)
    {

        $i = 42;

        if ($skills->count() > 0) {
            foreach ($skills as $skill) {
                if ($skills->count() > 21 && $spreadSheet->getSheetByName('C(3.1)') == null) {
                    $clonedWorksheet = clone $sheet;
                    $clonedWorksheet->setTitle('C(3.1)');
                    $spreadSheet->addSheet($clonedWorksheet);
                }

                if ($i >= 49) {
                    $sheet5 = $spreadSheet->getSheetByName('C(3.1)');
                    $this->cellMapWithStyle($sheet5, $skill, 'skills_hobbies', 'A' . $i - 7, 1, 10);
                    $i++;
                } else {
                    $this->cellMapWithStyle($sheet, $skill, 'skills_hobbies', 'A' . $i, 1, 10);
                    $i++;
                }



            }
        } else {
            $sheet->setCellValue('A42', "N/A");
        }
        $sheet->setCellValue('I50', Carbon::now()->format('m/d/Y'));
        $sheet->getStyle('I50')->getFont()->setBold(true);
        $sheet->getStyle('I50')->getFont()->setSize(10);
    }
    public function association($sheet, $association,$spreadSheet)
    {

        $i = 42;

        if ($association->count() > 0) {
            foreach ($association as $value) {

                if ($association->count() > 21 && $spreadSheet->getSheetByName('C(3.1)') == null) {
                    $clonedWorksheet = clone $sheet;
                    $clonedWorksheet->setTitle('C(3.1)');
                    $spreadSheet->addSheet($clonedWorksheet);
                }

                if ($i >= 49) {
                    $sheet5 = $spreadSheet->getSheetByName('C(3.1)');
                    $this->cellMapWithStyle($sheet5, $value, 'association', 'I' . $i - 7, 1, 10);

                    $i++;
                } else {
                    $this->cellMapWithStyle($sheet, $value, 'association', 'I' . $i, 1, 10);

                    $i++;
                }

            }
        } else {
            $sheet->setCellValue('I42', "N/A");
        }
    }
    public function distinction($sheet, $distinction,$spreadSheet)
    {

        $i = 42;

        if ($distinction->count() > 0) {
            foreach ($distinction as $value) {
                if ($distinction->count() > 21 && $spreadSheet->getSheetByName('C(3.1)') == null) {
                    $clonedWorksheet = clone $sheet;
                    $clonedWorksheet->setTitle('C(3.1)');
                    $spreadSheet->addSheet($clonedWorksheet);
                }

                if ($i >= 49) {
                    $sheet5 = $spreadSheet->getSheetByName('C(3.1)');
                    $this->cellMapWithStyle($sheet5, $value, 'distinction', 'C' . $i - 7, 1, 10);

                    $i++;
                } else {
                    $this->cellMapWithStyle($sheet, $value, 'distinction', 'C' . $i, 1, 10);

                    $i++;
                }


            }
        } else {
            $sheet->setCellValue('C42', "N/A");
        }
    }


    public function otherInfo($sheet, $otherInfo)
    {



        if ($otherInfo) {
            $this->checkboxCell($sheet, $otherInfo, 'no34_a', 'H6', 'Y');
            $this->checkboxCell($sheet, $otherInfo, 'no34_a', 'J6', 'N');


            $this->checkboxCell($sheet, $otherInfo, 'no34_b', 'H8', 'Y');
            $this->checkboxCell($sheet, $otherInfo, 'no34_b', 'J8', 'N');
            if ($otherInfo->no34_b == 'Y') {
                // $sheet->mergeCells('H11:L11', Worksheet::MERGE_CELL_CONTENT_HIDE);
                $this->cellMapWithStyle($sheet, $otherInfo, 'no34_b_yes_details', 'H11', 1, 10, false);
            }

            $this->checkboxCell($sheet, $otherInfo, 'no35_a', 'H13', 'Y');
            $this->checkboxCell($sheet, $otherInfo, 'no35_a', 'J13', 'N');
            if ($otherInfo->no35_a == 'Y') {
                // $sheet->mergeCells('H15:L15', Worksheet::MERGE_CELL_CONTENT_HIDE);
                $this->cellMapWithStyle($sheet, $otherInfo, 'no35_a_yes_details', 'H15', 1, 10, false);
            }
            $this->checkboxCell($sheet, $otherInfo, 'no35_b', 'H18', 'Y');
            $this->checkboxCell($sheet, $otherInfo, 'no35_b', 'J18', 'N');

            if ($otherInfo->no35_b == 'Y') {
                // $sheet->mergeCells('K20:L20', Worksheet::MERGE_CELL_CONTENT_HIDE);
                // $sheet->mergeCells('K21:L21', Worksheet::MERGE_CELL_CONTENT_HIDE);
                $this->cellMapWithStyle($sheet, $otherInfo, 'no35_b_date_filed', 'K20', 1, 10, false);
                $this->cellMapWithStyle($sheet, $otherInfo, 'no35_b_case_status', 'K21', 1, 10, false);
            }
            $this->checkboxCell($sheet, $otherInfo, 'no36_a', 'H23', 'Y');
            $this->checkboxCell($sheet, $otherInfo, 'no36_a', 'J23', 'N');
            if ($otherInfo->no36_a == 'Y') {
                // $sheet->mergeCells('H25:L25', Worksheet::MERGE_CELL_CONTENT_HIDE);
                $this->cellMapWithStyle($sheet, $otherInfo, 'no36_a_yes_details', 'H25', 1, 10, false);
            }
            $this->checkboxCell($sheet, $otherInfo, 'no37_a', 'H27', 'Y');
            $this->checkboxCell($sheet, $otherInfo, 'no37_a', 'J27', 'N');
            if ($otherInfo->no37_a == 'Y') {
                // $sheet->mergeCells('H29:L29', Worksheet::MERGE_CELL_CONTENT_HIDE);
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
                // $sheet->mergeCells('H39:L39', Worksheet::MERGE_CELL_CONTENT_HIDE);
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


            if (!!$otherInfo->c_ref1_name) {
                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref1_name', 'A52', 1, 10);
                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref1_address', 'F52', 1, 10);
                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref1_tel', 'G52', 1, 10);
            }
            else {
                $sheet->setCellValue('A52', "N/A");
                $sheet->setCellValue('F52', "N/A");
                $sheet->setCellValue('G52', "N/A");
            }
               if (!!$otherInfo->c_ref2_name) {

                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref2_name', 'A53', 1, 10);
                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref2_address', 'F53', 1, 10);
                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref2_tel', 'G53', 1, 10);
            }
            else {
                $sheet->setCellValue('A53', "N/A");
                $sheet->setCellValue('F53', "N/A");
                $sheet->setCellValue('G53', "N/A");
            }
              if (!!$otherInfo->c_ref3_name) {


                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref3_name', 'A54', 1, 10);
                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref3_address', 'F54', 1, 10);
                $this->cellMapWithStyle($sheet, $otherInfo, 'c_ref3_tel', 'G54', 1, 10);
            } else {
                $sheet->setCellValue('A54', "N/A");
                $sheet->setCellValue('F54', "N/A");
                $sheet->setCellValue('G54', "N/A");
            }
        } else {
            $sheet->setCellValue('A52', "N/A");
            $sheet->setCellValue('F52', "N/A");
            $sheet->setCellValue('G52', "N/A");
        }

        // $eligibility = Eligibility::where('id_number', Auth::user()->id_number)->first();
        // if ($eligibility) {
        //     $this->cellMapWithStyle($sheet, $eligibility, 'type', 'D61', 1, 10, false);
        //     $this->cellMapWithStyle($sheet, $eligibility, 'license_number', 'D62', 1, 10, false);
        //     $this->cellMapWithStyle($sheet, $eligibility, 'date_validity', 'D64', 1, 10, false);
        // }

        // $sheet->mergeCells('F64:I64', Worksheet::MERGE_CELL_CONTENT_HIDE);





    }

    public function exportUsser()
    {

        $spreadsheet = new Spreadsheet();
        $templatePath = public_path('/CS Form No. 212 Personal Data Sheet revised(1).xlsx');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($templatePath);

        $sheet2 = $spreadsheet->getSheet(1);
        $sheet3 = $spreadsheet->getSheet(2);
        $sheet4 = $spreadsheet->getSheet(3);
        $sheet = $spreadsheet->getSheet(0);

        $sheet4->setCellValue('A67', 'SUBSCRIBED AND SWORN to before me this __________________________________ , affiant exhibiting his/her validly issued government ID as indicated above.');

        $sheet4->setCellValue('F64', Carbon::now()->format('m/d/Y'));


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
            $drawing->setWorksheet($sheet4);
        }


        $userinfo = User::with(['userInfo', 'distinction', 'association', 'skillHobbies', 'learningAndDevelopment', 'civilServiceEligibility', 'workExperience', 'voluntaryAndInvolvement', 'educationalBackground', 'familyBackground', 'familyBackgroundChildren', 'otherInfo'])->where('id_number', Auth::user()->id_number)->first();


        if ($userinfo) {

            $this->otherInfo($sheet4, $userinfo->otherInfo);
            $this->voluntaryAndInvolvement($sheet3, $userinfo->voluntaryAndInvolvement, $spreadsheet);
            $this->learningAndDevelopment($sheet3, $userinfo->learningAndDevelopment, $spreadsheet);
            $this->skils($sheet3, $userinfo->skillHobbies, $spreadsheet);
            $this->association($sheet3, $userinfo->association,$spreadsheet);
            $this->distinction($sheet3, $userinfo->distinction,$spreadsheet);

            $this->civilServiceEligibility($sheet2, $userinfo->civilServiceEligibility);
            $this->workExperience($sheet2, $userinfo->workExperience);

            $this->personalInformation($sheet, $userinfo->userInfo);


            $this->familyBackground($sheet, $userinfo->familyBackground, $userinfo->familyBackgroundChildren);

            $this->educationalBackground($sheet, $userinfo->educationalBackground);
        }



        if ($userinfo  && !!$userinfo->otherinfo?->e_sig) {
            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Company Logo');

            $drawing->setPath(storage_path('app/public/' . $userinfo->otherinfo?->e_sig));
            $drawing->setCoordinates('F60');
            $drawing->setWidth(211);
            $drawing->setHeight(100);
            $drawing->setOffsetX(45);
            $drawing->setOffsetY(-20);
            $drawing->setWorksheet($sheet4);


            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Company Logo');
            $drawing->setPath(storage_path('app/public/' . $userinfo->otherinfo?->e_sig));
            $drawing->setCoordinates('F47');
            $drawing->setWidth(211);
            $drawing->setHeight(100);
            $drawing->setOffsetX(-65);
            $drawing->setOffsetY(-40);

            $drawing->setWorksheet($sheet2);

            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Company Logo');
            $drawing->setPath(storage_path('app/public/' . $userinfo->otherinfo?->e_sig));
            $drawing->setCoordinates('F60');
            $drawing->setWidth(211);
            $drawing->setHeight(100);
            $drawing->setOffsetX(-65);
            $drawing->setOffsetY(-40);

            $drawing->setWorksheet($sheet);


            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Company Logo');
            $drawing->setPath(storage_path('app/public/' . $userinfo->otherinfo?->e_sig));
            $drawing->setCoordinates('D50');
            $drawing->setWidth(211);
            $drawing->setHeight(100);
            $drawing->setOffsetX(30);
            $drawing->setOffsetY(-40);

            $drawing->setWorksheet($sheet3);
        }
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath(public_path('/k.png'));
        $drawing->setCoordinates('A2');
        $drawing->setWidth(35);
        $drawing->setHeight(35);
        $drawing->setOffsetX(-2);
        $drawing->setOffsetY(0);

        $drawing->setWorksheet($sheet);
        $director = \App\Models\Director::first();
        $richText = new RichText();
        $richText->createText('');

        $payable = $richText->createTextRun($director?->name);
        $payable->getFont()->setBold(true);
        $payable->getFont()->setSize(9);
        $director = $richText->createTextRun("\n" . $director?->position);
        $director->getFont()->setSize(8);
        $dis = $richText->createTextRun("\n" . 'Pursuant to EO 292, as amended by RA 10755');
        $dis->getFont()->setSize(7);
        $sheet4->getCell('E68')->setValue($richText);

        $fileName = Auth::user()->name . '-' . Carbon::now()->format('Y-m-d') . ".xlsx";
        // return \Maatwebsite\Excel\Facades\Excel::download(new UsersExport, 'users.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(storage_path('app/public/' . $fileName));
        $this->storeActivityLog('Download PDF');
        Log::info("$userinfo?->name Generate PDS");
        return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
    }
}
