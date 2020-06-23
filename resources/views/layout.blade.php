<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=0">
  <title>{{$template_titulo}}</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/product/">

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="/vendor/jquery/jquery.min.js"><\/script>')
  </script>
  <script src="{{asset('/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <link href="{{asset('/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <script src="{{asset('/vendor/blockui/jquery.blockUI.min.js')}}"></script>

  <!--TODO: descargar select2 local-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.full.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/i18n/ar.js"></script>
  <!-- Custom styles for this template-->
  <link href="{{asset('/css/sb-admin-2.css')}}" rel="stylesheet">
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    div.growlUI {
      background: url(check48.png) no-repeat 10px 10px
    }

    div.growlUI h1,
    div.growlUI h2 {
      color: white;
      padding: 5px 5px 5px 75px;
      text-align: left
    }


    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="https://getbootstrap.com/docs/4.3/examples/product/product.css" rel="stylesheet">
</head>
<?php
$usuArr = Session::get("usuario");
?>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('padron.inicio')}}">
        <div class="sidebar-brand-icon">
          <i class="fa fa-bars"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Transferencias</div>
      </a>


      <!-- Divider -->
      <hr class="sidebar-divider my-0">


      <!-- Heading -->
      <div class="sidebar-heading">
        Opciones
      </div>

      <!-- Nav Item - Pages Collapse Menu 
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-fw fa-cog"></i>
          <span>Diabetes</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu:</h6>
            <a class="collapse-item" href="//route1('formulario')">Formulario</a>
            <a class="collapse-item" href="//route1('inicio')">Padron</a>
          </div>
        </div>
      </li>
      -->
      <?php
      //TODO: implemetar tipo de 
      $tipo =  $usuArr->tipo;
      ?>
      <!-- Nav Item - Tables -->
      @if( $tipo == 1 || $tipo == 2 )
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/transferencia') }}">
          <i class="fa fa-fw fa-table"></i>
          <span>Transferencias</span></a>
      </li>
      @endif
      @if($tipo == 1 )

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#opadmin" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-fw fa-cog"></i>
          <span>Administracion de entidades</span>
        </a>
        <div id="opadmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Menu:</h6>
            <a class="collapse-item" href="{{ url('/usuario') }}">Usuarios</a>
          </div>
        </div>
      </li>

      @endif
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 " id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <?php
            /*
            ?>
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fa fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fa fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fa fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fa fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <?php 
            **/
            ?>
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $usuArr->nombre_completo  }}</span>
                <img class="img-profile rounded-circle" src="{{asset(Storage::url($usuArr->avatar)) }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('padron.configUsu')}}">
                  <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Perfil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->

        <div class="container-fluid">
          @yield('wizard')

          <div class="col-md-12">
            <h3>{{$template_titulo}}</h3>
            <hr>
          </div>
          <?php
          //App\Helpers\miPrint::dd(session("afiliado"),"afiliado _session2");                     
          ?>
          @include('comp/flash_message')
          @yield('contenido')
          @include('comp/comp_modalbox')

        </div>



        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white" style="padding: 1rem 0;">
        <hr>
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span style="font-size: 12px">Copyright &copy; Donington - Transferencias - 2020 </span>
          </div>
        </div>
        <div class="float-right" style="padding-right: 30px; font-size: 10px">v3.708</div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('/js/sb-admin-2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('/vendor/blockui/jquery.blockUI.js')}}" ></script>
  
</body>










<script>
  $(function() {
    /*
    var config = {
        '.select2-select': {                   
        }
    }
    for (var selector in config) {
        //$('#slimy').select2({'width':'100%'});
        $(selector).select2(config[selector]);
    }
    **/


    $.blockUI.defaults = {
      message: '<h3>Cargando, por favor espere... <i class="fa fa-spinner fa-spin"></i></h3>',

      title: null, // title string; only used when theme == true 
      draggable: true, // only used when theme == true (requires jquery-ui.js to be loaded) 

      theme: false, // set to true to use with jQuery UI themes 

      // styles for the message when blocking; if you wish to disable 
      // these and use an external stylesheet then do this in your code: 
      // $.blockUI.defaults.css = {}; 


      css: {
        padding: '15px',
        margin: 0,
        width: '30%',
        top: '40%',
        left: '35%',
        textAlign: 'center',
        color: '#fff',
        border: 'none',
        backgroundColor: '#000',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px',
        opacity: .8,
        cursor: 'wait'
      },

      // minimal style set used when themes are used 
      themedCSS: {
        width: '30%',
        top: '40%',
        left: '35%'
      },

      // styles for the overlay 
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6,
        cursor: 'wait'
      },

      // style to replace wait cursor before unblocking to correct issue 
      // of lingering wait cursor 
      cursorReset: 'default',

      // styles applied when using $.growlUI 
      growlCSS: {
        width: '350px',
        top: '10px',
        left: '',
        right: '10px',
        border: 'none',
        padding: '5px',
        opacity: 0.6,
        cursor: null,
        color: '#fff',
        backgroundColor: '#000',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px'
      },

      // IE issues: 'about:blank' fails on HTTPS and javascript:false is s-l-o-w 
      // (hat tip to Jorge H. N. de Vasconcelos) 
      iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank',

      // force usage of iframe in non-IE browsers (handy for blocking applets) 
      forceIframe: false,

      // z-index for the blocking overlay 
      baseZ: 1000000,

      // set these to true to have the message automatically centered 
      centerX: true, // <-- only effects element blocking (page block controlled via css above) 
      centerY: true,

      // allow body element to be stetched in ie6; this makes blocking look better 
      // on "short" pages.  disable if you wish to prevent changes to the body height 
      allowBodyStretch: true,

      // enable if you want key and mouse events to be disabled for content that is blocked 
      bindEvents: true,

      // be default blockUI will supress tab navigation from leaving blocking content 
      // (if bindEvents is true) 
      constrainTabKey: true,

      // fadeIn time in millis; set to 0 to disable fadeIn on block 
      fadeIn: 200,

      // fadeOut time in millis; set to 0 to disable fadeOut on unblock 
      fadeOut: 400,

      // time in millis to wait before auto-unblocking; set to 0 to disable auto-unblock 
      timeout: 0,

      // disable if you don't want to show the overlay 
      showOverlay: true,

      // if true, focus will be placed in the first available input field when 
      // page blocking 
      focusInput: true,

    }

  });
</script>


<style>
  body {
    font-size: 0.9rem;
  }

  .card {
    margin-bottom: 0.5rem;
  }

  .card-body {
    padding: 0.50rem 0.5rem;
  }

  .card-header {
    padding: 0.50rem 1.25rem;
  }

  .table {
    margin-bottom: 0.5rem;
  }
</style>

</html>