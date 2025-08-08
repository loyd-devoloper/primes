<?php

namespace App\Livewire\Leave\Personnel;

use Carbon\Carbon;
use Livewire\Component;
use App\Mail\Recruitment\Car;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LeaveCard extends Component implements HasActions,HasForms
{
    use InteractsWithForms;
    use InteractsWithActions;
    public $employeeid,$name,$leaveData,$base64Image = '';


    public function mount()
    {

        $this->leaveData = \App\Models\Leave\LeaveCard::query()
                                    ->where('id_number',$this->employeeid)
                                    ->orderBy('start_date','asc')
                                    ->get();
    }
     // Leave Card
     public function slideOverLeaveCardAction()
     {
         return \Filament\Actions\Action::make('slideOverLeaveCard')
             ->label('Download Leave Card')
             ->icon('heroicon-m-arrow-down-on-square')
             ->color(Color::Red)
             ->size('sm')
             ->requiresConfirmation()
             ->action(function ($data) {
                $name = Auth::user()->name;
                \App\Models\Leave\LeaveEmployeeActivityLog::create([
                    'activity' => "$name Download Leave Card",
                    'remarks' =>  "",
                    'location' => Auth::user()->user_fd_code?->division_name,
                    'employee_leave_id' => $this->employeeid,
                    'id_number' => Auth::user()->id_number,
                ]);

                 $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.leave.asset.leave_card',['leaveData'=>$this->leaveData,'name'=>$this->name])->setPaper('a4', 'landscape');
                 return response()->streamDownload(function () use ($pdf) {
                                 echo $pdf->stream();
                             },  "$this->name.pdf");
             });
     }
    public function render()
    {


        return view('livewire.leave.personnel.leave-card');
    }
}
