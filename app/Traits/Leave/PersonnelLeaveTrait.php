<?php

namespace App\Traits\Leave;

use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

trait PersonnelLeaveTrait
{



    public function loadDtr(): void
    {
        $arr = [];
        $arrival_am = [];
        $departure_am = [];
        $arrival_pm = [];
        $increment = 1;
        $departure_pm = [];
        $iterationCount = 1;
        $x = 1;
        if (!$this->file) {
            $this->dtrArr = [];
            return;
        }
        $spreadsheet = new Spreadsheet();
        $templatePath = storage_path('/app/livewire-tmp/' . $this->file);
        $reader = new Xlsx();
        $spreadsheet = $reader->load($templatePath);
        $sheet = $spreadsheet->getSheet(0);

        $this->month = Carbon::parse($sheet->getCell('D15')->getValue())->format('F Y');
        $iterationNew = 0;
        $name = "";
        foreach ($sheet->getRowIterator() as $key => $row) {

            $cellA = $sheet->getCell("A$key");
            if ($iterationNew === 0) {
                $name = $sheet->getCell("A13")->getFormattedValue();
            }
            // Check for "In Charge" header
            if ($cellA->getValue() == 'In Charge') {

                $iterationNew++;
                $var = $key + 1;
                $name = $sheet->getCell("A$var")->getFormattedValue();
                $x = 1;
                $increment++;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            if (gettype($sheet->getCell("A$key")->getValue()) == 'integer') {
                # always run if meet the condition
                $i[] = $key;
                $iterationCount++;
                $columnValue = $sheet->getCell("A$key")->getValue();
                $date = Carbon::parse($sheet->getCell('D15')->getValue())->addDays((int)$columnValue - 1);
                $this->globalMonth = Carbon::parse($sheet->getCell('D15')->getValue());

                // $value["$x-$columnValue"] = $date->format('F d, Y');
                $arrival_am["$x-$columnValue"] = $this->getColumnValue("B$key", $sheet, $date, false);
                $departure_am["$x-$columnValue"] = $this->getColumnValue("C$key", $sheet, $date, false);
                $arrival_pm["$x-$columnValue"] = $this->getColumnValue("D$key", $sheet, $date, false);
                $departure_pm["$x-$columnValue"] = $this->getColumnValue("E$key", $sheet, $date, false);



                $arr["$increment-" . str_replace(' ', '_', $this->month) . "--" . $name]['id_number'] = "";
                $arr["$increment-" . str_replace(' ', '_', $this->month) . "--" . $name]['status'] = "PENDING";
                $arr["$increment-" . str_replace(' ', '_', $this->month) . "--" . $name]['data']["$x-$columnValue"] = [
                    'date_arrival_am' => $arrival_am["$x-$columnValue"],
                    'date_departure_am' => $departure_am["$x-$columnValue"],
                    'date_arrival_pm' => $arrival_pm["$x-$columnValue"],
                    'date_departure_pm' => $departure_pm["$x-$columnValue"],
                ];

                $x++;
            }
        }

        $late = '';
        $undertime = '';
        $type = 'Absent';
        $x = 1;
        $iterationCount = 1;

        //        latest
        foreach ($arr as $key => $days) {

            foreach ($days['data'] as $dayKey => $day) {

                $date = Carbon::parse($this->month)->addDays((int)explode('-', $dayKey)[1] - 1);

                $arrival_start = '';
                $arrival_end = '';
                $departure_start = '';
                $departure_end = '';
                    $editable = true;
                if (!!$day['date_arrival_am']) {
                    $arrival_start = str_contains($day['date_arrival_am'], 'TRAVEL') ? $day['date_arrival_am'] : Carbon::parse($day['date_arrival_am']);
                }

                if (!!$day['date_departure_am']) {
                    $departure_start = str_contains($day['date_departure_am'], 'TRAVEL') ? $day['date_departure_am'] : Carbon::parse($day['date_departure_am']);
                }

                if (!!$day['date_arrival_pm']) {
                    $arrival_end = str_contains($day['date_arrival_pm'], 'TRAVEL') ? $day['date_arrival_pm'] : Carbon::parse($day['date_arrival_pm']);
                }
                if (!!$day['date_departure_pm']) {
                    $departure_end = str_contains($day['date_departure_pm'], 'TRAVEL') ? $day['date_departure_pm'] : Carbon::parse($day['date_departure_pm']);
                }

                // check event
                $event = \App\Models\Leave\LeaveCalendar::query()->whereDate('start', $date)->first();

                if (str_contains($day['date_arrival_am'], 'TRAVEL')) {
                    $type = 'travel';
                     $editable = false;
                }
                # in: true , out: true , in: true, out: true
                elseif (!!$arrival_start && !!$arrival_end && !!$departure_start && !!$departure_end) {

                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);
                    $difference = $arrival_start->diff($departure_end);

                    $undertime = $this->estimateUndertime($difference);
                    $type = 'Full';
                     $editable = false;
                }
                # in: false , out: false , in: false, out: false
                elseif ($arrival_start == '' && $arrival_end == '' && $departure_start == '' && $departure_end == '') {

                    $type = 'Absent';
                    $difference = '';
                    $late = 0;
                    $undertime = 0;

                }
                # in: false , out: true , in: true, out: false
                elseif ($arrival_start == '' && $arrival_end != '' && $departure_start != '' && $departure_end == '') {

                    $type = 'Absent';
                    $difference = '';
                    $late = 0;
                    $undertime = 0;
                }
                # in: true , out: false , in: true, out: false
                elseif (!!$arrival_start && $arrival_end == '' && !!$departure_start && $departure_end == '') {
                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);

                    $difference = $arrival_start->diff($departure_start);

                    $undertime = $this->estimateUndertime($difference, 'halfday');

                    $type = 'UT';
                    // $type = 'UT';
                    // $max_time = $this->minDate($event);
                    // $late = $this->estimateLate($arrival_start, $max_time);

                    // $difference = $arrival_start->diff($departure_start);
                    // $time = sprintf('%02d:%02d', $difference->h - 1, $difference->i);

                    // $carbonTime = Carbon::createFromFormat('H:i', $time);
                    // // Create a Carbon instance for 8:00:00
                    // $eightHours = Carbon::createFromFormat('H:i', '08:00');
                    // // Check if the given time is greater than 8 hours
                    // if ($carbonTime > $eightHours) {
                    //     $undertime = 0;
                    //     $type = 'Full';
                    // } else {
                    //     $differenceTime = $eightHours->diff($carbonTime);
                    //     $type = 'L/UT';
                    //     $undertime = $differenceTime->h * 60 + $differenceTime->i;
                    // }
                }
                # in: true , out: true , in: false, out: false
                elseif (!!$arrival_start && !!$arrival_end && $departure_start == '' && $departure_end == '') {

                    $type = 'UT';
                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);

                    $difference = $arrival_start->diff($arrival_end);
                    $time = sprintf('%02d:%02d', $difference->h, $difference->i);

                    $carbonTime = Carbon::createFromFormat('H:i', $time);
                    // Create a Carbon instance for 8:00:00
                    $eightHours = Carbon::createFromFormat('H:i', '04:00');
                    // Check if the given time is greater than 4 hours
                    if ($carbonTime > $eightHours) {
                        $undertime = 0;
                        $type = 'Halfday';
                    } else {
                        $differenceTime = $eightHours->diff($carbonTime);
                        $type = 'L/UT';
                        $undertime = $differenceTime->h * 60 + $differenceTime->i;
                    }
                }
                # in: false , out: true , in: false, out: true
                elseif ($arrival_start == '' && !!$arrival_end && $departure_start == '' && !!$departure_end) {
                    $type = 'UT';
                    $difference = $arrival_end->diff($departure_end);
                    $undertime = $this->estimateUndertime($difference);
                    $late = 0;
                    $undertime = 240;
                }
                # in: true , out: true , in: false, out: true
                elseif (!!$arrival_start && !!$arrival_end && $departure_start == '' && !!$departure_end) {
                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);
                    $difference = $arrival_start->diff($departure_end);
                    $undertime = $this->estimateUndertime($difference);
                    $type = 'Full';
                }

