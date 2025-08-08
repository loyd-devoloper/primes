<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Styles -->
    <style>
        * {

            padding: 0%;
            margin: 0%;
        }

        html {
            margin: 0px;
        }

        @page {
            padding: 0px;
        }

        #container {
            position: relative;
            background: green;
            width: fit-content;
            height: fit-content;

        }
    </style>

</head>

<body >

    <section id="container" style="position: relative" >

        @if (array_key_exists('middlename', json_decode($activeTemplateData->attributes->attribute, true)))
            <p style="position: absolute;"
                id='middlename'>middlename</p>
        @endif
        @if (array_key_exists('firstname', json_decode($activeTemplateData->attributes->attribute, true)))
        <p style="position: absolute;top: 378.1999816894531px;right:332.7250061035156px;left:96.19999694824219px;bottom:614.7249755859375px;height:236.52499389648438px;width:236.52500915527344px"
            id='firstname'>firstname</p>
    @endif

    </section>
<script>
    var fname = document.querySelector('#middlename');

     var x = @js(json_decode($activeTemplateData->attributes->attribute, true));
       fname.style.transform = 'translate(' + 0 + 'px, ' + x.middlename.position.y + 'px)';
</script>
</body>

</html>
