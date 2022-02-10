@extends('layout.app')
@section('content')
    <section class="active-plan">
        <div class="container mt-4">
            <div class="row">
                <h5 class="text-center fw-bold"><i class="fas fa-feather-alt"></i> {{$plan->title}}</h5>
                <div class="col-lg-4 col-md-12 col-12 p-3">
                    <div class="card p-4" style="background-color: #f1f2f6;">
                        <div class="text-center">
                            <p class="mb-0 fw-bold"><i class="fas fa-calendar-day"></i> Learn Date : <small class="text-danger">{{$plan->learn_date}} days</small></p>
                            <p class="mb-0 fw-bold"><i class="fas fa-coins"></i> Payment Cost : <small class="text-danger">{{$plan->price}} kyats</small></p>
                            <p class="mt-2 mb-0 text-muted fw-bold" style="font-size: 15px">Please transfer from this phone number <b class="text-danger">0981723811</b> and Payment Screenshot add at payment image.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="card p-4 mt-3" style="background-color: #f1f2f6;">
                        <form action="{{route('storePlan',$plan->slug)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Payment Image</label>
                                <input type="file" name="paymentImage" id="image" class="form-control mt-2">

                                @if ($errors->has('paymentImage'))
                                    <small class="text-danger">{{$errors->first('paymentImage')}}</small>
                                @endif

                                <div class="preview-img mt-3">

                                </div>
                            </div>

                            <div>
                                <input type="submit" value="Purchase" class="btn btn-danger btn-sm">
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
           $('#image').on('change',function(){
                $file_length = document.getElementById('image').files.length;
                $('.preview-img').html('');

                for(var i=0; i<$file_length; i++){
                    $('.preview-img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" class="img-thumbnail" alt="" width="100px">`)
                }
            });

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

            @if(session('fail')){
                Toast.fire({
                icon: 'warning',
                title: "{{session('fail')}}"
                })
            }
            @endif
        });
    </script>
@endsection
