@extends('layout.app')
@section('content')
<section class="main-article my-5">
    <div class="container">
        <div class="card p-4" style="background-color: #f1f2f6;">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-12">
                    {{-- Filter Start --}}
                        <form action="">
                            <select name="" id="" class="btn btn-default me-2 category_search">
                                <option value="">Filter By Category</option>
                                @foreach ($category as $c)
                                <option value="{{$c->slug}}">{{$c->name}}</option>
                                @endforeach
                            </select>

                            <select name="" id="" class="btn btn-default me-2 mt-2 language_search">
                                <option value="">Filter By Language</option>
                                @foreach ($language as $l)
                                <option value="{{$l->slug}}">{{$l->name}}</option>
                                @endforeach
                            </select>

                            <input type="text" name="" id="" class="filter-text me-2" placeholder="Enter Article Title"/>

                            <input type="submit" value="Filter" class="btn btn-danger btn-sm filter_btn">
                        </form>
                    {{-- Filter End --}}
                        <div class="articleList"></div>
                </div>
                {{-- List Start --}}
                <div class="col-md-4 col-sm-12 col-12 mt-3">
                    <div class="card " style="background-color: #f1f2f6;">
                        <div class="card-body">
                            <h5 class="text-center text-muted">Categories</h5>
                            @foreach ($category as $c)
                                <button class="mt-1 badge badge-danger category border-0" data-category-slug="{{$c->slug}}">{{$c->name}}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="card mt-3" style="background-color: #f1f2f6;">
                        <div class="card-body">
                            <h5 class="text-center text-muted">Languages</h5>
                            @foreach ($language as $l)
                                <button class="mt-1 badge badge-danger language border-0" data-language-slug="{{$l->slug}}">{{$l->name}}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- List End --}}
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
    <script>
        $(function($){
            articleSearch();

            function articleSearch(){
                var category = $('.category_search').val();
                var language = $('.language_search').val();
                var text = $('.filter-text').val();

                $.ajax({
                    url: `/article-list?category=${category}&language=${language}&text=${text}`,
                    type:'GET',
                    success:function(res){
                        console.log(res);
                        $('.articleList').html(res);
                    }
                });

                $('.filter_btn').on('click',function(e){
                    e.preventDefault();
                    articleSearch();
                });

            }

             $('.category').on('click',function(){
                var category_slug = $(this).data('category-slug');
                console.log(category_slug);
                $.ajax({
                    url: `/article-list?category=${category_slug}`,
                    type:'GET',
                    success:function(res){
                        $('.articleList').html(res);
                    }
                });
            });

            $('.language').on('click',function(){
                var language_slug = $(this).data('language-slug');
                console.log(language_slug);
                $.ajax({
                    url: `/article-list?language=${language_slug}`,
                    type:'GET',
                    success:function(res){
                        $('.articleList').html(res);
                    }
                });
            });

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
