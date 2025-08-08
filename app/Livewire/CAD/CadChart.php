<?php

namespace App\Livewire\CAD;

use App\Models\SkillHobbies;
use Carbon\Carbon;
use App\Models\UserInfo;
use App\Models\WorkExperience;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\DatePicker;

class CadChart extends ChartWidget
{

    protected static ?string $heading = 'GAD CHART';
    public $x;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $pollingInterval = null;
    public ?string $filter = 'Gender';
    protected function getData(): array
    {
        if ($this->filter == 'Gender') {
            $genderCounts = UserInfo::select('sex')
                ->get()
                ->groupBy('sex')
                ->map->count();
            $labels = ['Male', 'Female'];
            $data = [];
            foreach ($labels as $label) {
                if (isset($genderCounts[$label])) {
                    $data[] =  $genderCounts[$label];
                } else {
                    $data[] = 0;
                }
            }
        } elseif ($this->filter == 'Civil Status') {
            $civil_status = UserInfo::with('child')->select('civil_status','id_number')
                ->get()
                ->groupBy('civil_status');

            $labels = ['Single', 'Widowed', 'Married', 'Seperated', 'Solo Parent'];
            $data = [0, 0, 0, 0, 0];
            foreach ($civil_status as $key => $value) {
                if ($key == 'Widowed') {
                    $data[1] = $value->count();
                }
                if ($key == 'Seperated') {
                    $data[3] = $value->count();
                }

                if ($key == 'Married') {
                    $data[2] = $value->count();
                }
                if ($key == 'Single') {

                    foreach($value as $single)
                    {
                        isset($single->child) ? $data[4] = $data[4] + 1 : $data[0] = $data[0] + 1;
                    }
                    // $value->map(function ($item) use ($data) {

                    //     $c = isset($item->child) ? $data[4] = $data[4] + 1 : $data[0] = $data[0] + 1;
                    //     return;
                    // });

                }
            }



            // $civil_status = UserInfo::select('civil_status')
            // ->get()
            // ->groupBy('civil_status')
            // ->map->count();


            // $data = [];
            // foreach ($labels as $label) {
            //     if (isset($civil_status[$label])) {
            //         $data[] =  $civil_status[$label];
            //     }else{
            //         $data[] = 0;
            //     }

            // }
        } elseif ($this->filter == 'Status Appointment') {
            $status_appointment = WorkExperience::select('status_appointment')
                ->get()
                ->groupBy('status_appointment')
                ->map->count();

            $labels = ['Permanent', 'Contractual', 'Job Order'];
            $data = [];
            foreach ($labels as $label) {
                if (isset($status_appointment[$label])) {
                    $data[] =  $status_appointment[$label];
                } else {
                    $data[] = 0;
                }
            }
        } elseif ($this->filter == 'Age') {
            $status_appointment = UserInfo::select('birth_date')->get();

          
            $allBirthData = $status_appointment->map(function ($date) {
               
               if(!!$date->birth_date)
               {
                return Carbon::parse(Crypt::decryptString($date->birth_date))->diffInYears(Carbon::now());
               }
            });

            $labels = ['20 to 25 years old', '25 to 30 years old', '30 to 35 years old', '40 to 45 years old', '50 to 55 years old', '60 to 65 years old', '70 to 75 years old'];
            $data = [];
            foreach ($labels as $label) {
                $range = explode(' to ', $label);
                $count = $allBirthData->filter(function ($age) use ($range) {
                    return $age > $range[0] && $age <= $range[1];
                })->count();
                $data[] = $count;
            }
        }elseif ($this->filter == 'Salary Grade') {
            $salary_grade = WorkExperience::select('salary_grade')
                ->get()
                ->groupBy('salary_grade')
                ->map->count();

            $labels = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25];
            $data = [];
            foreach ($labels as $label) {
                if (isset($salary_grade[$label])) {
                    $data[] =  $salary_grade[$label];
                } else {
                    $data[] = 0;
                }
            }
        } elseif ($this->filter == 'Skills & Hobbies') {
            $SkillHobbies = SkillHobbies::select('type')
                ->get()
                ->groupBy('type')
                ->map->count();

            $labels = ['Computer skills', 'Communication', 'Customer service','Leadership','Problem-solving','Interpersonal skills','Others'];
            $data = [];
            foreach ($labels as $label) {
                if (isset($SkillHobbies[$label])) {
                    $data[] =  $SkillHobbies[$label];
                } else {
                    $data[] = 0;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => $this->filter,
                    'data' => $data,
                    'borderColor' => '#0001',
                    'backgroundColor' => ["#4ade80", "#facc15", "#38bdf8", "#e879f9", '#f87171'],
                ],
            ],
            'labels' => $labels,
        ];
    }
    protected function getFilters(): ?array
    {
        return [
            'Gender' => 'Gender',
            'Civil Status' => 'Civil Status',
            'Status Appointment' => 'Status Appointment',
            'Age' => 'Age',
            'Salary Grade' => 'Salary Grade',
            'Skills & Hobbies' => 'Skills & Hobbies',
        ];
    }
    protected static ?array $options = [
        'indexAxis' => 'x',
        'plugins' => [
            'colors' => [
                'enabled' => true
            ],
            'legend' => [
                'display' => false,
            ],
        ],
    ];
    protected function getType(): string
    {
        return 'bar';
    }
}
