<!DOCTYPE html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/x-icon" href="{{ getFile(basicControl()->favicon_driver??'local',basicControl()->favicon??null) }}"/>
    <title>{{config('basic.site_title')}}</title>

    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'assets/bootstrap/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset(template(true).'scss/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/style.css')}}"/>

</head>

<body class="">

@yield('content')

<script src="{{asset(template(true).'assets/bootstrap/bootstrap.bundle.min.js')}}"></script>

</body>
</html>
