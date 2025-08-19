<?php

namespace App\Traits\Leave;

use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

trait PersonnelLeaveTrait
{

    public function loadDtrCondition($start, $end, $event, $departure_start, $arrival_end, $fc)
    {
        // Get day-specific time thresholds
        $max_arrival = $this->minDate($event);
        $max_departure_old = $event?->type == '5' ? Carbon::parse($event?->max_departure) : $this->getExpectedDepartureTime($fc);

        $min_arrival = Carbon::parse('07:00 AM');
        $min_departure = Carbon::parse('04:00 PM');
        // Calculate late minutes if arrived after max arrival time
        $late = $this->estimateLate($start, $max_arrival);
        // Adjust arrival if before minimum
        if ($start < $min_arrival) {
            $start = $min_arrival;
            $max_departure_of_employee = Carbon::parse($start)->addHours(9);

            // Calculate total time spent (arrival to departure)
            $max_departure = $max_departure_of_employee < $max_departure_old ? $max_departure_of_employee : $max_departure_old;
        } else {
            $max_departure_of_employee = Carbon::parse($start)->addHours(9);

            // Calculate total time spent (arrival to departure)
            $max_departure =  $max_departure_old;
        }


        $difference = $start->diff($end);
        $actualWorkingMinutes = $difference->h * 60 + $difference->i;

        // NEW: Check if worked less than 4 hours (no lunch deduction)
        if ($actualWorkingMinutes < 240) { // 4 hours = 240 minutes
            // Calculate pure working time without lunch deduction
            $morningSession = $start->diffInMinutes($departure_start);
            $afternoonSession = $arrival_end->diffInMinutes($end);
            $actualWorkingMinutes = $morningSession + $afternoonSession;

            // Special status for short work durations

            $type = 'Halfday';
            $undertime = $max_departure->diffInMinutes($end);

            $editable = true;
        } else { // Normal case (4+ hours)
            // Calculate undertime (with lunch deduction)
            // $undertime = $this->estimateUndertimeNew($difference, 'full', $date);
            //  dd($arrival_start,$max_departure,$max_departure->diffInMinutes($end));
            $undertime = $max_departure->diffInMinutes($end);
            if ($max_departure_of_employee > $max_departure) {
                $undertime = $max_departure->diffInMinutes($end);
            }
            if ($max_departure_of_employee < $max_departure) {
                $undertime = $max_departure_of_employee->diffInMinutes($end);
            }
            if ($end > $max_departure || $end > $max_departure_of_employee) {
                $undertime  = 0;
            }
            // dd($max_departure_of_employee > $max_departure,$max_departure_of_employee, $max_departure);


            // Expected working minutes (7 hours = 420 minutes excluding lunch)
            $expectedWorkingMinutes = 7 * 60;

            // Determine status type
            if ($actualWorkingMinutes >= ($expectedWorkingMinutes - 15)) {
                if ($late > 0 && $undertime > 0) {
                    $type = 'L/UT';
                } elseif ($late > 0) {
                    $type = 'Late';
                } elseif ($undertime > 15) {
                    $type = 'UT';
                } else {
                    $type = 'Full';
                    // $undertime = 0;
                    $editable = false;
                }
            } else {
                $type = 'L/UT';
            }
            $editable = $type !== 'Full';
        }
        return [
            $editable,
            $type,
            $undertime,
            $late,
            $difference
        ];
    }
    public function loadDtrNew(): void
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
                    'date_arrival_am' => [
                        'time' => $arrival_am["$x-$columnValue"],
                        'editable' => $arrival_am["$x-$columnValue"] ? false : true
                    ],
                    'date_departure_am' => [
                        'time' => $departure_am["$x-$columnValue"],
                        'editable' => $departure_am["$x-$columnValue"] ? false : true
                    ],
                    'date_arrival_pm' => [
                        'time' => $arrival_pm["$x-$columnValue"],
                        "editable" => $arrival_pm["$x-$columnValue"] ? false : true
                    ],
                    'date_departure_pm' => [
                        'time' => $departure_pm["$x-$columnValue"],
                        'editable' => $departure_pm["$x-$columnValue"] ? false : true
                    ],
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
                $fc = false;
                $date = Carbon::parse($this->month)->addDays((int)explode('-', $dayKey)[1] - 1);

