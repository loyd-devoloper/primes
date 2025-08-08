<?php

namespace App\Livewire\Leave\Asset;

use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VerifyDtr extends Component
{
    public $data = [];
    public $qrcode = "";
    public $date = "";
    public function mount($dtr_id)
    {
        $query = $dtr_id;
        $check = \App\Models\Leave\LeaveBulkDtr::query()->where("dtr->$query",'!=',null)->first();
        $arr = $check ? json_decode($check->dtr,true) : null;
        if (!!$arr)
        {
            $route = route('dtr_qrcode',['dtr_id'=>$query]);

            $image = QrCode::generate($route);

            $base64Image = 'data:image/svg+xml;base64,' . base64_encode($image);
            $this->qrcode = $base64Image;
            $this->date = $check->date;
            $this->data = [$query=>$arr[$query]];

        }else{
            abort(404);
        }
    }
    public function render()
    {
        return view('livewire.leave.asset.verify-dtr');
    }
}
