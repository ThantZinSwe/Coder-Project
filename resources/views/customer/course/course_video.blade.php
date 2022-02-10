@extends('layout.app')
@section('content')
    <section class="main-course my-5">
        <div class="container">
            <h4 class="text-center mb-4" style="letter-spacing: 2px"><i class="fas fa-book text-success"></i> {{$video->course->title}} Course</h4>
            <div class="card p-4" style="background-color: #f1f2f6;">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-12">
                        <iframe src="{{$video->video_url}}" frameborder="0" class="w-100" height="450"></iframe>

                    </div>
                    <div class="col-md-4 col-sm-12 col-12 mt-3">
                        <ul class="list-group">
                            <a href="{{route('courseDetail',$video->course->slug)}}"><li class="list-group-item p-3">Overview</li></a>
                            @foreach ($video->course->courseVideo as $v)
                                <a href="{{route('courseVideo',$v->slug)}}">
                                    <li class="list-group-item text-muted text-center p-3">
                                        {{$v->title}}
                                        @if ($video->course->type == 'free')
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