                $arrival_start = '';
                $arrival_end = '';
                $departure_start = '';
                $departure_end = '';
                $editable = true;

                if (!!$day['date_arrival_am']['time']) {
                    $arrival_start = str_contains($day['date_arrival_am']['time'], 'TRAVEL') ? $day['date_arrival_am']['time'] : Carbon::parse($day['date_arrival_am']['time']);
                }

                if (!!$day['date_departure_am']['time']) {
                    $departure_start = str_contains($day['date_departure_am']['time'], 'TRAVEL') ? $day['date_departure_am']['time'] : Carbon::parse($day['date_departure_am']['time']);
                }

                if (!!$day['date_arrival_pm']['time']) {
                    $arrival_end = str_contains($day['date_arrival_pm']['time'], 'TRAVEL') ? $day['date_arrival_pm']['time'] : Carbon::parse($day['date_arrival_pm']['time']);
                }
                if (!!$day['date_departure_pm']['time']) {
                    $departure_end = str_contains($day['date_departure_pm']['time'], 'TRAVEL') ? $day['date_departure_pm']['time'] : Carbon::parse($day['date_departure_pm']['time']);
                }

                // check event
                $event = \App\Models\Leave\LeaveCalendar::query()->whereDate('start', $date)->first();
                $fc = $event?->type == '1' ? true : false;
                if (str_contains($day['date_arrival_am']['time'], 'TRAVEL')) {
                    $type = 'travel';
                    $editable = false;
                }
                if (true) {
                    // if ($arrival_start == '' && $arrival_end == '' && $departure_start == '' && $departure_end == '') {

                    $type = 'Absent';
                    $difference = '';
                    $late = 0;
                    $undertime = 0;
                }

                if (!!$arrival_start && !!$departure_start && !!$arrival_end &&  !!$departure_end) {

                    [$editable, $type, $undertime, $late, $difference] = $this->loadDtrCondition($arrival_start, $departure_end, $event, $departure_start, $arrival_end, $fc);


                    // Get day-specific time thresholds
                    // $max_arrival = $this->minDateNew($event);
                    // $max_departure_old = $event?->type == '5' ? Carbon::parse($event?->max_departure) : $this->getExpectedDepartureTime($fc);

                    // $min_arrival = Carbon::parse('07:00 AM');
                    // $min_departure = Carbon::parse('04:00 PM');
                    // // Calculate late minutes if arrived after max arrival time
                    // $late = $this->estimateLate($arrival_start, $max_arrival);
                    // // Adjust arrival if before minimum
                    // if ($arrival_start < $min_arrival) {
                    //     $arrival_start = $min_arrival;
                    //     $max_departure_of_employee = Carbon::parse($arrival_start)->addHours(9);

                    //     // Calculate total time spent (arrival to departure)
                    //     $max_departure = $max_departure_of_employee < $max_departure_old ? $max_departure_of_employee : $max_departure_old;
                    // } else {
                    //     $max_departure_of_employee = Carbon::parse($arrival_start)->addHours(9);

                    //     // Calculate total time spent (arrival to departure)
                    //     $max_departure =  $max_departure_old;
                    // }


                    // $difference = $arrival_start->diff($departure_end);
                    // $actualWorkingMinutes = $difference->h * 60 + $difference->i;

                    // // NEW: Check if worked less than 4 hours (no lunch deduction)
                    // if ($actualWorkingMinutes < 240) { // 4 hours = 240 minutes
                    //     // Calculate pure working time without lunch deduction
                    //     $morningSession = $arrival_start->diffInMinutes($departure_start);
                    //     $afternoonSession = $arrival_end->diffInMinutes($departure_end);
                    //     $actualWorkingMinutes = $morningSession + $afternoonSession;

                    //     // Special status for short work durations

                    //     $type = 'Halfday';
                    //     $undertime = $max_departure->diffInMinutes($departure_end);

                    //     $editable = true;
                    // } else { // Normal case (4+ hours)
                    //     // Calculate undertime (with lunch deduction)
                    //     // $undertime = $this->estimateUndertimeNew($difference, 'full', $date);
                    //     //  dd($arrival_start,$max_departure,$max_departure->diffInMinutes($departure_end));
                    //     $undertime = $max_departure->diffInMinutes($departure_end);
                    //     if ($max_departure_of_employee > $max_departure) {
                    //         $undertime = $max_departure->diffInMinutes($departure_end);
                    //     }
                    //     if ($max_departure_of_employee < $max_departure) {
                    //         $undertime = $max_departure_of_employee->diffInMinutes($departure_end);
                    //     }
                    //     if ($departure_end > $max_departure || $departure_end > $max_departure_of_employee) {
                    //         $undertime  = 0;
                    //     }
                    //     // dd($max_departure_of_employee > $max_departure,$max_departure_of_employee, $max_departure);


                    //     // Expected working minutes (7 hours = 420 minutes excluding lunch)
                    //     $expectedWorkingMinutes = 7 * 60;

                    //     // Determine status type
                    //     if ($actualWorkingMinutes >= ($expectedWorkingMinutes - 15)) {
                    //         if ($late > 0 && $undertime > 0) {
                    //             $type = 'L/UT';
                    //         } elseif ($late > 0) {
                    //             $type = 'Late';
                    //         } elseif ($undertime > 15) {
                    //             $type = 'UT';
                    //         } else {
                    //             $type = 'Full';
                    //             // $undertime = 0;
                    //             $editable = false;
                    //         }
                    //     } else {
                    //         $type = 'L/UT';
                    //     }
                    //     $editable = $type !== 'Full';
                    // }
                }
                if (!!$arrival_start && !!$departure_start && !!$arrival_end &&  $departure_end == '') {

                    [$editable, $type, $undertime, $late, $difference] =  $this->loadDtrCondition($arrival_start, $arrival_end, $event, $departure_start, $arrival_end, $fc);
                }

