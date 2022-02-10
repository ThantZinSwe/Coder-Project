@extends('layout.app')
@section('content')
<!-- Body start -->
<section class="content">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5">
                <div class="profile-img">
                    <img src="{{asset('customer/img/work.png')}}" alt="" class="mx-auto d-block img-fluid">
                </div>
            </div>
            <div class="col-lg-7 col-md-7">
                <div class="title-text">
                    <h2 data-text="Welcome My Coder Hub!">Welcome My Coder Hub!</h2>
                    <p class="text-muted">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates
                        excepturi distinctio pariatur veniam velit reprehenderit numquam. Perspiciatis optio
                        voluptatibus ea nemo. Incidunt odit alias ullam harum, voluptatum doloribus consectetur sit?
                    </p>
                    <div class="mt-4">
                        <a href="#course" class="btn btn-danger">Course</a>
                        <a href="#article" class="btn btn-outline-danger">Article</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-line">

        </div>
    </div>
</section>
<!-- Body end -->
<div class="main-title my-5">
    <h5 class="text-center text-muted">Course And Article</h5>
</div>
<!-- Main Project start -->
<section class="main-content">
    <div class="container" id="course">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="d-flex justify-content-between">
                    <h5>Courses</h5>
                    <a href="{{route('course')}}" class="btn btn-danger">All Courses</a>
                </div>
            </div>
        </div>

        <div class="card my-2 p-4" style="background-color: #f1f2f6;">
            <div class="row">
               @foreach ($course as $c)
                <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
                    <div class="card main-card">
                        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                            <img src="{{asset('courseImage/'.$c->image)}}" class="img-fluid" />
                            <a href="{{route('courseDetail',$c->slug)}}">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                            </a>
                        </div>

                        <div class="card-body">
                            <p class="text-center title">{{$c->title}}</p>
                            <div class="d-flex justify-content-between mt-4">
                                <div class="heart">
                                    <p class="mb-0 text-danger"><i class="fas fa-heart"></i></p>
                                    <p class="mb-0 count text-muted text-center">{{$c->like_count}}</p>
                                </div>
                                <div class="video">
                                    <p class="mb-0 text-danger"><i class="fas fa-play-circle"></i></p>
                                    <p class="mb-0 count text-muted text-center">{{$c->video_count}}</p>
                                </div>
                                <div class="student">
                                    <p class="mb-0 text-danger"><i class="fas fa-comments"></i></p>
                                    <p class="mb-0 count text-muted text-center">{{$c->comment_count}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               @endforeach
            </div>
        </div>
    </div>

    <div class="container mt-5" id="article">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="d-flex justify-content-between">
                    <h5>Article</h5>
                    <a href="{{route('article')}}" class="btn btn-danger">All Article</a>
                </div>
            </div>
        </div>

        <div class="card my-2 p-4" style="background-color: #f1f2f6;">
            <div class="row">
                @foreach ($article as $a)
                <div class="col-lg-3 col-md-4 col-sm-6 mt-3">
                    <div class="card main-card">
                        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                            <img src="{{asset('image/'.$a->image)}}" class="img-fluid" />
                            <a href="{{route('articleDetail',$a->slug)}}">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                            </a>
                        </div>

                        <div class="card-body">
                            <p class="text-center title">{{$a->title}}</p>
                            <div class="d-flex justify-content-center mt-4">
                                <div class="heart  ms-3">
                                    <p class="mb-0 text-danger"><i class="fas fa-heart"></i></p>
                                    <p class="mb-0 count text-muted text-center">{{$a->like_count}}</p>
                                </div>
                                <div class="student ms-3">
                                    <p class="mb-0 text-danger"><i class="fas fa-comments"></i></p>
                                    <p class="mb-0 count text-muted text-center">{{$a->comment_count}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Main Project end -->
<!-- Footer start -->
<div class="footer">
    <p class="mb-0">© Copyright 2022. All Rights Reserved.</p>
    <div class="ms-5">
        <a href="#home" class="btn btn-danger btn-sm "> <i class="fas fa-arrow-up"></i></a>
    </div>
</div>
<!-- Footer end -->
@endsection

