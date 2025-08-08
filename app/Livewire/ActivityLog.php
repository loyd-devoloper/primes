<?php

namespace App\Livewire;


use Carbon\Carbon;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Builder;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Indicator;

class ActivityLog extends Component
{
    use WithPagination;
    // use InteractsWithTable;
    // use InteractsWithForms;
    #[Url(as: 'q')]
    public $search = 'all';
    #[Url]
    public $date = '';

    public $mainDate = '';


    #[Title('Activity Logs')]

    public function render()
    {


         if(!!$this->date)
         {
                $activities = \App\Models\ActivityLog::where('id_number', Auth::user()->id_number)->whereDate('created_at',Carbon::parse($this->date))->orderBy('id', 'desc')->get();
         }else{
            $activities = \App\Models\ActivityLog::where('id_number', Auth::user()->id_number)->orderBy('id', 'desc')->get();
         }



        return view('livewire.activity-log',compact('activities'));
    }
}
