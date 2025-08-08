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

    <table class="table">
        <thead>
            <tr>
                {{-- <th>#</th> --}}
                <th>DIVISION/SECTION</th>
                <th>Employees</th>

            </tr>
        </thead>
        <tbody>

          @foreach ($records as $key => $record)
          <tr>
            {{-- <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $loop->iteration }}</p></td> --}}
            <td> <p style="white-space: pre-wrap;overflow-wrap:break-word ">{{ $key }}</p></td>
            <td>
               <ol>
                @foreach ($record as $employee)
                <li >{{ $employee?->name }}</li>

            @endforeach
               </ol>
            </td>

        </tr>
          @endforeach

        </tbody>
    </table>
</body>
</html>
