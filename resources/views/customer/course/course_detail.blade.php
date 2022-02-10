@extends('layout.app')
@section('content')
    <section class="main-course my-5">
        <div class="container">
            <div class="card p-4" style="background-color: #f1f2f6;">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-12">
                        <img src="{{asset('courseImage/'.$course->image)}}" class="w-100" alt="">

                        <div class="card p-2 mt-3">
                            <h4 class="mt-2">{{$course->title}}</h4>

                            <div class="d-flex justify-content-center mt-2 mb-3">
                                <button class="btn btn-sm btn-danger me-2 like">
                                    <i class="fas fa-heart"></i>
                                    <br>
                                    <span class="badge bg-default">{{$course->like_count}}</span>
                                </button>

                                <a href="#comment" class="btn btn-sm btn-danger me-2">
                                    <i class="fas fa-comments"></i>
                                    <br>
                                    <span class="badge bg-default">{{$course->comment_count}}</span>
                                </a>
                            </div>

                            <div class=" d-flex justify-content-center mb-4 mt-2">
                                <small class="fw-bold ">
                                Language:</small>
                                @foreach ($course->language as $l)
                                <small class="badge badge-danger ms-1"> {{ $l->name}} </small>
                                @endforeach

                                <small class="fw-bold ms-2">
                                    Category:</small>
                                <small class="badge badge-danger ms-1">{{$course->category->name}}</small>
                            </div>

                            <div class="card mb-3 p-3" style="background-color: #f1f2f6;">
                                <p class="mb-0">{{$course->description}}</p>
                            </div>

                            @auth
                            <div class="mt-2 comment-box">
                                <h4 class="mb-3" id="comment">Comments</h4>

                                <textarea class="form-control" id="comment_txt"></textarea>
                                <button class="btn btn-sm btn-danger mt-3 " id="comment_btn">Create Comment</button>

                                <ul class="list-group mt-3 p-2">
                                    @foreach ($course->comment as $k=>$c)
                                        <li class="list-group-item">
                                            <b>{{$k+1}}. {{$c->user->name}}</b>
                                            <p>{{$c->comment}} <small class="text-muted"> {{$c->created_at->diffForHumans()}}</small></p>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item">

                                    </li>
                                </ul>
                            </div>
                            @endauth

                            @guest
                                <div class="mt-2">
                                    <p>Please <a href="{{url('/login')}}" class="btn btn-danger btn-sm">Login</a> to create review...</p>
                                </div>
                            @endguest

                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-12 mt-3">
                        <ul class="list-group">
                            <a href="{{route('courseDetail',$course->slug)}}"><li class="list-group-item p-3">Overview</li></a>
                            @foreach ($course->courseVideo as $v)
                                <a href="{{route('courseVideo',$v->slug)}}">
                                    <li class="list-group-item text-muted text-center p-3">
                                        {{$v->title}}
                                        @if ($course->type == 'free')
                                        <i class="fas fa-unlock text-success"></i>
                                        @elseif ($isActive)
                                        <i class="fas fa-unlock text-success"></i>
                                        @else
                                        <i class="fas fa-lock text-danger"></i>
                                        @endif
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(function($){

            $('#comment_btn').on('click',function(e){
                e.preventDefault();
                var txtComment = $('#comment_txt').val();
                var slug = "{{$course->slug}}";
                $.ajax({
                    url: `/course-comment`,
                    type:'POST',
                    data:{'txtComment':txtComment , 'slug':slug},
                    success:function(res){
                        $('.comment-box ul').prepend(`<li class="list-group-item"><b>
                            @if (auth()->check())
                            {{auth()->user()->name}}
                            @endif</b>
                            <p>${txtComment} <small class="text-muted">1 second ago</small></p>
                        </li>`)
                    }
                });
            });

            $('.like').on('click',function(){
                var slug = "{{$course->slug}}";

                $.ajax({
                    url: `/course-like-count?slug=${slug}`,
                    type: 'GET',
                    success:function(res){
                        if(res.status == 'fail'){
                            Toast.fire({
                            icon: 'error',
                            title: res.message,
                            });
                        }
                        $('.like span').text(res.data);
                    }
                });
            });


            @if(session('error')){
                    Toast.fire({
                    icon: 'error',
                    title: "{{session('error')}}"
                    })
                }
            @endif
        });
    </script>
@endsection

