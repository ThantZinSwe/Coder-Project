@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center" style="letter-spacing: 3px">Member List</h2>
        <div class="d-flex my-3 justify-content-between">
            <div class="mt-3">
                <a href="{{route('member.create')}}" class="btn btn-primary btn-sm">Create</a>
            </div>

            <form action="{{route('member.search')}}" type="get" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
                <div class="form-group mb-0">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-primary"><i class="fas fa-search"></i></span>
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
                    <th>Price</th>
                    <th>Learn Date</th>
                    <th>Description</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member as $m)
                    <tr class="text-center mid-{{$m->id}}">
                        <td>{{$m->id}}</td>
                        <td>{{$m->title}}</td>
                        <td>{{$m->price}} Kyats</td>
                        <td>{{$m->learn_date}} days</td>
                        <td>{{$m->description}}</td>
                        <td>
                            <a href="{{route("member.edit",$m->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="" class="btn btn-danger btn-sm delete_btn" data-id="{{$m->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$member->links()}}
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
                    text: "Are you sure to want to delete this member...?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/admin/member/${id}`,
                        })
                        .done(function( res ) {
                            $(".mid-"+id).remove();
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
            })
        });
    </script>
@endsection