                if (!!$arrival_start && !!$departure_start && $arrival_end == '' &&  $departure_end == '') {

                    [$editable, $type, $undertime, $late, $difference] =  $this->loadDtrCondition($arrival_start, $departure_start, $event, $departure_start, $departure_start, $fc);
                }

                if (!!$arrival_start && !!$departure_start && $arrival_end == '' &&  !!$departure_end) {

                    [$editable, $type, $undertime, $late, $difference] =  $this->loadDtrCondition($arrival_start, $departure_end, $event, $departure_start, $departure_start, $fc);
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


    private function getExpectedWorkingHours($date): int
    {
        // if ($date->dayOfWeek == Carbon::MONDAY) {
        //     return 8 * 60; // 8 hours in minutes (7:45 AM to 4:45 PM with 1 hour lunch)
        // }

        return 8 * 60; // 8 hours in minutes (9:00 AM to 6:00 PM with 1 hour lunch)
    }
    public function estimateUndertimeNew($difference, $type = 'full', $date = null): float|int
    {
        $undertime = 0;

        if ($type == 'full' && $date) {
            // For full day, calculate based on expected working hours for the day
            $expectedDeparture = $this->getExpectedDepartureTime($date);
            $expectedWorkingHours = $this->getExpectedWorkingHours($date);

            // Calculate actual working time (arrival to departure)
            $actualWorkingMinutes = $difference->h * 60 + $difference->i;

            // Calculate undertime
            $undertime = max(0, $expectedWorkingHours - $actualWorkingMinutes);
        } else {
            // For half days or when date isn't provided, use the existing logic
            $time = $type == 'full'
                ? sprintf('%02d:%02d', $difference->h - 1, $difference->i)
                : sprintf('%02d:%02d', $difference->h, $difference->i);

            $carbonTime = Carbon::createFromFormat('H:i', $time);
            $eightHours = Carbon::createFromFormat('H:i', '08:00');

            if ($carbonTime <= $eightHours) {
                $differenceTime = $eightHours->diff($carbonTime);
                $undertime = $differenceTime->h * 60 + $differenceTime->i;
            }
        }

        return $undertime;
    }


    public function getExpectedDepartureTime($fc = false): Carbon
    {
        if ($fc) {
            return Carbon::parse('04:45 PM'); // Monday
        }

        return Carbon::parse('06:00 PM'); // Tuesday-Friday
    }
    ############################################ OLD CODE ###############################



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
