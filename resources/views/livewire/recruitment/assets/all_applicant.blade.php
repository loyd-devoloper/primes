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
    <h1 class="title" >{{ $job_title }} - Applicant</h1>
    <table class="table">
        <thead>
            <tr>
                <th>JOB</th>
                <th>Plantilla Item</th>
                <th>Applicant Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Sex</th>
                <th>Birth Date</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Status</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>

          @foreach ($records as $record)
          <tr>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->jobInfo?->job_title }}</p></td>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->jobInfo?->plantilla_item }}</p></td>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->application_code }}</p></td>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->fname.' '.$record->mname.' '.$record->lname }}</p></td>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->email }}</p></td>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->sex == 'F' ? 'FEMALE' :'MALE'  }}</p></td>
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->birthdate }}</p></td>
            <td><p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->mobile_number }}</p></td>
            <td><p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $record->address }}</p></td>
            <td>
                @if ( $record->application_status == 0)
                <p style="white-space: pre-wrap;overflow-wrap:break-word ">Pending</p>
                @elseif( $record->application_status == 1)

                    <p style="white-space: pre-wrap;overflow-wrap:break-word ">Validate</p>
                @elseif ( $record->application_status == 2)

                <p style="white-space: pre-wrap;overflow-wrap:break-word "> Qualified</p>
                @endif
            </td>
            <td><p style="white-space: pre-wrap;overflow-wrap:break-word ">{{  \Carbon\Carbon::parse($record->created_at)->format('M d, Y h:m:s A') }}</p></td>


        </tr>
          @endforeach

        </tbody>
    </table>
</body>
</html>
