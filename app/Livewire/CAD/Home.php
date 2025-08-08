<?php

namespace App\Livewire\CAD;

use Livewire\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Livewire\Attributes\Title;

class Home extends Component
{
    use ExposesTableToWidgets;

    public $x = 7889 ;
    public function generateCad()
    {
        $this->x = rand(0,9999);

    }
    #[Title('GAD')]
    public function render()
    {
        return view('livewire.c-a-d.home');
    }
}
