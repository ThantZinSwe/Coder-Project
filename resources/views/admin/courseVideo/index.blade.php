@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center" style="letter-spacing: 3px">Course Video List</h2>
        <div class="d-flex my-3 justify-content-between">
            <div class="mt-3">
                <a href="{{route('course-video.create').'?course_video='.$course->slug}}" class="btn btn-primary btn-sm">Create</a>
                <a href="{{route('course.index')}}" class="btn btn-danger btn-sm">Course</a>
            </div>

            <form action="" type="get" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
                <div class="form-group mb-0">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <button type="submit" class="input-group-text text-primary"><i class="fas fa-search"></i></button>
                    </div>
                    <input class="form-control text-primary" placeholder="Search" type="text" name="searchData" value="{{request('searchData')}}">
                  </div>
                </div>
            </form>
        </div>
        <p>Mange Video for <b class="text-danger">{{$course->title}}</b> course</p>
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Video URL</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courseVideo as $c)
                    @if ($c->course_id == $course->id)
                        <tr class="text-center cid-{{$c->id}}">
                            <td>{{$c->id}}</td>
                            <td>{{$c->title}}</td>
                            <td>{{$c->video_url}}</td>
                            <td>
                                <a href="{{route("course-video.edit",$c->id).'?course_video='.$course->slug}}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="" class="btn btn-danger btn-sm delete_btn" data-id="{{$c->id}}">Delete</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        {{$courseVideo->links()}}
    </div>
@endsection
@section('script')
    <script>
        $(function($){
            @if(session('create'))
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Created',
                    text: "{{ session('create') }}",
                });
            @endif

            @if(session('update'))
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Updated',
                    text: "{{ session('update') }}",
                });
            @endif

            $(document).on('click','.delete_btn',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                    text: "Are you sure to want to delete this course video...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/admin/course-video/${id}`,
                        })
                        .done(function( res ) {
                            $(".cid-"+id).remove();
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })
        });
    </script>
@endsection
