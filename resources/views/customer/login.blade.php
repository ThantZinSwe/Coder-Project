@extends('layout.app')
@section('content')
    <section class="active-plan">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-7 col-7">
                    <div class="card p-4 login">
                        <div class="card-header text-center">
                            <span class="login-logo"><i class="far fa-user"></i></span>
                            <h5 class="mt-2 fw-bold">Sign up</h5>
                        </div>
                        <form action="{{route('postLogin')}}" class="mt-4 user-login-form" method="post">
                            @csrf
                            <div class="form-group my-4 input">
                                <input type="email" name="email" class="form-control" placeholder="Useremail" value="{{old('email')}}">

                                @if ($errors->has('email'))
                                    <small class="text-danger">{{$errors->first('email')}}</small>
                                @endif
                            </div>

                            <div class="form-group my-4 input">
                                <input type="password" name="password" class="form-control" placeholder="Password" value="{{old('password')}}">

                                @if ($errors->has('password'))
                                    <small class="text-danger">{{$errors->first('password')}}</small>
                                @endif
                            </div>

                            <div>
                                <input type="submit" value="Login" class="btn btn-danger">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function($){

            @if(session('error')){
                Toast.fire({
                icon: 'error',
                title: "{{session('error')}}"
                })
            }
            @endif

            @if(session('success')){
                Toast.fire({
                icon: 'success',
                title: "{{session('success')}}"
                })
            }
            @endif
        });
    </script>
@endsection
