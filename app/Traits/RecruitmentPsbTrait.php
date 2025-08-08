<?php

namespace App\Traits;

use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Jenssegers\Agent\Facades\Agent;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Request;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;

trait RecruitmentPsbTrait
{


    // formula
    public function computationEducation($type, $totalValue,$category = 'default')
    {

        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            if ($totalValue == 1) {
                return 1;
            } elseif ($totalValue == 2) {
                return 2;
            } elseif ($totalValue == 3) {
                return 3;
            } elseif ($totalValue == 4) {
                return 4;
            } elseif ($totalValue >= 5) {
                return 5;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            if ($totalValue > 0 && $totalValue <= 3) {
                return 1;
            } elseif ($totalValue > 0 && $totalValue <= 5) {
                return 2;
            } elseif ($totalValue > 0 && $totalValue <= 7) {
                return 3;
            } elseif ($totalValue > 0 && $totalValue <= 9) {
                return 4;
            } elseif ($totalValue > 0 && $totalValue >= 10) {
                return 5;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {
            if ( $totalValue > 1 && $totalValue <= 3) {
                return 1;
            } elseif ($totalValue > 1 && $totalValue <= 5) {
                return 2;
            } elseif ($totalValue > 1 && $totalValue <= 7) {
                return 3;
            } elseif ($totalValue > 1 && $totalValue <= 9) {
                return 4;
            } elseif ($totalValue > 1 && $totalValue >= 10) {
                return 5;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            if ($totalValue > 3 && $totalValue <= 5) {
                return 2;
            } elseif ($totalValue > 3 && $totalValue <= 7) {
                return 4;
            } elseif ($totalValue > 3 && $totalValue == 8) {
                return 6;
            } elseif ($totalValue > 3 && $totalValue == 9) {
                return 8;
            } elseif ($totalValue > 3 && $totalValue >= 10) {
                return 10;
            }else{
                return 0;
            }
        }


        if($type == 'Related-Teaching Positions')
        {
            if ($totalValue >= 2 && $totalValue <= 3) {
                return 2;
            } elseif ($totalValue >= 4 && $totalValue <= 5) {
                return 4;
            } elseif ($totalValue >= 6 && $totalValue <= 7) {
                return 6;
            } elseif ($totalValue >= 8 && $totalValue <= 9) {
                return 8;
            } elseif ($totalValue >= 10) {
                return 10;
            }else{
                return 0;
            }
        }
    }

    public function computationTraining($type, $totalValue, $category = 'default')
    {
        if($type == 'Related-Teaching Positions' )
        {
            if ($totalValue >= 2 && $totalValue <= 3) {
                return 2;
            } elseif ($totalValue >= 4 && $totalValue <= 5) {
                return 4;
            } elseif ($totalValue >= 6 && $totalValue <= 7) {
                return 6;
            } elseif ($totalValue >= 8 && $totalValue <= 9) {
                return 8;
            } elseif ($totalValue >= 10) {
                return 10;
            }else{
                return 0;
            }
        }



        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            if ($totalValue == 1) {
                return 1;
            } elseif ($totalValue == 2) {
                return 2;
            } elseif ($totalValue == 3) {
                return 3;
            } elseif ($totalValue == 4) {
                return 4;
            } elseif ($totalValue >= 5) {
                return 5;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            if ($totalValue == 1) {
                return 1;
            } elseif ($totalValue == 2) {
                return 2;
            } elseif ($totalValue == 3) {
                return 3;
            } elseif ($totalValue == 4) {
                return 4;
            } elseif ($totalValue >= 5) {
                return 5;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {
            if ($totalValue == 1) {
                return 2;
            } elseif ($totalValue == 2) {
                return 4;
            } elseif ($totalValue == 3) {
                return 6;
            } elseif ($totalValue == 4) {
                return 8;
            } elseif ($totalValue >= 5) {
                return 10;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            if ($totalValue == 1) {
                return 1;
            } elseif ($totalValue == 2) {
                return 2;
            } elseif ($totalValue == 3) {
                return 3;
            } elseif ($totalValue == 4) {
                return 4;
            } elseif ($totalValue >= 5) {
                return 5;
            }else{
                return 0;
            }
        }
    }

    public function computationExperience($type, $totalValue,$category = 'default')
    {

        if($type == 'Related-Teaching Positions' )
        {
            if ($totalValue >= 2 && $totalValue <= 3) {
                return 2;
            } elseif ($totalValue >= 4 && $totalValue <= 5) {
                return 4;
            } elseif ($totalValue >= 6 && $totalValue <= 7) {
                return 6;
            } elseif ($totalValue >= 8 && $totalValue <= 9) {
                return 8;
            } elseif ($totalValue >= 10) {
                return 10;
            }else{
                return 0;
            }
        }


        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            if ($totalValue >= 2 && $totalValue <= 3) {
                return 4;
            } elseif ($totalValue >= 4 && $totalValue <= 5) {
                return 8;
            } elseif ($totalValue >= 6 && $totalValue <= 7) {
                return 12;
            } elseif ($totalValue >= 8 && $totalValue <= 9) {
                return 16;
            } elseif ($totalValue >= 10) {
                return 20;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            if ($totalValue >= 2 && $totalValue <= 3) {
                return 4;
            } elseif ($totalValue >= 4 && $totalValue <= 5) {
                return 8;
            } elseif ($totalValue >= 6 && $totalValue <= 7) {
                return 12;
            } elseif ($totalValue >= 8 && $totalValue <= 9) {
                return 16;
            } elseif ($totalValue >= 10) {
                return 20;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {

            if ((int)$totalValue >= 2 && (int)$totalValue <= 3) {
                return 3;
            } elseif ((int)$totalValue >= 4 && (int)$totalValue <= 5) {
                return 6;
            } elseif ((int)$totalValue >= 6 && (int)$totalValue <= 7) {
                return 9;
            } elseif ((int)$totalValue >= 8 && (int)$totalValue <= 9) {
                return 12;
            } elseif ((int)$totalValue >= 10) {
                return 15;
            }else{
                return 0;
            }
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            if ($totalValue >= 2 && $totalValue <= 3) {
                return 3;
            } elseif ($totalValue >= 4 && $totalValue <= 5) {
                return 6;
            } elseif ($totalValue >= 6 && $totalValue <= 7) {
                return 9;
            } elseif ($totalValue >= 8 && $totalValue <= 9) {
                return 12;
            } elseif ($totalValue >= 10) {
                return 15;
            }else{
                return 0;
            }
        }
    }


    // weight allocation

    public function educationWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return 5;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            return 5;
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {
            return 5;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 10;
        }

        if($type == 'Related-Teaching Positions' && $category == 'SG 11-15')
        {
            return 10;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG 16-23 and SG-27')
        {
            return 10;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 10;
        }
    }

    public function trainingWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return 5;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            return 5;
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {
            return 10;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 5;
        }

        if($type == 'Related-Teaching Positions' && $category == 'SG 11-15')
        {
            return 10;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG 16-23 and SG-27')
        {
            return 10;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 10;
        }
    }


    public function experienceWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return 20;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            return 20;
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {
            return 15;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 15;
        }

        if($type == 'Related-Teaching Positions' && $category == 'SG 11-15')
        {
            return 10;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG 16-23 and SG-27')
        {
            return 10;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 10;
        }
    }

    public function performanceWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return 10;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            return 20;
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {
            return 20;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 20;
        }

        if($type == 'Related-Teaching Positions' && $category == 'SG 11-15')
        {
            return 20;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG 16-23 and SG-27')
        {
            return 20;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 25;
        }
    }

    public function outstandingAccomplishmentWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return 5;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 1-9 (None-General Services)')
        {
            return 10;
        }elseif($type == 'Non-Teaching Positions' && $category == 'SG 10-22 and SG 27')
        {
            return 10;

        }elseif($type == 'Non-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 10;
        }

        if($type == 'Related-Teaching Positions' && $category == 'SG 11-15')
        {
            return 10;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG 16-23 and SG-27')
        {
            return 5;
        }elseif($type == 'Related-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 10;
        }
    }

    public function applicationOfEducationWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return '';

        }elseif($type == 'Related-Teaching Positions' && $category == 'SG 16-23 and SG-27')
        {
            return 15;
        }else
        {
            return 10;
        }
    }

    public function learningAndDevelopmentWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return '';

        }else{
            return 10;
        }
    }

    public function potentialWeightAllocation($type,$category)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return 55;

        }elseif($type == 'Related-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            return 15;
        }else{
            return 20;
        }
    }

    public function partialPotentialWeightAllocation($type,$category,$name)
    {
        if ($type == 'Non-Teaching Positions' && $category == 'General Services') {
            return '';


        }elseif($type == 'Related-Teaching Positions' && $category == 'SG-24(Chief)')
        {
            if($name == "we") return 5;
            if($name == "wst") return 5;
            if($name == "bei") return 5;
        }else{
            if($name == "we") return 5;
            if($name == "wst") return 10;
            if($name == "bei") return 5;
        }
    }
}
