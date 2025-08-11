<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="margin: 0%;padding:0%;font-size:.6rem;position: relative">
    <div style="padding-bottom: .8rem;">
        <h1 style="position: absolute; transform: rotate(45deg); font-family: 'Monaco', monospace; font-size: 3.25rem; top: 12rem; font-weight: 800; right: 30%; opacity: 0.1;">PERSONNEL SECTION</h1>
        <p
            style="text-align: center; text-decoration: underline;font-size:1.2rem;font-weight:600;font-family:sans-serif">
            EMPLOYEE'S LEAVE CARD</p>
        <div style="width:100%">
            <div style="width:49%;display: inline-block;font-size: 1rem">Name <span
                    style="text-decoration: underline;font-weight: 600">{{ strtoupper($name) }}</span></div>
            <div style="width:25%;display: inline-block;font-size: 1rem">Civil Status <span
                    style="text-decoration: underline;font-weight: 600">{{ strtoupper($userInfo?->civil_status) }}</span></div>
            <div style="width:25%;display: inline-block;font-size: 1rem">GSIS Policy NO. </div>
        </div>
        <div style="width:100%;margin-top: .7rem">
            <div style="width:49%;display: inline-block;font-size: 1rem">Position </div>
            <div style="width:25%;display: inline-block;font-size: 1rem">Entrance to Duty </div>
            <div style="width:25%;display: inline-block;font-size: 1rem">Tin No. <span
                    style="text-decoration: underline;font-weight: 600">{{ !!$userInfo->tin_no ? strtoupper(Crypt::decryptString($userInfo?->tin_no)) : '' }}</span></div>
        </div>
        <div style="width:100%;margin-top: .7rem">
            <div style="width:49%;display: inline-block;font-size: 1rem">Status </div>
            <div style="width:25%;display: inline-block;font-size: 1rem">Unit </div>
            <div style="width:25%;display: inline-block;font-size: 1rem">National Reference Card No.</div>
        </div>
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;" rowspan="2">PERIOD</th>
                <th style="border: 1px solid black; padding: 8px;" rowspan="2">PARTICULARS</th>

                <th style="border: 1px solid black; padding: 8px;" colspan="4">VACATION LEAVE</th>
                <th style="border: 1px solid black; padding: 8px;" colspan="4">SICK LEAVE</th>
                <th style="border: 1px solid black; padding: 8px;" rowspan="2">REMARKS</th>
            </tr>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">EARNED</th>
                <th style="border: 1px solid black; padding: 8px;">Absence <br> Undertime <br> W/ Pay</th>
                <th style="border: 1px solid black; padding: 8px;">BALANCE</th>
                <th style="border: 1px solid black; padding: 8px;">Absence <br> Undertime <br> W/O Pay</th>

                <th style="border: 1px solid black; padding: 8px;">EARNED</th>
                <th style="border: 1px solid black; padding: 8px;">Absence <br> Undertime <br> W/ Pay</th>
                <th style="border: 1px solid black; padding: 8px;">BALANCE</th>
                <th style="border: 1px solid black; padding: 8px;">Absence <br> Undertime <br> W/O Pay</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($leaveData as $leave)
                @if ($leave->start_date < \Carbon\Carbon::now())
                    <tr>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">{{ $leave->period }}</td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">
                            @if (!!$leave?->type)
{{--                                {{ "($leave->days-$leave->hours-$leave->mins) $leave->type" }}--}}
                            @else
                                <strong>{{ $leave->particulars }}</strong>
                            @endif
                        </td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">{{ $leave?->vl_earn }}</td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">
                            {{ $leave->type == 'VL' || $leave->type == 'FL' || $leave->type == 'L/UT' ? $leave?->w_pay : '' }}
                        </td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">{{ $leave?->vl_balance }}
                        </td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">
                            {{ $leave->type == 'VL' || $leave->type == 'FL' ? $leave?->w_o_pay : '' }}</td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">{{ $leave?->sl_earn }}</td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">
                            {{ $leave->type == 'SL' ? $leave?->w_pay : '' }}</td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">{{ $leave?->sl_balance }}
                        </td>
                        <td style="border: 1px solid black; padding: 8px;text-align: center">
                            {{ $leave->type == 'SL' ? $leave?->w_o_pay : '' }}</td>
                        <td style="border: 1px solid black; padding: 0px;max-width: 4rem;text-align: center;overflow-wrap: break-word;">
                            <p style="">{{ $leave?->remarks }}</p>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
