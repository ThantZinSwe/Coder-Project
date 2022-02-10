@extends('layout.master')
@section('css')
{{-- Select 2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--multiple {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        width: 100%;
        min-height: 45px;
        user-select: none;
        -webkit-user-select: none;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: solid black 1px;
        padding: 3px;
        outline: 0;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid mt-4">
        <div class="my-2">
            <a href="" id="back-btn"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="card">
            <h3 class="text-center mt-3">Create Course</h3>
            <form action="{{route('course.store')}}" class="p-4" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="" style="font-size: 14px">Title</label>
                    <input type="text" name="title" class="form-control" value="{{old('title')}}">

                    @if ($errors->has('title'))
                        <small class="text-danger">{{$errors->first('title')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Category</label>
                    <select name="category" class="form-control">
                        <option value=""></option>
                        @foreach ($category as $c)
                            <option value="{{$c->id}}" {{old('category') == $c->id ? 'selected' : ''}}>{{$c->name}}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('category'))
                        <small class="text-danger">{{$errors->first('category')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Language</label>
                    <select name="language[]" class="form-control" id="select2" multiple>
                        <option value=""></option>
                        @foreach ($language as $l)
                            <option value="{{$l->id}}" {{collect(old('language'))->contains($l->id) ? 'selected' : ''}}>{{$l->name}}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('language'))
                        <small class="text-danger">{{$errors->first('language')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px" class="form-check-label">Type</label><br>
                    <div class="ms-3 mt-2">
                        <input type="radio" name="type" class="form-check-control" value="free" {{old('type')=='free' ? 'checked' : ''}}> Free
                        <input type="radio" name="type" class="form-check-control" value="paid" {{old('type')=='paid' ? 'checked' : ''}}> Paid
                    </div>

                    @if ($errors->has('type'))
                        <small class="text-danger">{{$errors->first('type')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Image</label>
                    <input type="file" name="image" class="form-control"  value="{{old('image')}}" id="image">

                    <div class="preview-img mt-3">

                    </div>

                    @if ($errors->has('image'))
                        <small class="text-danger">{{$errors->first('image')}}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" style="font-size: 14px">Description</label>
                    <input type="text" name="description" class="form-control" value="{{old('description')}}">

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

@section('script')
{{-- Select 2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select2').select2();

        $('#image').on('change',function(){
            var file_length = document.getElementById('image').files.length;
            $('.preview-img').html('');

            for(var i=0; i<file_length; i++){
                $('.preview-img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" class="img-thumbnail" alt="" width="100px">`)
            }
        });
    });
</script>
@endsection
