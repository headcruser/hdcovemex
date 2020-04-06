<!DOCTYPE html>
<html lang="{{ getLocale()  }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="{{ config('app.description') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('helpdesk.global.alias') }}  | @yield('title','default section')</title>

  <link href="{{ asset('img/brand/favicon.png') }}" rel="icon" type="image/png">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  @yield('styles')

</head>

<body class="hold-transition login-page">

    @yield('content')

    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
