<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LanguageController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $language = Language::orderBy( 'id', 'desc' )->paginate( 10 );
        return view( 'admin.language.index', compact( 'language' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'admin.language.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'name' => 'required',
        ), array(
            'name.required' => 'Need to fill name',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $language = $this->languageData( $request );
        Language::create( $language );
        return redirect()->route( 'language.index' )->with( 'create', 'Language create success' );
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
        $language = Language::findOrFail( $id );
        return view( 'admin.language.edit', compact( 'language' ) );
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
            'name' => 'required',
        ), array(
            'name.required' => 'Need to fill name',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $language = $this->languageData( $request );
        Language::findOrFail( $id )->update( $language );
        return redirect()->route( 'language.index' )->with( 'update', 'Language update success' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        Language::findOrFail( $id )->delete();
        return 'success';
    }

    public function search( Request $request ) {
        $language = Language::where( 'name', 'like', '%' . $request->searchData . '%' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 10 );
        $language->appends( $request->all() );

        return view( 'admin.language.index', compact( 'language' ) );
    }

    private function languageData( $request ) {
        return array(
            'slug' => uniqid() . Str::slug( $request->name ),
            'name' => $request->name,
        );
    }

}
