<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

<style>
    *{
        padding: 0px;
        margin: 0px;


    }
    body{
        padding: 2rem;
    }
    .title{
        text-align: center;
    }
    .table{
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-top: 2rem;
    }

    .table > thead > tr > th{
       padding: .5rem;
        border: 1px solid;

    }
    .table > tbody > tr > td{

        border: 1px solid;

    }
    .table > tbody > tr > td{
        padding: .5rem;
        text-align: center;


    }
</style>
</head>
<body>

@foreach($arr as $key => $value)
    {{-- Content --}}
    <div x-data="{employee: @js($value)}"  >
        <table border="1" style="border-collapse: collapse; margin: 0 auto;">
            <tr>
                <td style="border: 1px solid black; padding: 8px" rowspan="2">Days</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center" colspan="2">A.M.</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center" colspan="2">P.M.</td>
                <td style="border: 1px solid black; padding: 8px; text-align: center" colspan="2">UNDERTIME</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 8px">Arrival</td>
                <td style="border: 1px solid black; padding: 8px">Departure</td>
                <td style="border: 1px solid black; padding: 8px">Arrival</td>
                <td style="border: 1px solid black; padding: 8px">Departure</td>
                <td style="border: 1px solid black; padding: 8px">Hours</td>
                <td style="border: 1px solid black; padding: 8px">Minutes</td>
            </tr>
            @foreach($value as $dateKey => $date)

                <tr x-data="{date: @js($date)}">
                    <td  style="text-align: center;font-weight: bold">

                        {{explode('-',$dateKey)[1]}}
                    </td>
                    <td class=" px-2.5 text-center border"
                        :class="{

                                                                'text-red-500': date.type === 'Absent',
                                                                'font-bold': date.type === 'Absent' || typeof(
                                                                    date
                                                                ) === 'string' ? true : false // This will ensure 'font-bold' is applied if type is 'Absent'
                                                            }"
                        :colspan="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 6 : 1"
                        x-text="convertDate(date)"></td>
                    <td style="border: 1px solid black; padding: 8px"
                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                        x-text="date.date_departure_am"></td>
                    <td style="border: 1px solid black; padding: 8px"
                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                        x-text="date.date_arrival_pm">
                    </td>
                    <td style="border: 1px solid black; padding: 8px"
                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                        x-text="date.date_departure_pm"></td>
                    <td style="border: 1px solid black; padding: 8px"
                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                        x-text="convertUndertime('h',date)">

                    </td>
                    <td style="border: 1px solid black; padding: 8px"
                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                        x-text="convertUndertime('m',date)">

                    </td>
                    <td class="whitespace-nowrap"
                        :class="typeof(date) === 'string' || date.type == 'Absent' || date.type == 'travel' ? 'hidden' : ''"
                        x-text="decrease(date)"></td>
                </tr>
            @endforeach

        </table>
    </div>




@endforeach
</body>
</html>
