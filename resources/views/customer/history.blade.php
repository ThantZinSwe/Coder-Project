@extends('layout.app')
@section('content')
    <section class="history">
        <div class="container mt-4">
            <div class="card" style="background-color: #f1f2f6;">
                <h5 class="text-center my-3" style="letter-spacing: 1px"><i class="fas fa-history"></i> History</h5>
                <div class="mb-3 p-1">
                    <a href="{{route('history')}}" class="btn btn-primary btn-sm">All</a>
                    <a href="{{route('history').'?type=pending'}}" class="btn btn-primary btn-sm">Pending</a>
                    <a href="{{route('history').'?type=active'}}" class="btn btn-primary btn-sm">Active</a>
                    <a href="{{route('history').'?type=expire'}}" class="btn btn-primary btn-sm">Expire</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Membership Plan</th>
                            <th>Start Date</th>
                            <th>Expire Date</th>
                            <th>Remian Learn Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (auth()->check())
                        @foreach ($enroll as $k=>$e)
                            <tr class="text-center">
                                <td>{{$k+1}}</td>
                                <td>{{$e->member->title}}</td>
                                <td>{{$e->start_date}}</td>
                                <td>{{$e->expire_date}}</td>
                                <td>
                                    {{Illuminate\Support\Carbon::parse(date('Y-m-d'))->diffInDays($e->expire_date)}}
                                </td>
                                <td>
                                    @if ($e->type == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif ($e->type == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Expire</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                {{$enroll->links()}}
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
