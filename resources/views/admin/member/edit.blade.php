@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <div class="my-2">
            <a href="" id="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="card">
            <h3 class="text-center mt-3">Edit Member</h3>
            <form action="{{route('member.update',$member->id)}}" class="p-4" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="" style="font-size: 14px">Title</label>
                    <input type="text" name="title" class="form-control" value="{{old('title',$member->title)}}">

                    @if ($errors->has('title'))
                        <small class="text-danger">{{$errors->first('title')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Price</label>
                    <input type="number" name="price" class="form-control" value="{{old('price',$member->price)}}">

                    @if ($errors->has('price'))
                        <small class="text-danger">{{$errors->first('price')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Learn Date</label>
                    <input type="text" name="learn_date" class="form-control" value="{{old('learn_date',$member->learn_date)}}">

                    @if ($errors->has('learn_date'))
                        <small class="text-danger">{{$errors->first('learn_date')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Description</label>
                    <input type="text" name="description" class="form-control" value="{{old('description',$member->description)}}">

                    @if ($errors->has('description'))
                        <small class="text-danger">{{$errors->first('description')}}</small>
                    @endif
                </div>

                <div>
                    <input type="submit" value="Create" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
@endsection
