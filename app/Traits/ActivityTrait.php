<?php
namespace App\Traits;

use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;

trait ActivityTrait{

    public function storeActivityLog($activity )
    {

        // $isDesktop = Agent::isDesktop();
        // $isTablet = Agent::isTablet();
        // $isPhone = Agent::isPhone();
        // if($isDesktop)
        // {
        //     $type = 'Desktop';
        // }elseif($isTablet)
        // {
        //     $type = 'Tablet';
        // }elseif($isPhone)
        // {
        //     $type = 'Mobile';
        // }

        $agent = new Agent();

        // Initialize variables
        $deviceType = 'Unknown';
        $operatingSystem = 'Unknown';

        // Check if the device is an iPhone
        if ($agent->isMobile() && $agent->is('iPhone')) {
            $deviceType = 'iPhone';
            $operatingSystem = 'iOS';
        }
        // Check if the device is Android
        elseif ($agent->isMobile() && $agent->is('Android')) {
            $deviceType = 'Android';
            $operatingSystem = 'Android OS';
        }
        // Check if the device is Windows
        elseif ($agent->isDesktop() && $agent->is('Windows')) {
            $deviceType = 'Desktop';
            $operatingSystem = 'Windows';
        }
        // Check if the device is Linux
        elseif ($agent->isDesktop() && $agent->is('Linux')) {
            $deviceType = 'Desktop';
            $operatingSystem = 'Linux';
        }
        // Check if the device is macOS
        elseif ($agent->isDesktop() && $agent->is('Macintosh')) {
            $deviceType = 'Desktop';
            $operatingSystem = 'macOS';
        }
                $browser = $agent->browser();
        $platform = $agent->platform();

        $browserVersion = $agent->version($browser);
        $platformVersion = $agent->version($platform);
        // dd($deviceType,$operatingSystem);
        \App\Models\ActivityLog::create([
            'id_number'=>Auth::user()->id_number,
            'activity'=>$activity,

            'browser'=>$browser,
            'browser_version'=>$browserVersion,
            'device'=>$operatingSystem,
            'device_version'=>$platformVersion,
            'device_type'=>$deviceType,
            'ip'=>Crypt::encryptString(Request::ip())

        ]);
    }
}
