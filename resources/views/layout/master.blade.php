
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    Coding Site
  </title>
  <!-- Favicon -->
  <link href="{{asset('admin/img/brand/blue.png')}}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{asset('admin/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
  <link href="{{asset('admin/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{asset('admin/css/argon-dashboard.css?v=1.1.2')}}" rel="stylesheet" />
  @yield('css')
</head>

<body class="">
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
          <!-- Toggler -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <!-- Brand -->
          <a class="navbar-brand pt-0" href="{{route('home')}}">
            <img src="https://i.pinimg.com/236x/b7/69/e2/b769e281ff50d97de6b159bbe78161b4--logo-s-corporate-design.jpg" class="navbar-brand-img" alt="...">
          </a>
          <!-- Collapse -->
          <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
              <div class="row">
                <div class="col-6 collapse-brand">
                  <a href="{{route('home')}}">
                    <img src="https://i.pinimg.com/236x/b7/69/e2/b769e281ff50d97de6b159bbe78161b4--logo-s-corporate-design.jpg">
                  </a>
                </div>
                <div class="col-6 collapse-close">
                  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                    <span></span>
                    <span></span>
                  </button>
                </div>
              </div>
            </div>
            <!-- Form -->
            {{-- <form class="mt-4 mb-3 d-md-none">
              <div class="input-group input-group-rounded input-group-merge">
                <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fa fa-search"></span>
                  </div>
                </div>
              </div>
            </form> --}}
            <!-- Navigation -->
            <ul class="navbar-nav">
              <li class="nav-item  active ">
                <a class="nav-link  active " href="{{route('home')}}">
                  <i class="ni ni-tv-2 text-primary"></i> Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{route('category.index')}}">
                    <i class="fab fa-connectdevelop text-blue"></i> Category
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{route('language.index')}}">
                    <i class="fas fa-code text-orange"></i> Language
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{route('article.index')}}">
                    <i class="fab fa-leanpub text-primary"></i> Article
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{route('course.index')}}">
                    <i class="fas fa-laptop-code text-red"></i> Course
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{route('member.index')}}">
                    <i class="fas fa-wallet text-purple"></i></i> Membership
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{route('enroll.index')}}">
                    <i class="far fa-handshake text-cyan"></i> Student Enroll
                    @if ($enroll_count)
                        <small class="badge badge-pill badge-warning">{{ $enroll_count}}</small>
                    @endif
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('logout')}}">
                  <i class="ni ni-key-25 text-info"></i> Logout
                </a>
              </li>
            </ul>
            <!-- Divider -->
          </div>
        </div>
    </nav>
    <div class="main-content">
        @yield('content')
    </div>

  <!--   Core   -->
  <script src="{{asset('admin/js/plugins/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('admin/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <!--   Optional JS   -->
  <script src="{{asset('admin/js/plugins/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('admin/js/plugins/chart.js/dist/Chart.extension.js')}}"></script>
  <!--   Argon JS   -->
  <script src="{{asset('admin/js/argon-dashboard.min.js?v=1.1.2')}}"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  {{-- Sweet Alert2 --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  {{-- Sweet Alert1 --}}
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
      $(function($){
        let token = document.head.querySelector('meta[name="csrf-token"]');
            if(token){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN':token.content
                    }
                });
            }else{
                console.error('csrf token not found');
            }

        $("#back-btn").on("click",function(e){
            e.preventDefault();
            window.history.go(-1);
            return false;
        });

      });
  </script>
  @yield('script')
</body>

</html>
