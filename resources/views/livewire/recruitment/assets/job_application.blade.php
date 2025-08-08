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
    <h1 class="title" >Deped Region 4A - Jobs</h1>
    <table class="table">
        <thead>
            <tr>

                <th>Job Title</th>
                <th>Plantila</th>
                <th>Status of Hiring</th>
                <th>Status of appointment</th>
                <th>Posting Date</th>
                <th>Closing Date</th>
                <th>No. of Applicant</th>
            </tr>
        </thead>
        <tbody>

          @foreach ($records as $record)
          <tr>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->job_title }}</p></td>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->plantilla_item }}</p></td>
            <td>
                @if ( $record->status_of_hiring == '0')
                <p style="white-space: pre-wrap;overflow-wrap:break-word ">Close</p>
                @elseif( $record->status_of_hiring == '1')

                    <p style="white-space: pre-wrap;overflow-wrap:break-word ">Open</p>

                @endif
            </td>
            <td><p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->status_of_appointment }}</p></td>
            <td><p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->created_at }}</p></td>
            <td><p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->closing_date }}</p></td>
            <td><p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->all_applicant_count }}</p></td>



        </tr>
          @endforeach

        </tbody>
    </table>
</body>
</html>
