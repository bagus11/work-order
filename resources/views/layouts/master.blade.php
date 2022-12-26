
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Work Order')</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-wrapper py-4">
            @yield('content')
        </div>


        <aside class="control-sidebar control-sidebar-dark">

            <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
            </div>
        </aside>
        @include('layouts.footer')
        </div>

        <script src="{{asset('js/app.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            var url = window.location;
           // for sidebar menu entirely but not cover treeview
           $('ul.nav-sidebar a').filter(function() {
               return this.href == url;
           }).addClass('active');
       
           // for treeview
           $('ul.nav-treeview a').filter(function() {
               return this.href == url;
           }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('');
       
           // Swal Loading
           function SwalLoading(html = 'Loading ...', title = '') {
              return Swal.fire({
                  title: title,
                  html: html,
            customClass: 'swal-wide',
                  timerProgressBar: true,
                  allowOutsideClick: false,
                  didOpen: () => {
                      Swal.showLoading()
                  }
              });
          }
          $(".select2").select2({ width: '300px', dropdownCssClass: "bigdrop" });
       </script>
        @stack('custom-js')
    </body>
</html>

<style>
.datatable-bordered{
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
  }

  .datatable-bordered td, .datatable-bordered th {
  padding: 8px;
  }

  .datatable-bordered tr:nth-child(even){background-color: #f2f2f2;}

  .datatable-bordered tr:hover {background-color: #ddd;}

  .datatable-bordered th {
  border: 1px solid #ddd;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
  background-color: white;
  color: black;
  }

.select2-selection__rendered {
    line-height: 35px !important;
}
.select2-container .select2-selection--single {
    height: 45px !important;
}
.select2-selection__arrow {
    height: 44px !important;
}
</style>