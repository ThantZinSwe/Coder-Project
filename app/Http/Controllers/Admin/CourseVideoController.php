<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CourseVideoController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $course = Course::where( 'slug', request()->course_video )->first();

        if ( $course ) {
            $courseVideo = CourseVideo::orderBy( 'id', 'desc' )->paginate( 10 );
            return view( 'admin.courseVideo.index', compact( 'courseVideo', 'course' ) );
        } else {
            abort( 404 );
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $course = Course::where( 'slug', request()->course_video )->first();

        if ( $course ) {
            return view( 'admin.courseVideo.create', compact( 'course' ) );
        } else {
            abort( 404 );
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $course = Course::where( 'slug', request()->course_video )->first();

        if ( $course ) {
            $validator = Validator::make( $request->all(), array(
                'title' => 'required',
                'video' => 'required',
            ), array(
                'title.required' => 'Need to fill title',
                'video.required' => 'Need to fill video url',
            ) );

            if ( $validator->fails() ) {
                return back()
                    ->withErrors( $validator )
                    ->withInput();
            }

            $courseVideo = $this->courseVideoData( $request, $course->id );
            CourseVideo::create( $courseVideo );
            return redirect()->route( 'course-video.index', '?course_video=' . $course->slug )->with( 'create', 'Course Video create success' );
        } else {
            abort( 404 );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $course = Course::where( 'slug', request()->course_video )->first();

        if ( $course ) {
            $courseVideo = CourseVideo::findOrFail( $id );
            return view( 'admin.courseVideo.edit', compact( 'course', 'courseVideo' ) );
        } else {
            abort( 404 );
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        $course = Course::where( 'slug', request()->course_video )->first();

        if ( $course ) {
            $validator = Validator::make( $request->all(), array(
                'title' => 'required',
                'video' => 'required',
            ), array(
                'title.required' => 'Need to fill title',
                'video.required' => 'Need to fill video url',
            ) );

            if ( $validator->fails() ) {
                return back()
                    ->withErrors( $validator )
                    ->withInput();
            }

            $courseVideo = $this->courseVideoData( $request, $course->id );
            CourseVideo::findOrFail( $id )->update( $courseVideo );
            return redirect()->route( 'course-video.index', '?course_video=' . $course->slug )->with( 'update', 'Course Video update success' );

        } else {
            abort( 404 );
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        CourseVideo::findOrFail( $id )->delete();
        return 'success';
    }

    private function courseVideoData( $request, $course_id ) {
        return array(
            'slug'      => uniqid() . Str::slug( $request->title ),
            'title'     => $request->title,
            'course_id' => $course_id,
            'video_url' => $request->video,
        );
    }

}
