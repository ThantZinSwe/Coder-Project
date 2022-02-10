@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <div class="my-2">
            <a href="" id="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="card">
            <h3 class="text-center mt-3">Create Course Video <b class="text-danger">{{$course->title}}</b> course</h3>
            <form action="{{route('course-video.store').'?course_video='.$course->slug}}" class="p-4" method="post">
                @csrf
                <div class="form-group">
                    <label for="" style="font-size: 14px">Title</label>
                    <input type="text" name="title" class="form-control" value="{{old('title')}}">

                    @if ($errors->has('title'))
                        <small class="text-danger">{{$errors->first('title')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Video URL</label>
                    <input type="text" name="video" class="form-control" value="{{old('video')}}">

                    @if ($errors->has('video'))
                        <small class="text-danger">{{$errors->first('video')}}</small>
                    @endif
                </div>

                <div>
                    <input type="submit" value="Create" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
@endsection
