@extends('layout.app')
@section('content')
    <section class="main-article my-5">
        <div class="container">
            <div class="card p-4" style="background-color: #f1f2f6;">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-12">
                        <img src="{{asset('image/'.$article->image)}}" class="w-100" alt="">

                        <div class="card p-2 mt-3">
                            <h4 class="mt-2">{{$article->title}}</h4>

                            <div class="d-flex justify-content-center mt-2 mb-3">
                                <button class="btn btn-sm btn-danger me-2 like">
                                    <i class="fas fa-heart"></i>
                                    <br>
                                    <span class="badge bg-default">{{$article->like_count}}</span>
                                </button>

                                <a href="#comment" class="btn btn-sm btn-danger me-2">
                                    <i class="fas fa-comments"></i>
                                    <br>
                                    <span class="badge bg-default">{{$article->comment_count}}</span>
                                </a>
                            </div>

                            <div class="card mb-3 p-3" style="background-color: #f1f2f6;">
                                <p class="mb-0 lh-lg">{{$article->description}}</p>
                            </div>

                            @auth
                            <div class="mt-2 comment-box">
                                <h4 class="mb-3" id="comment">Comments</h4>

                                <textarea class="form-control" id="comment_txt"></textarea>
                                <button class="btn btn-sm btn-danger mt-3 " id="comment_btn">Create Comment</button>

                                <ul class="list-group mt-3 p-2">
                                    @foreach ($article->comment as $k=>$c)
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
                        <div class="card " style="background-color: #f1f2f6;">
                            <div class="card-body">
                                <h5 class="text-center text-muted mb-3">Category and Language</h5>
                                <small class="badge badge-primary ms-1">{{$article->category->name}}</small>
                                @foreach ($article->language as $l)
                                    <small class="badge badge-danger ms-1"> {{ $l->name}} </small>
                                @endforeach
                            </div>
                        </div>
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
                var slug = "{{$article->slug}}";
                $.ajax({
                    url: `/article-comment`,
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
                var slug = "{{$article->slug}}";

                $.ajax({
                    url: `/article-like-count?slug=${slug}`,
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

