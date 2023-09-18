<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE 3 | Projects</title>

    <!-- Google Font: Source Sans Pro -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("/vendor/fontawesome-free/css/all.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("/vendor/adminlte/dist/css/adminlte.min.css") }}">
</head>
<body class="hold-transition sidebar-mini">
<!-- jQuery -->
<script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery -->
<script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>

<script type="text/javascript">
    const token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });
</script>

<!-- Site wrapper -->
<div class="wrapper">
    @include("admin.layouts.navbar")
    @include("admin.layouts.sidebar")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield("content")
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->
</body>
</html>
