@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center" style="letter-spacing: 3px">Course List</h2>
        <div class="d-flex my-3 justify-content-between list">
            <div class="mt-3">
                <a href="{{route('course.create')}}" class="btn btn-primary btn-sm">Create</a>
            </div>

            <form action="{{route('course.search')}}" type="get" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto search">
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
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Language</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course as $c)
                    <tr class="text-center cid-{{$c->id}}">
                        <td>{{$c->id}}</td>
                        <td>{{$c->title}}</td>
                        <td>
                            <p class="badge badge-secondary badge-pill text-primary">{{$c->category->name}}</p>
                        </td>
                        <td>
                            @foreach ($c->language as $cl)
                                <p class="badge badge-secondary badge-pill text-primary">{{$cl->name}}</p>
                            @endforeach
                        </td>
                        <td>
                            <img src="{{asset('courseImage/'.$c->image)}}" alt="" width="100px" class="img-thumbnail">
                        </td>
                        <td>
                            @if ($c->type == 'free')
                                <p class="badge badge-success badge-pill">{{$c->type}}</p>
                            @else
                                <p class="badge badge-danger badge-pill">{{$c->type}}</p>
                            @endif
                        </td>
                        <td class="d-inline-block text-truncate" style="max-width: 300px;">{{$c->description}}</td>
                        <td>
                            <a href="{{route('course-video.index').'?course_video='.$c->slug}}" class="btn btn-warning btn-sm">Manged Video</a>
                            <a href="{{route("course.edit",$c->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="" class="btn btn-danger btn-sm delete_btn" data-id="{{$c->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$course->links()}}
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
                    text: "Are you sure to want to delete this course...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/admin/course/${id}`,
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
