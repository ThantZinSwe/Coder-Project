@extends('layout.app')
@section('content')
    <section class="main-plan">
        <div class="container mt-4">
            <div class="row">
                @foreach ($plan as $p)
                    <div class="col-lg-6 col-md-6 col-12 mt-3">
                        <div class="card p-4 text-center" style="background-color: #f1f2f6;">
                            <h5 style="letter-spacing: 2px"><i class="fas fa-hourglass-half"></i> {{$p->title}}</h5><hr>
                            <div class="mt-2">
                                <p class="d-inline me-2 fw-bold">Price : </p>
                                <p class="badge badge-danger badge-pill fs-6">{{$p->price}} Ks</p>
                            </div>
                            <div class="mb-3">
                                <p class="d-inline me-1 fw-bold">Plan-Type :</p>
                                <p class=" d-inline fs-6 text-muted">{{$p->description}}</p>
                            </div>
                            <div class=" ">
                                <p class="d-inline me-1 fw-bold">Learn Date :</p>
                                <p class=" d-inline fs-6 text-muted">{{$p->learn_date}} days</p>
                            </div>
                            <div class="mt-4">
                                @if ($isEnroll)
                                    @if ($enroll->type == 'pending' || $enroll->type == 'active')
                                        <p class="text-muted">Sorry,you already bought one plan or our team checking your payment.Please use until your plan.If your plan expired,you can buy another new plan.</p>
                                        <a href="{{route('activePlan',$p->slug)}}" class="btn btn-default" style="cursor: default;pointer-events: none; ">Acitve</a>
                                    @else
                                        <a href="{{route('activePlan',$p->slug)}}" class="btn btn-outline-danger">Acitve</a>
                                    @endif
                                @else
                                <a href="{{route('activePlan',$p->slug)}}" class="btn btn-outline-danger">Acitve</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function($){
            @if(session('error')){
                    Toast.fire({
                    icon: 'warning',
                    title: "{{session('error')}}"
                    })
                }
            @endif
        });
    </script>
@endsection
