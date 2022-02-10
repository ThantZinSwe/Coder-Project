<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CourseController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $course = Course::with( 'category', 'language' )->orderBy( 'id', 'desc' )->paginate( 10 );
        return view( 'admin.course.index', compact( 'course' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $category = Category::get();
        $language = Language::get();
        return view( 'admin.course.create', compact( 'category', 'language' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'title'       => 'required',
            'category'    => 'required',
            'language'    => 'required',
            'type'        => 'required',
            'image'       => 'required',
            'description' => 'required',
        ), array(
            'title.required'       => 'Need to fill title',
            'category.required'    => 'Need to fill category',
            'language.required'    => 'Need to fill language',
            'type.required'        => 'Need to fill type',
            'image.required'       => 'Need to fill image',
            'description.required' => 'Need to fill description',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $file = $request->file( 'image' );
        $fileName = uniqid() . $file->getClientOriginalName();
        Storage::disk( 'courseImage' )->put( $fileName, file_get_contents( $file ) );

        $data = $this->courseData( $request, $fileName );
        $course = Course::create( $data );
        $course->language()->sync( $request->language );
        return redirect()->route( 'course.index' )->with( 'create', 'Course create success' );
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
        $course = Course::findOrFail( $id );
        $category = Category::get();
        $language = Language::get();

        return view( 'admin.course.edit', compact( 'course', 'category', 'language' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        $validator = Validator::make( $request->all(), array(
            'title'       => 'required',
            'category'    => 'required',
            'language'    => 'required',
            'type'        => 'required',
            'description' => 'required',
        ), array(
            'title.required'       => 'Need to fill title',
            'category.required'    => 'Need to fill category',
            'language.required'    => 'Need to fill language',
            'type.required'        => 'Need to fill type',
            'description.required' => 'Need to fill description',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $course = Course::findOrFail( $id );

        if ( isset( $request->image ) ) {
            $file = $request->file( 'image' );
            $fileName = $file->getClientOriginalName();
            Storage::disk( 'courseImage' )->delete( $course->image );
            Storage::disk( 'courseImage' )->put( $fileName, file_get_contents( $file ) );
        } else {
            $fileName = $course->image;
        }

        $data = $this->courseData( $request, $fileName );
        $course->update( $data );
        $course->language()->sync( $request->language );

        return redirect()->route( 'course.index' )->with( 'update', 'Course update success' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $course = Course::findOrFail( $id );
        Storage::disk( 'courseImage' )->delete( $course->image );
        $course->delete();
        $course->language()->detach();

        return 'success';
    }

    public function search( Request $request ) {
        $search = $request->searchData;
        $course = Course::with( 'category', 'language' )
            ->orWhereHas( 'category', function ( $q ) use ( $search ) {
                $q->where( 'name', 'like', '%' . $search . '%' );
            } )
            ->orWhereHas( 'language', function ( $q ) use ( $search ) {
                $q->where( 'name', 'like', '%' . $search . '%' );
            } )
            ->orWhere( 'title', 'like', '%' . $search . '%' )
            ->orWhere( 'type', 'like', '%' . $search . '%' )
            ->orWhere( 'description', 'like', '%' . $search . '%' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 10 );
        $course->appends( $request->all() );

        return view( 'admin.course.index', compact( 'course' ) );
    }

    private function courseData( $request, $fileName ) {
        return array(
            'title'       => $request->title,
            'category_id' => $request->category,
            'slug'        => Str::slug( $request->title ),
            'image'       => $fileName,
            'type'        => $request->type,
            'description' => $request->description,
            'like_count'  => 0,
        );
    }

}
