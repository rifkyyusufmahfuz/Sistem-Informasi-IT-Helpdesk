<!DOCTYPE html>

<html>

<head>
    <title>
        @if (Request::is('/'))
            KCI IT Helpdesk - Login
        @elseif(Request::is('registrasi'))
            KCI IT Helpdesk - Registrasi
        @elseif(Request::is('reset_password'))
            KCI IT Helpdesk - Reset Password
        @else
            KCI IT Helpdesk
        @endif
    </title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="{!! asset('custom_script/img/Logo_KAI_Commuter_kecil.png') !!}" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

</head>

<body background="{{ asset('custom_script/img/bg-login.webp') }}" style="background-repeat: no-repeat;background-size: cover;">



    @yield('content')



</body>

<footer>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @include('sweetalert::alert')
</footer>


</html>
