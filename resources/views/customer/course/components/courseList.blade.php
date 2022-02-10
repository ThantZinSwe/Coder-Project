<div class="row mt-3">
    @foreach ($course as $c)
    <div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
        <div class="card main-card">
            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                <img src="{{asset('courseImage/'.$c->image)}}" class="img-fluid" />
                <a href="{{route('courseDetail',$c->slug)}}">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>
            </div>

            <div class="card-body">
                <p class="text-center title">{{$c->title}}</p>
                <div class="d-flex justify-content-between mt-4">
                    <div class="heart">
                        <a href=""><i class="fas fa-heart"></i></a>
                        <p class="mb-0 count text-muted text-center">{{$c->like_count}}</p>
                    </div>
                    <div class="video">
                        <a href=""><i class="fas fa-play-circle"></i></a>
                        <p class="mb-0 count text-muted text-center">{{$c->video_count}}</p>
                    </div>
                    <div class="student">
                        <a href=""><i class="fas fa-comments"></i></a>
                        <p class="mb-0 count text-muted text-center">{{$c->comment_count}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
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
        })
    </script>
@endsection
