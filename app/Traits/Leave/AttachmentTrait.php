<?php

namespace App\Traits\Leave;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Filament\Notifications\Notification;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

trait AttachmentTrait
{

    public function generateLeaveExcelFile(array $data)
    {


//        $i = 1;
//        $formattedDates = [];
//        $previousMonth = '';
//        foreach ($data['date'] as $date) {
//
//            $formattedDates[] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y'); // Format to "Nov 12"
//
//        }
//        $groupedByYear = [];
//
//        // Iterate through each date in the array
//        foreach ($formattedDates as $date) {
//            // Extract the year from the date string
//            $parts = explode(' ', $date);
//            $year = end($parts); // Get the last element, which is the year
//
//            // Remove the year from the date string for grouping
//            $dateWithoutYear = trim(str_replace($year, '', $date));
//
//            // Group by year
//            if (!isset($groupedByYear[$year])) {
//                $groupedByYear[$year] = []; // Initialize the array for this year if it doesn't exist
//            }
//            $groupedByYear[$year][] = trim($dateWithoutYear); // Add the date to the corresponding year
//        }
//        dd($groupedByYear);
//        // Output the grouped array
//        // Initialize an array to hold the formatted strings
//        $formattedStrings = [];
//
//        // Iterate over each year and its corresponding dates
//        foreach ($groupedByYear as $year => $dates) {
//            $formattedDates = [];
//            $lastMonth = '';
//
//            foreach ($dates as $date) {
//                // Extract the month and day
//                list($month, $day) = explode(' ', $date);
//
//                // If the month is the same as the last one, only add the day
//                if ($month === $lastMonth) {
//                    $formattedDates[] = $day;
//                } else {
//                    $formattedDates[] = $date; // Keep the full date (month and day)
//                    $lastMonth = $month; // Update the last month
//                }
//            }
//
//            // Join the dates with a comma
//            $datesString = implode(', ', $formattedDates);
//            // Combine the dates with the year
//            $formattedStrings[] = "$datesString $year";
//        }
//
//        // Join the formatted strings with " And "
//
//        // Join the formatted strings with " And "
//        $output = implode(' - ', $formattedStrings);


        // Output the final result
        $notpaid = (int)$data['notpaid_days'];
        $paid = (int)$data['paid_days'];
        $paidCount = 0;

        $i = 1;
        $formattedDates = [];
        $allFormattedDate = [];
        foreach ($data['date'] as $date) {
            $allFormattedDate[] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y');
            $paidCount++;
            if($paidCount <= $paid)
            {
                $formattedDates['paid'][] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y');
            }else{
                $formattedDates['notpaid'][] = true ? Carbon::parse($date)->format('M j Y') : Carbon::parse($date)->format('j Y');
            }
        }

        // all dates loop
        $allFormattedDateGroupYear = [];
        foreach ($allFormattedDate as $date) {

            // Extract the year from the date string
            $parts = explode(' ', $date);
            $year = end($parts); // Get the last element, which is the year

            // Remove the year from the date string for grouping
            $dateWithoutYear = trim(str_replace($year, '', $date));

            // Group by year
            if (!isset($allFormattedDateGroupYear[$year])) {
                $allFormattedDateGroupYear[$year] = []; // Initialize the array for this year if it doesn't exist
            }
            $allFormattedDateGroupYear[$year][] = trim($dateWithoutYear); // Add the date to the corresponding year
        }
        $formattedStringsAll = [];
        foreach ($allFormattedDateGroupYear as $year => $dates) {
            $formattedDatesAll = [];
            $lastMonth = '';

            foreach ($dates as $date) {
                // Extract the month and day
                list($month, $day) = explode(' ', $date);

                // If the month is the same as the last one, only add the day
                if ($month === $lastMonth) {
                    $formattedDatesAll[] = $day;
                } else {
                    $formattedDatesAll[] = $date; // Keep the full date (month and day)
                    $lastMonth = $month; // Update the last month
                }
            }

            // Join the dates with a comma
            $datesString = implode(', ', $formattedDatesAll);
            // Combine the dates with the year
            $formattedStringsAll[] = "$datesString $year";
        }

        $groupedByYear = [];
        foreach ($formattedDates as $key => $value) {


            foreach ($value as $date)
            {
                $parts = explode(' ', $date);

                $year = end($parts); // Get the last element, which is the year

                // Remove the year from the date string for grouping
                $dateWithoutYear = trim(str_replace($year, '', $date));

                // Group by year
                if (!isset($groupedByYear[$key][$year])) {
                    $groupedByYear[$key][$year] = []; // Initialize the array for this year if it doesn't exist
                }
                $groupedByYear[$key][$year][] = trim($dateWithoutYear);
            }

        }


        $formattedStrings = [];
        $newDate = [];
        foreach ($groupedByYear as $key => $value)
        {

            foreach ($value as $year => $dates) {

                $formattedDates = [];
                $lastMonth = '';

                foreach ($dates as $date) {
                    // Extract the month and day
                    list($month, $day) = explode(' ', $date);

                    // If the month is the same as the last one, only add the day
                    if ($month === $lastMonth) {
                        $formattedDates[] = $day;
                    } else {
                        $formattedDates[] = $date; // Keep the full date (month and day)
                        $lastMonth = $month; // Update the last month
                    }
                }

                // Join the dates with a comma
                $datesString = implode(', ', $formattedDates);
                // Combine the dates with the year
                $formattedStrings[$key][] = "$datesString $year";

            }

        }

        // Get the year from the first date
        $year = Carbon::parse($data['date'][0])->year; // Increment the year by 1

        // Create the final string
//        if (count($sample) > 1) {
//            // Separate the last date with 'AND'
//            $lastDate = array_pop($sample); // Remove the last date
//
//            $formattedString = implode(', ', $sample) . ' AND ' . $lastDate;
//        } else {
//            // If there's only one date, just return it
//            $formattedString = $sample[0] . ', ' . $year;
//        }
        $number = count($data['date']);

        $x = \App\Enums\TypeOfLeaveEnum::tryFrom($data['type_of_leave'])->leaveType();

        $inputFileName = public_path() . '/excel/Leave Form - Copy.xlsx';
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);
        $leave = $spreadsheet->getSheet(0);
        $leave->setCellValue('F13',  Carbon::now()->format('F d, Y'));
        $leave->setCellValue('F44',  Carbon::now()->subMonth()->endOfMonth()->format('F d, Y'));
        $leave->setCellValue('E35',  $number == 1 ? "$number DAY" : "$number DAYS");
        $leave->setCellValue('E37',  implode(', ',$formattedStringsAll));
        $leave->setCellValue('F47', (float)$this->leaves['vl']);
        $leave->setCellValue('G47', (float)$this->leaves['sl']);
        $leave->setCellValue('F49', (float)$this->leaves['vl']);
        $leave->setCellValue('G49', (float)$this->leaves['sl']);
        if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::VACATION_LEAVE->value) {
            $leave->setCellValue('F48', (float)$data['paid_days']);
            $leave->setCellValue('F49', (float)$this->leaves['vl'] - (float)$data['paid_days']);
        }
        if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::FORCE_LEAVE->value) {
            $leave->setCellValue('F48', (float)$data['paid_days']);
            $leave->setCellValue('F49', (float)$this->leaves['vl'] - (float)$data['paid_days']);
        }
        if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::SICK_LEAVE->value) {
            $leave->setCellValue('G48', (float)$data['paid_days']);
            $leave->setCellValue('G49', (float)$this->leaves['sl'] - (float)$data['paid_days']);
        }


        $richText = new RichText();
        $richText->createText('');
        $day = $richText->createTextRun("days with pay    ");
        $day->getFont()->setSize(7);
        $day->getFont()->setName('Arial');
        $paidArr = implode(', ', $formattedStrings['paid']);
        $payable = $richText->createTextRun("$data[type_of_leave], $paidArr");
        $payable->getFont()->setBold(true);
        $payable->getFont()->setSize(5);
        $payable->getFont()->setName('Arial');

        if((int)$data['notpaid_days'] > 0)
        {

            $notpaid = new RichText();
            $notpaid->createText('');
            $day = $notpaid->createTextRun("days without pay    ");
            $day->getFont()->setSize(7);
            $day->getFont()->setName('Arial');
            $notpaidArr = implode(', ', $formattedStrings['notpaid']);
            $payable = $notpaid->createTextRun("$data[type_of_leave], $notpaidArr");
            $payable->getFont()->setBold(true);
            $payable->getFont()->setSize(5);
            $payable->getFont()->setName('Arial');
            $leave->setCellValue('E57', $notpaid);
            $leave->setCellValue('B57', $data['notpaid_days']);

        }

        $leave->setCellValue('E56', $richText);

        $leave->setCellValue('B56', $data['paid_days']);
      // chief point leave



        $leave->setCellValue($x,  TRUE);
        if ($data['type_of_leave'] == \App\Enums\TypeOfLeaveEnum::OTHERS->value) {
            $leave->setCellValue('F32',  $data['other_leave']);
        }
        $leave->setCellValue('G11',  Auth::user()->userInfo?->lname);
        $leave->setCellValue('I11',  Auth::user()->userInfo?->fname);
        $leave->setCellValue('N11',  Auth::user()->userInfo?->mname);
        // head
        $head = User::query()->where('id_number', $data['head_id'])->first();
        $leave->setCellValue('L52',  $head?->name);
        // chief
        $chief = User::query()->where('id_number', $data['chief_id'])->first();
        $leave->setCellValue('E52',  $chief?->name);
        $leave->setCellValue('E53',  $data['chief_type']);

        // RD
        $rd = User::query()->where('id_number', $data['rd_id'])->first();
        $leave->setCellValue('G62',  $rd?->name);
        $leave->setCellValue('G63',  $data['rd_type']);

        // my
        if (Auth::user()->leavePointLatest?->e_sign) {
            $drawing = new Drawing();
            $drawing->setName('my_esign');
            $drawing->setDescription('Company my_esign');
            $my_esign = Auth::user()->leavePointLatest?->e_sign;
            $drawing->setPath(public_path("/storage/$my_esign"));
            $drawing->setCoordinates('M37'); // Cell where the image will be placed
            $drawing->setWidth(150);
            $drawing->setHeight(60);
            $drawing->setOffsetX(-40);
            $drawing->setOffsetY(-20);
            $drawing->setWorksheet($leave);
        }


        // // chief
        // $drawingChief = new Drawing();
        // $drawingChief->setName('chief');
        // $drawingChief->setDescription('Company chief');
        // $drawingChief->setPath(public_path("/storage/$data[e_sign]"));
        // $drawingChief->setCoordinates('F51'); // Cell where the image will be placed
        // $drawingChief->setWidth(150);
        // $drawingChief->setHeight(60);
        // $drawingChief->setOffsetX(-10);
        // $drawingChief->setOffsetY(-20);
        // $drawingChief->setWorksheet($leave);

        //  // RD
        //  $drawingRd = new Drawing();
        //  $drawingRd->setName('RD');
        //  $drawingRd->setDescription('Company RD');
        //  $drawingRd->setPath(public_path("/storage/$data[e_sign]"));
        //  $drawingRd->setCoordinates('I61'); // Cell where the image will be placed
        //  $drawingRd->setWidth(150);
        //  $drawingRd->setHeight(60);
        //  $drawingRd->setOffsetX(-60);
        //  $drawingRd->setOffsetY(-20);
        //  $drawingRd->setWorksheet($leave);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $name = Auth::user()->name;
        $fileName = time() . "- $name - Form 6.xlsx";
        $path = storage_path("app/public/leave/$name/");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $writer->save(storage_path("app/public/leave/$name/" . $fileName));
        return $fileName;
    }
    public function updateGenerateLeaveExcelFile(array $data, $type, $location)
    {
        $employeeName = User::select('id_number', 'name')->where('id_number', $data['id_number'])->first();

        $inputFileName = public_path() . "/storage/leave/$employeeName?->name/$data[old_file]";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($inputFileName);
        $leave = $spreadsheet->getSheet(0);

        // disapproved
        if ($location == 'Head' && $type == 'Disapproved') {

            $leave->setCellValue('I47', TRUE);
            $leave->setCellValue('M47', $data['remarks']['line1']);
            $leave->setCellValue('L48', $data['remarks']['line2']);
            $leave->setCellValue('L49', $data['remarks']['line3']);
        } elseif ($location == 'Rd' && $type == 'Disapproved') {
            $leave->setCellValue('N55', $data['remarks']['line1']);
            $leave->setCellValue('L56', $data['remarks']['line2']);
            $leave->setCellValue('L57', $data['remarks']['line3']);
            $leave->setCellValue('L58', $data['remarks']['line4']);
        }

        $my_esign = Auth::user()->leavePointLatest?->e_sign;
        // approved
        if ($location == 'Head') {
            // $leave->setCellValue('I47', FALSE);
            // $leave->setCellValue('M47', '');
            // $leave->setCellValue('L48', '');
            // $leave->setCellValue('L49', '');
            // head
            $drawingHead = new Drawing();
            $drawingHead->setName('head');
            $drawingHead->setDescription('Company head');

            $drawingHead->setPath(public_path("/storage/$my_esign"));
            $drawingHead->setCoordinates('M51'); // Cell where the image will be placed
            $drawingHead->setWidth(150);
            $drawingHead->setHeight(60);
            $drawingHead->setOffsetX(-30);
            $drawingHead->setOffsetY(-20);
            $drawingHead->setWorksheet($leave);
        } elseif ($location == 'Chief') {
            $drawingChief = new Drawing();
            $drawingChief->setName('chief');
            $drawingChief->setDescription('Company chief');

            $drawingChief->setPath(public_path("/storage/$my_esign"));
            $drawingChief->setCoordinates('F51'); // Cell where the image will be placed
            $drawingChief->setWidth(150);
            $drawingChief->setHeight(60);
            $drawingChief->setOffsetX(-10);
            $drawingChief->setOffsetY(-20);
            $drawingChief->setWorksheet($leave);
        } elseif ($location == 'Rd') {

            $drawingRd = new Drawing();
            $drawingRd->setName('rd');
            $drawingRd->setDescription('RD');
            $drawingRd->setPath(public_path("/storage/$my_esign"));
            $drawingRd->setCoordinates('I61'); // Cell where the image will be placed
            $drawingRd->setWidth(150);
            $drawingRd->setHeight(60);
            $drawingRd->setOffsetX(-60);
            $drawingRd->setOffsetY(-20);
            $drawingRd->setWorksheet($leave);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $path = storage_path("app/public/leave/$employeeName?->name/");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $fileName = time() . "- $employeeName?->name - Form 6.xlsx";
        $writer->save(storage_path("app/public/leave/$employeeName?->name/" . $fileName));

        return $fileName;
    }
}
