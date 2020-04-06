<!DOCTYPE html>
<html lang="{{ getLocale()  }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="{{ config('app.description') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{  config('helpdesk.global.alias') }} | @yield('title','default section')</title>

  <link href="{{ asset('img/brand/favicon.png') }}" rel="icon" type="image/png">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  @yield('styles')

</head>
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        @include('includes.panel._navbar')

        @include('includes.panel._sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <!-- /.container-fluid -->
                <div class="container-fluid">
                    <div class="row mb-2">

                        <div class="col-sm-6">
                            <h1>@yield('title','Blank page') </h1>
                        </div>
                        <div class="col-sm-6">
                            @section('breadcrumb')
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Blank Page</li>
                                </ol>
                            @show
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('includes.panel._footer')
        <script src="{{ mix('js/vendor.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });

            @if(Session::has('error'))
                Toast.fire({
                    type: 'error',
                    title: "{{ Session::get('error') }}"
                })
            @endif

            @if(Session::has('message'))
                Toast.fire({
                    type: 'success',
                    title: "{{ Session::get('message') }}"
                })
            @endif

            @if(Session::has('status'))
                Toast.fire({
                    type: 'success',
                    title: "{{ Session::get('status') }}"
                })
            @endif
        </script>

        @yield('scripts')
</body>
</html>

