<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $article = Article::with( 'category', 'language' )->orderBy( 'id', 'desc' )->paginate( 10 );
        // return $article;
        return view( 'admin.article.index', compact( 'article' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $category = Category::get();
        $language = Language::get();
        return view( 'admin.article.create', compact( 'category', 'language' ) );
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
            'image'       => 'required',
            'description' => 'required',
        ), array(
            'title.required'       => 'Need to fill title',
            'category.required'    => 'Need to fill category',
            'language.required'    => 'Need to fill language',
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
        Storage::disk( 'image' )->put( $fileName, file_get_contents( $file ) );

        $data = $this->articleData( $request, $fileName );

        $article = Article::create( $data );
        $article->language()->sync( $request->language );
        return redirect()->route( 'article.index' )->with( 'create', 'Article create success' );
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
        $article = Article::findOrFail( $id );
        $category = Category::get();
        $language = Language::get();
        return view( 'admin.article.edit', compact( 'article', 'category', 'language' ) );
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
            'description' => 'required',
        ), array(
            'title.required'       => 'Need to fill title',
            'category.required'    => 'Need to fill category',
            'language.required'    => 'Need to fill language',
            'description.required' => 'Need to fill description',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $article = Article::findOrFail( $id );

        if ( isset( $request->image ) ) {
            $file = $request->file( 'image' );
            $fileName = uniqid() . $file->getClientOriginalName();
            Storage::disk( 'image' )->delete( $article->image );
            Storage::disk( 'image' )->put( $fileName, file_get_contents( $file ) );
        } else {
            $fileName = $article->image;
        }

        $data = $this->articleData( $request, $fileName );
        $article->update( $data );
        $article->language()->sync( $request->language );

        return redirect()->route( 'article.index' )->with( 'update', 'Article update success' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $article = Article::findOrFail( $id );
        Storage::disk( 'image' )->delete( $article->image );
        $article->delete();
        $article->language()->detach();
        return 'success';
    }

    public function search( Request $request ) {
        $search = $request->searchData;
        $article = Article::with( 'category', 'language' )
            ->orWhereHas( 'category', function ( $q ) use ( $search ) {
                $q->where( 'name', 'like', '%' . $search . '%' );
            } )
            ->orWhereHas( 'language', function ( $q ) use ( $search ) {
                $q->where( 'name', 'like', '%' . $search . '%' );
            } )
            ->orwhere( 'title', 'like', '%' . $search . '%' )
            ->orWhere( 'description', 'like', '%' . $search . '%' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 10 );
        $article->appends( $request->all() );

        return view( 'admin.article.index', compact( 'article' ) );
    }

    private function articleData( $request, $fileName ) {
        return array(
            'title'       => $request->title,
            'category_id' => $request->category,
            'slug'        => uniqid() . Str::slug( $request->title ),
            'image'       => $fileName,
            'like_count'  => 0,
            'description' => $request->description,
        );
    }

}
