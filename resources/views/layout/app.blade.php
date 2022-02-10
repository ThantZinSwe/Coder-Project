<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Coder Hub</title>
</head>
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.1/mdb.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('customer/style.css')}}">

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent bg-transparent" id="home">
        <!-- Container wrapper -->
        <div class="container">
            <!-- Navbar brand -->
            <a class="navbar-brand me-2" href="{{route('index')}}">
                <img src="https://media-exp1.licdn.com/dms/image/C4D0BAQHZtT-8T4oEEQ/company-logo_200_200/0/1519922052407?e=2159024400&v=beta&t=3pjhjzmn8GBtGkSw6E0eL5lgxATJSK1AJdtEepMgCMk"
                    alt="MDB Logo" loading="lazy" style="margin-top: -1px;" />
            </a>

            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <!-- Left links -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('article')}}">Article</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{url('course')}}">Course</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{url('plan')}}">Plan Price</a>
                    </li>
                </ul>
                <!-- Left links -->

                <div class="d-flex align-items-center">
                    @auth
                        <a href="{{route('history')}}" class="btn btn-link px-3 me-2 text-black"><i class="fas fa-history"></i> History</a>
                        <a href="{{route('customer.logout')}}" class="btn btn-link px-3 me-2 text-black"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    @endauth
                    @guest
                        <a href="{{route('login')}}" class="btn btn-link px-3 me-2 text-black"><i class="fas fa-sign-in-alt"></i> Login</a>
                        <a href="{{route('customer.register')}}" class="btn btn-link px-3 me-2 text-black"><i class="fas fa-registered"></i> Sign up for free</a>
                    @endguest
                </div>
            </div>
            <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    @yield('content')
</body>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.1/mdb.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
{{-- Sweet Alert2 --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Sweet Alert1 --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
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

        @if(session('success')){
                Toast.fire({
                icon: 'success',
                title: "{{session('success')}}"
                })
            }
        @endif
        });
    </script>
@yield('script')
</html>
