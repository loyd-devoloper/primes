<?php

namespace App\Http\Controllers;



//use Elibyy\TCPDF\Facades\TCPDF;
use PDF;
use Illuminate\Http\Request;
use App\Livewire\ID\Template;
use Intervention\Image\Image;
//use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\ID_Template;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;

class DemoController extends Controller
{
    public function dtrDemo()
    {
        $data = '{"EXAMPLE":{"1-1":{"fc":false,"late":0,"time":"4:11","type":"L\/UT","undertime":229,"date_arrival_am":"07:21 AM","date_arrival_pm":"","date_departure_am":"12:32 PM","date_departure_pm":""},"1-2":{"fc":false,"late":0,"time":"8:52","type":"Full","undertime":0,"date_arrival_am":"08:52 AM","date_arrival_pm":"01:02 PM","date_departure_am":"12:59 PM","date_departure_pm":"06:44 PM"},"1-3":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-4":{"fc":false,"late":0,"time":"4:11","type":"L\/UT","undertime":229,"date_arrival_am":"07:21 AM","date_arrival_pm":"","date_departure_am":"12:32 PM","date_departure_pm":""},"1-5":"Saturday","1-6":"Sunday","1-7":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-8":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-9":{"fc":false,"late":0,"time":"9:56","type":"Full","undertime":0,"date_arrival_am":"08:27 AM","date_arrival_pm":"12:10 PM","date_departure_am":"11:57 AM","date_departure_pm":"07:23 PM"},"1-10":{"fc":false,"late":0,"time":"8:2","type":"Full","undertime":0,"date_arrival_am":"08:38 AM","date_arrival_pm":"01:06 PM","date_departure_am":"12:02 PM","date_departure_pm":"05:40 PM"},"1-11":"Independence Day","1-12":"Saturday","1-13":"Sunday","1-14":{"fc":true,"late":0,"time":"7:59","type":"Full","undertime":1,"date_arrival_am":"07:39 AM","date_arrival_pm":"12:30 PM","date_departure_am":"12:27 PM","date_departure_pm":"04:38 PM"},"1-15":{"fc":false,"late":0,"time":"8:0","type":"Full","undertime":0,"date_arrival_am":"08:47 AM","date_arrival_pm":"01:18 PM","date_departure_am":"01:16 PM","date_departure_pm":"05:47 PM"},"1-16":"BAGYONG SUPER ?","1-17":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-18":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-19":"Saturday","1-20":"Sunday","1-21":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-22":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-23":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-24":"Holiday Unlimited","1-25":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-26":"Saturday","1-27":"Sunday","1-28":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-29":{"fc":false,"late":11,"time":"8:20","type":"Full","undertime":0,"date_arrival_am":"09:11 AM","date_arrival_pm":"12:23 PM","date_departure_am":"12:20 PM","date_departure_pm":"06:31 PM"},"1-30":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""},"1-31":{"fc":false,"late":0,"time":"0:0","type":"Absent","undertime":0,"date_arrival_am":"","date_arrival_pm":"","date_departure_am":"","date_departure_pm":""}}}';

        return view('welcome',['title'=>'Demo','arr'=>json_decode($data)]);
//        $filename = 'hello_world.pdf';
//
//
//
//        $view = \View::make('welcome', ['arr'=>json_decode($data)]);
//        $html = $view->render();
//
//        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
//
//        $pdf::SetTitle('Hello World');
//        $pdf::AddPage();
//        $pdf::writeHTML($html, true, false, true, false, '');
//
//        $pdf::Output(public_path($filename), 'F');
//
//        return response()->download(public_path($filename));
                $view = \View::make('welcome', ['arr'=>json_decode($data)]);
        $html = $view->render();

        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::writeHTML($html, false, false, false, false, '');


        PDF::Output('hello_world.pdf');

//        $templatePath = public_path('/excel/DTR.xlsx');
//        $reader = new Xlsx();
//
//
//        $spreadsheet = $reader->load($templatePath);
//        $sheet = $spreadsheet->getSheet(0);
//        $writer = IOFactory::createWriter($spreadsheet,'Tcpdf');
////        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//        $fileName = 'demo.pdf';
//        $writer->save(storage_path('app/public/' . $fileName));
//
//        return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
    }
    public function w(){
        $activeTemplateData = ID_Template::with('attributes')->select('front', 'back','attribute','id')->where('status', 1)->first();

              $pdf = PDF::loadView('id', ['activeTemplateData' => $activeTemplateData] );



        $pdf->setPaper([0,0,153.36,242.64],'portrait');

        return $pdf->download('example.pdf');



        return view('id',['activeTemplateData' => $activeTemplateData]);
    }
    public function store(Request $request)
    {
        $base64Image = $request->image;

        // Remove the "data:image/png;base64," part of the string
        $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);

        // Decode the base64 image data
        $imageDecode = base64_decode($base64Image);
        $filename = 'dsada.png';



        $manager = new ImageManager(new Driver());


        $image = $manager->read($imageDecode);


        // resize image proportionally to 300px width
        $image->scale(width: 1125, height:1650);


        // insert watermark
        // $image->place('images/watermark.png');

        // save modified image in new format
        $image->toPng()->save(storage_path('app/public/images/example.jpeg'));


        return back();
        // Return the filename or some other response
        // return response()->json(['filename' => $filename]);
    }
}
