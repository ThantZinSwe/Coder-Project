@extends('layout.master')
@section('content')
    <div class="container-fluid mt-4">
        <div class="my-2">
            <a href="" id="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="card">
            <h3 class="text-center mt-3">Edit Category</h3>
            <form action="{{route('category.update',$category->id)}}" class="p-4" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="" style="font-size: 14px">Name</label>
                    <input type="text" name="name" class="form-control" value="{{old('name',$category->name)}}">

                    @if ($errors->has('name'))
                        <small class="text-danger">{{$errors->first('name')}}</small>
                    @endif
                </div>

                <div>
                    <input type="submit" value="Create" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
@endsection
