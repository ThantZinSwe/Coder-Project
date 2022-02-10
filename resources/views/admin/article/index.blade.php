@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center" style="letter-spacing: 3px">Aritcle List</h2>
        <div class="d-flex my-3 justify-content-between">
            <div class="mt-3">
                <a href="{{route('article.create')}}" class="btn btn-primary btn-sm">Create</a>
            </div>

            <form action="{{route('article.search')}}" type="get" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
                <div class="form-group mb-0">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <button type="submit" class="input-group-text text-primary" style="cursor: auto"><i class="fas fa-search"></i></button>
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
                    <th>Description</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($article as $a)
                    <tr class="text-center cid-{{$a->id}}">
                        <td>{{$a->id}}</td>
                        <td>{{$a->title}}</td>
                        <td><p class="badge badge-pill badge-primary">{{$a->category->name}}</p></td>
                        <td>
                            @foreach ($a->language as $l)
                                <p class="badge badge-danger badge-pill">{{$l->name}}</p>
                            @endforeach
                        </td>
                        <td>
                            <img src="{{asset('image/'.$a->image)}}" alt="" width="100px" class="img-thumbnail">
                        </td>
                        <td class="d-inline-block text-truncate" style="max-width: 300px;">{{$a->description}}</td>
                        <td>
                            <a href="{{route("article.edit",$a->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="" class="btn btn-danger btn-sm delete_btn" data-id="{{$a->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$article->links()}}
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
                    text: "Are you sure to want to delete this article...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/admin/article/${id}`,
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
