
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Work Order')</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="icon" href="{{URL::asset('icon.jpg')}}">
    
        <!-- Tempus Dominus Styles -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>
    <body class="hold-transition skin-blue sidebar-collapse">
        <div class="wrapper">
        @include('rfp.layout.navbar')
        <input type="hidden" class="form-control" id="auth_id" value="{{auth()->user()->id}}">
        
            <input type="hidden" id="authId" value="{{auth()->user()->id}}">
            @yield('content')
        


        <aside class="control-sidebar control-sidebar-dark overflow-auto">

            <div class="p-3">
          
            </div>
        </aside>
        {{-- @include('layouts.footer') --}}
        </div>

        <script src="{{asset('js/app.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        {{-- <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> --}}
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> 
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        {{-- <script src="{{asset('js/chartjs-plugin-labels.js')}}"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" 
        integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" 
        referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
       <!--Moment JS CDN-->
        <script src="https://momentjs.com/downloads/moment.js"></script>

        <!--Tempusdominus JS CDN-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>

        <!--Tempusdominus CSS CDN-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <script>
            
            function zoom() {
                document.body.style.zoom = "80%" 
            }
            $(document).ready(function(){
                $(".select2").select2();
                $(".select2").select2({ dropdownCssClass: "myFont" });
            });
            var url = window.location;
           // for sidebar menu entirely but not cover treeview
           $('ul.nav-sidebar a').filter(function() {
               return this.href == url;
           }).addClass('active');
           $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           })
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
        @include('RepositoryPattern.repo-js')
        @stack('custom-js')
    </body>
</html>

<style>
    
    .selectOption2{
    font-size:9px;
  }
.datatable-bordered{
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100% !important;
  font-size: 9px;
  overflow-x:auto !important;
  
  }
  .nav-sidebar{
    overflow-y: auto;
  }
  .dataTables_filter input { width: 300px }
  .datatable-bordered td, .datatable-bordered th {
  padding: 8px;
  }
  .datatable-bordered tr:nth-child(even){background-color: #f2f2f2;}

  .datatable-bordered tr:hover {background-color: #ddd;}
  .countMoney{
    text-align: end
  }
  .datatable-bordered th {
  border: 1px solid #ddd;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
  background-color: white;
  color: black;
  overflow-x:auto !important;
  }

  ion-icon
    {
     zoom: 1.5;
     margin:auto
    }
.select2{
    width: 100% !important;
    font-size:9px;
}
.select2-selection__rendered {
    line-height: 25px !important;
    font-size:9px;
  
}
.select2-container .select2-selection--single {
    height: 35px !important;
    font-size:9px;
}
.select2-selection__arrow {
    height: 34px !important;
    font-size:9px;
}

.dataTables_scrollHeadInner, .table{
     width:100%!important; 
     font-size:9px;
}
p{
  font-size: 10px !important;
}
.open\:bg-green-200[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(187 247 208 / var(--tw-bg-opacity));
}
.open\:bg-red-600[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(220 38 38 / var(--tw-bg-opacity));
}
.open\:bg-red-200[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(254 202 202 / var(--tw-bg-opacity));

}
.open\:bg-amber-200[open] {
  --tw-bg-opacity: 1;
  background-color: rgb(253 230 138 / var(--tw-bg-opacity));
}
th.details-control {
  background-color: #04AA6D;
  color: white;
}
td.details-control {
background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
cursor: alias;
}
tr.shown td.details-control {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}

td.details-click {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
}
tr.shown td.details-click {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}

th.subdetails-control {
  background-color: #04AA6D;
  color: white;
}
td.subdetails-control {
background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
cursor: alias;
}
tr.shown td.subdetails-control {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}

td.subdetails-click {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
}
tr.shown td.subdetails-click {
    background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
}
.rating {
   position: relative;
   width: 180px;
   background: transparent;
   display: flex;
   justify-content: center;
   align-items: center;
   gap: .3em;
   padding: 5px;
   overflow: hidden;
   border-radius: 20px;
   box-shadow: 0 0 2px #b3acac;
}

.rating__result {
   position: absolute;
   top: 0;
   left: 0;
   transform: translateY(-10px) translateX(-5px);
   z-index: -9;
   font: 3em Arial, Helvetica, sans-serif;
   color: #ebebeb8e;
   pointer-events: none;
}

.rating__star {
   font-size: 1.3em;
   cursor: pointer;
   color: #dabd18b2;
   transition: filter linear .3s;
}

.rating__star:hover {
   filter: drop-shadow(1px 1px 4px gold);
}
.datatable-stepper{
  /* font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100% !important;
  font-size: 12px;
  overflow-x:auto !important; */
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  border-spacing: 0;
  font-size: 9px;
  width: 100% !important;
  border: 1px solid #ddd;
  
  }
  .datatable-stepper tr:nth-child(even){background-color: #f2f2f2;}

  .datatable-stepper tr:hover {background-color: #ddd;}

  .datatable-stepper th {
  border: 1px solid #ddd;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
  
  color: black;
  overflow-x:auto !important;
  }
  .datatable-stepper td, .datatable-stepper th {
        border: 1px solid #ddd;
        padding: 8px;
       
    }
  .headerTitle{
    font-size: 14px;

  }
  fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.5em 1.5em 1.5em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 12px !important;
        font-weight: bold !important;
        text-align: left !important;
    }
    .btnAction  {
      appearance: none;
      backface-visibility: hidden;
      background-color: #27ae60;
      border-radius: 8px;
      border-style: none;
      box-shadow: rgba(39, 174, 96, .15) 0 4px 9px;
      box-sizing: border-box;
      color: #fff;
      cursor: pointer;
      display: inline-block;
      font-family: Inter,-apple-system,system-ui,"Segoe UI",Helvetica,Arial,sans-serif;
      font-size: 16px;
      font-weight: 600;
      letter-spacing: normal;
      line-height: 1.5;
      outline: none;
      overflow: hidden;
      padding: 13px 20px;
      position: relative;
      text-align: center;
      text-decoration: none;
      transform: translate3d(0, 0, 0);
      transition: all .3s;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      vertical-align: top;
      white-space: nowrap;
    }

    .btnAction :hover {
      background-color: #1e8449;
      opacity: 1;
      transform: translateY(0);
      transition-duration: .35s;
    }

    .btnAction :active {
      transform: translateY(2px);
      transition-duration: .35s;
    }

    .btnAction :hover {
      box-shadow: rgba(39, 174, 96, .2) 0 6px 12px;
    }
    .myFont{
      font-size:9px !important
    }
    .bg-core {
      background-color: #213555 !important;
      color: white;
    }
    .desk {
      display: flex;
      justify-content: center;
    }
        
    /* .cursor-grab {
      cursor: -webkit-grab;
      cursor: grab;
    }

    .tasks {
      min-height: 450px;
    }
    */

    .mask-custom {
      background: rgba(24, 24, 16, .2);
      border-radius: 2em;
      backdrop-filter: blur(15px);
      border: 2px solid rgba(255, 255, 255, 0.05);
      background-clip: padding-box;
      box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
    }
</style>