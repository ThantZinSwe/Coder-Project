@extends('layout.app')
@section('content')
    <section class="active-plan">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-7 col-7">
                    <div class="card p-4">
                        <div class="card-header text-center">
                            <h5 class="mt-2 fw-bold">Create an account</h5>
                        </div>
                        <form action="{{route('customer.postRegister')}}" class="mt-4" method="post">
                            @csrf
                            <div class="form-group my-4 input">
                                <label for="" class="">Name</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">

                                @if ($errors->has('name'))
                                    <small class="text-danger">{{$errors->first('name')}}</small>
                                @endif
                            </div>

                            <div class="form-group my-4 input">
                                <label for="" class="">Email</label>
                                <input type="email" name="email" class="form-control" value="{{old('email')}}">

                                @if ($errors->has('email'))
                                    <small class="text-danger">{{$errors->first('email')}}</small>
                                @endif
                            </div>

                            <div class="form-group my-4 input">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" value="{{old('password')}}">

                                @if ($errors->has('password'))
                                    <small class="text-danger">{{$errors->first('password')}}</small>
                                @endif
                            </div>

                            <div>
                                <input type="submit" value="Sign up" class="btn btn-danger">
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