                # in: true , out: false , in: true, out: true
                elseif (!!$arrival_start && $arrival_end == '' && !!$departure_start && !!$departure_end) {

                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);

                    $difference = $arrival_start->diff($departure_end);
                    $undertime = $this->estimateUndertime($difference);
                    $type = 'Full';
                }
                # in: true , out: true , in: true, out: false
                elseif (!!$arrival_start && !!$arrival_end && !!$departure_start && $departure_end == '') {
                    $max_time = $this->minDate($event);
                    $late = $this->estimateLate($arrival_start, $max_time);

                    $difference = $arrival_start->diff($departure_start);

                    $undertime = $this->estimateUndertime($difference, 'halfday');

                    $type = 'UT';
                }

                if ($date->isWeekend()) {

                    if ($date->dayOfWeek == 6) {
                        $arr[$key]['data'][$dayKey] = 'Saturday';
                    } elseif ($date->dayOfWeek == 0) {
                        $arr[$key]['data'][$dayKey] = 'Sunday';
                    }
                } elseif ($event && ($event->type == '2' || $event->type == '3' || $event->type == '4')) {

                    $arr[$key]['data'][$dayKey] = $event->title;
                } else {
                    if ($type != 'Absent') {
                        if ($type == 'travel') {
                            $arr[$key]['data'][$dayKey]['type'] = $type;
                            $arr[$key]['data'][$dayKey]['time'] = "8:00";
                            $arr[$key]['data'][$dayKey]['late'] = $late;
                            $arr[$key]['data'][$dayKey]['undertime'] = $undertime;
                            $arr[$key]['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                        } else {
                            if ($type == 'UT') {
                                $hour = $difference->h > 0 ? $difference->h : 0;
                            } else {
                                $hour = $difference->h > 0 ? $difference->h - 1 : 0;
                            }


                            $arr[$key]['data'][$dayKey]['type'] = $type;
                            $arr[$key]['data'][$dayKey]['time'] = "$hour:$difference->i";
                            $arr[$key]['data'][$dayKey]['late'] = $late;
                            $arr[$key]['data'][$dayKey]['undertime'] = $undertime;
                            $arr[$key]['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                             $arr[$key]['data'][$dayKey]['editable'] =  $editable;
                        }
                    } else {
                        $arr[$key]['data'][$dayKey]['type'] = $type;
                        $arr[$key]['data'][$dayKey]['time'] = "0:0";
                        $arr[$key]['data'][$dayKey]['late'] = $late;
                        $arr[$key]['data'][$dayKey]['undertime'] = $undertime;
                        $arr[$key]['data'][$dayKey]['fc'] = $event && $event->type == '1' ? true : false;
                        $arr[$key]['data'][$dayKey]['editable'] =  $editable;

                    }
                }
            }
        }
        $increment = 0;


        $this->dtrArr = $arr;
    }


    public function getColumnValue($column, $sheet, $currentDate, $first = false): string
    {

        $arr = '';
        if ($first) {
            if ($currentDate->isWeekend()) {
                if ($currentDate->dayOfWeek == 6) {
                    $arr = 'Saturday';
                } elseif ($currentDate->dayOfWeek == 0) {
                    $arr = 'Sunday';
                }
            } else {
                if (!!$sheet->getCell($column)->getValue()) {
                    try {
                        $type = gettype($sheet->getCell($column)->getValue());
                        if ($type == 'double') {
                            $hours = $sheet->getCell($column)->getValue() * 24;
                            $time = Carbon::createFromTime((int)$hours, round(($hours - (int)$hours) * 60));
                            $arr = $time->format('h:i A');
                        } else {
                            $date = Carbon::createFromFormat('h:i A', $sheet->getCell($column)->getValue());
                            $arr = $date->format('h:i A');
                        }
                    } catch (\Carbon\Exceptions\InvalidArgumentException $e) {

                        $type = gettype($sheet->getCell($column)->getValue());
                        if ($type == 'double') {
                            $hours = $sheet->getCell($column)->getValue() * 24;
                            $minutes = ($hours - (int)$hours) * 60;

                            $time = Carbon::createFromTime((int)$hours, round($minutes));
                            $arr = $time->format('h:i A');
                        }
                    }
                }
            }
        } else {
            if (!!$sheet->getCell($column)->getValue()) {

                try {
                    $type = gettype($sheet->getCell($column)->getValue());

                    if ($type == 'double') {

                        $hours = $sheet->getCell($column)->getValue() * 24;
                        $minutes = ($hours - (int)$hours) * 60;
                        $time = Carbon::createFromTime((int)$hours, round($minutes));
                        $arr = $time->format('h:i A');
                    } else {
                        //                        $date = Carbon::createFromFormat('h:i A', $sheet->getCell($column)->getValue());
                        //                        $arr = $date->format('h:i A');
                        $date = Carbon::parse($sheet->getCell($column)->getValue());
                        $arr = $date->format('h:i A');
                    }
                } catch (\Carbon\Exceptions\InvalidArgumentException $e) {

                    $type = gettype($sheet->getCell($column)->getValue());
                    if ($type == 'double') {
                        dd($type);
                        $hours = $sheet->getCell($column)->getValue() * 24;
                        $minutes = ($hours - (int)$hours) * 60;
                        $time = Carbon::createFromTime((int)$hours, round($minutes));
                        $arr = $time->format('h:i A');
                    } else if ($type == 'string') {

                        if (strpos($sheet->getCell($column)->getValue(), 'TRAVEL') !== false) {
                            $arr = $sheet->getCell($column)->getValue();
                        } else {
                            $arr = '';
                        }
                    }
                }
            } else {
                $arr = '';
            }
        }
        return $arr;
    }

    public function minDate($event): Carbon
    {
        return $event && $event->type == '1' ? Carbon::parse('07:45 AM') : Carbon::parse('09:00 AM');
    }

    public function estimateLate($start, $max_time)
    {
        $diff = $start->diff($max_time);
        $differenceInMinutes = $diff->h * 60 + $diff->i;

        if ($diff->invert) {
            $late = $differenceInMinutes;
        } else {
            $late = 0;
        }
        return $late;
    }

    public function estimateUndertime($difference, $type = 'full'): float|int
    {

        $undertime = 0;
        $time = $type == 'full' ? sprintf('%02d:%02d', $difference->h - 1, $difference->i) : sprintf('%02d:%02d', $difference->h, $difference->i);
        $carbonTime = Carbon::createFromFormat('H:i', $time);

        // Create a Carbon instance for 8:00:00
        $eightHours = Carbon::createFromFormat('H:i', '08:00');

        // Check if the given time is greater than 8 hours
        if ($carbonTime > $eightHours) {
            $undertime = 0;
        } else {
            $differenceTime = $eightHours->diff($carbonTime);

            $undertime = $differenceTime->h * 60 + $differenceTime->i;
        }
        return $undertime;
    }


    public function getAllDaysInMonth($year, $month)
    {
        // Create a Carbon instance for the first day of the month
        $startDate = Carbon::createFromDate($year, $month, 1);

        // Get the number of days in the month
        $daysInMonth = $startDate->daysInMonth;

        // Create an array to hold all the days
        $days = [];

        // Loop through each day of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = $startDate->copy()->day($day)->toDateString();
        }

        return $days;
    }
}
