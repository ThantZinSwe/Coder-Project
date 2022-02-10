@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-center" style="letter-spacing: 3px">Student-Enroll List</h2>
        <div class="d-flex my-3 justify-content-between list">
            <div class="mt-3">
                <a href="{{route('enroll.index')}}" class="btn btn-primary btn-sm me-2">All</a>
                <a href="{{route('enroll.index').'?type=pending'}}" class="btn btn-primary btn-sm me-2">Pending</a>
                <a href="{{route('enroll.index').'?type=active'}}" class="btn btn-primary btn-sm me-2">Active</a>
                <a href="{{route('enroll.index').'?type=expire'}}" class="btn btn-primary btn-sm me-2">Expire</a>
            </div>

            <form action="{{route('enroll.search')}}" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto search">
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
                    <th>Membership Plan</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Payment Image</th>
                    <th>Learn Date</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enroll as $e)
                    <tr class="text-center lid-{{$e->id}}">
                        <td>{{$e->id}}</td>
                        <td>{{$e->member->title}}</td>
                        <td>{{$e->user->name}}</td>
                        <td>
                            @if ($e->type == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif ($e->type == 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Expire</span>
                            @endif

                        </td>
                        <td><img src="{{asset('paymentImage/'.$e->payment_image)}}" alt="" width="100px" class="img-thumbnail"></td>
                        <td>{{$e->learn_date}}</td>
                        <td>
                            @if ($e->type == 'pending' )
                            <a href="{{route('enroll.active',$e->id)}}" class="btn btn-success btn-sm">Set Active</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$enroll->links()}}
    </div>
@endsection
@section('script')
    <script>
        $(function($){
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Created',
                    text: "{{ session('success') }}",
                });
            @endif
        });
    </script>
@endsection
