@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center" style="letter-spacing: 3px">Language List</h2>
        <div class="d-flex my-3 justify-content-between list">
            <div class="mt-3">
                <a href="{{route('language.create')}}" class="btn btn-primary btn-sm">Create</a>
            </div>

            <form action="{{route('language.search')}}" type="get" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto search">
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
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($language as $l)
                    <tr class="text-center lid-{{$l->id}}">
                        <td>{{$l->id}}</td>
                        <td>{{$l->slug}}</td>
                        <td>{{$l->name}}</td>
                        <td>
                            <a href="{{route("language.edit",$l->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="" class="btn btn-danger btn-sm delete_btn" data-id="{{$l->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$language->links()}}
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
                    text: "Are you sure to want to delete this language...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/admin/language/${id}`,
                        })
                        .done(function( res ) {
                            $(".lid-"+id).remove();
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })
        });
    </script>
@endsection
