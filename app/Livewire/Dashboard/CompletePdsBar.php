<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CompletePdsBar extends ChartWidget
{
    protected static ?string $heading = null;
    protected static ?string $pollingInterval = null;


    protected function getData(): array
    {

        $usersPerGroup = User::query()
        ->join('tbl_fd', 'users.fd_code', '=', 'tbl_fd.division_code')
        ->groupBy('users.fd_code', 'users.name', 'tbl_fd.division_name')
        ->select('users.fd_code', 'users.name', 'tbl_fd.division_name', DB::raw('count(*) as count'))
         ->whereHas('userInfo')
        // ->whereHas('skillHobbies')
        // ->whereHas('distinction')
        // ->whereHas('association')
        // ->whereHas('learningAndDevelopment')
        // ->whereHas('voluntaryAndInvolvement')
        ->whereHas('workExperiencefirst')
        // ->whereHas('civilServiceEligibility')
        ->whereHas('familyBackground')
        ->whereHas('educationalBackground')
        // ->whereHas('otherInfo')
        ->get();



        $labels = [];
        $values = [];
        $users = [];
        foreach ($usersPerGroup as $user) {
            $label = $user->division_name;
            $index = array_search($label, $labels);
            if ($index !== false) {
                $values[$index] += $user->count;
            } else {
                $labels[] = $label;
                $values[] = $user->count;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => $values,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $labels,
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
