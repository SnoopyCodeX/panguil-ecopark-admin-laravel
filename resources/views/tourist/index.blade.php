<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Panguil River Eco-Park and Resort">
    <meta name="author" content="SnoopyCodeX">
    <meta name="keywords" content="">
    <title>Panguil Ecopark</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- bootstrap css -->
    <script src="{{ asset('assets/vendors/core/core.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}
    <!-- endinject -->

    {{-- @yield("$page-css") --}}

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">

    <style>
        @font-face {
            font-family: rubikdirt;
            src: url("{{ asset('assets/fonts/rubik-dirt-font/rubik-dirt.ttf') }}");
        }
    </style>

    @vite('resources/css/app.css')
    <!-- endinject -->

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" />
</head>

<body style="background: url('{{ asset('assets/images/landing_page_bg_img.jpg') }}') no-repeat; background-size: cover; width: 100%; height: 100%;">
    {{-- Navbar --}}
    @include('tourist.layouts.header')

    <div class="container-fluid">
        {{-- Content --}}
        @yield($page)
    </div>

    {{-- Footer --}}
    @include('tourist.layouts.footer')

</body>

</html>
