<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseComment;
use App\Models\CourseVideo;
use App\Models\Language;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;

class CourseController extends Controller {
    public function allCourse() {

        if ( request()->category || request()->language || request()->type ) {
            return redirect()->back()->with( 'error', 'Something wrong!' );
        }

        return view( 'customer.course.all_course' );
    }

    public function courseList() {
        $course = Course::withCount( 'courseVideo as video_count', 'comment as comment_count' )
            ->orderBy( 'id', 'desc' );

        if ( $type = request()->type ) {
            $course->where( 'type', $type );
        }

        if ( $category_slug = request()->category ) {
            $category = Category::where( 'slug', $category_slug )->first();

            if ( !$category ) {
                return redirect()->back()->with( 'error', 'Your search category is not found!' );
            }

            $course->where( 'category_id', $category->id );
        }

        if ( $language_slug = request()->language ) {
            $language = Language::where( 'slug', $language_slug )->first();

            if ( !$language ) {
                return redirect()->back()->with( 'error', 'Your search language is not found' );
            }

            $course->whereHas( 'language', function ( $q ) use ( $language ) {
                $q->where( 'course_language.language_id', $language->id );
            } );

        }

        if ( $text = request()->text ) {
            $course->where( 'title', 'like', "%$text%" );
        }

        $course = $course->paginate( 8 );
        return view( 'customer.course.components.courseList', compact( 'course' ) )->render();
    }

    public function courseDetail( $slug ) {

        $isActive = false;

        if ( auth()->check() ) {
            $checkPlan = StudentEnroll::where( 'user_id', auth()->user()->id )->orderBy( 'id', 'desc' )->first();

            if ( $checkPlan ) {

                if ( $checkPlan->type == 'active' ) {
                    $isActive = true;
                }

            }

        }

        $course = Course::where( 'slug', $slug )
            ->with( 'courseVideo', 'comment.user', 'language', 'category' )
            ->withCount( 'comment as comment_count' )
            ->first();

        if ( !$course ) {
            return redirect()->back()->with( 'error', 'Course not found!' );
        }

        return view( 'customer.course.course_detail', compact( 'course', 'isActive' ) );
    }

    public function courseVideo( $slug ) {
        $video = CourseVideo::where( 'slug', $slug )
            ->with( 'course.courseVideo' )
            ->first();

        if ( !$video ) {
            return redirect()->back()->with( 'error', 'Something wrong' );
        }

        $isActive = false;

        if ( auth()->check() ) {
            $checkPlan = StudentEnroll::where( 'user_id', auth()->user()->id )->orderBy( 'id', 'desc' )->first();

            if ( $checkPlan ) {

                if ( $checkPlan->type == 'active' ) {
                    $isActive = true;
                }

            }

        }

        if ( $video->course->type == 'free' ) {
            $isActive = true;
        }

        if ( !$isActive ) {
            return redirect()->route( 'showPlan' )->with( 'error', 'Please active one plan!' );
        }

        return view( 'customer.course.course_video', compact( 'video', 'isActive' ) );
    }

    public function storeComment( Request $request ) {
        $course = Course::where( 'slug', $request->slug )->first();

        if ( !$course ) {
            return redirect()->back()->with( 'error', 'Course not found!' );
        }

        $course_comment = CourseComment::create( array(
            'user_id'   => auth()->user()->id,
            'course_id' => $course->id,
            'comment'   => $request->txtComment,
        ) );

        return response()->json( array( 'data' => $course_comment ) );

    }

    public function storeLikeCount( Request $request ) {
        $course = Course::where( 'slug', $request->slug )->first();

        if ( !auth()->check() ) {
            return array(
                'status'  => 'fail',
                'message' => 'Please login first.',
            );
        }

        if ( !$course ) {
            return redirect()->back()->with( 'error', 'Course not found!' );
        }

        $course->update( array(
            'like_count' => $course->like_count + 1,
        ) );

        return response()->json( array( 'data' => $course->like_count ) );

    }

}
