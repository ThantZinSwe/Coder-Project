<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;

class ArticleController extends Controller {
    public function allArticle() {

        if ( request()->category || request()->language || request()->type ) {
            return redirect()->back()->with( 'error', 'Something wrong!' );
        }

        return view( 'customer.article.all_article' );
    }

    public function articleList() {
        $article = Article::withCount( 'comment as comment_count' )
            ->orderBy( 'id', 'desc' );

        if ( $category_slug = request()->category ) {
            $category = Category::where( 'slug', $category_slug )->first();

            if ( !$category ) {
                return redirect()->back()->with( 'error', 'Your search category is not found!' );
            }

            $article->where( 'category_id', $category->id );
        }

        if ( $language_slug = request()->language ) {
            $language = Language::where( 'slug', $language_slug )->first();

            if ( !$language ) {
                return redirect()->back()->with( 'error', 'Your search language is not found!' );
            }

            $article->whereHas( 'language', function ( $q ) use ( $language ) {
                $q->where( 'article_language.language_id', $language->id );
            } );
        }

        if ( $text = request()->text ) {
            $article->where( 'title', 'like', '%' . $text . '%' );
        }

        $article = $article->paginate( 10 );
        return view( 'customer.article.components.articleList', compact( 'article' ) )->render();
    }

    public function articleDetail( $slug ) {
        $article = Article::where( 'slug', $slug )
            ->with( 'comment.user', 'language', 'category' )
            ->withCount( 'comment as comment_count' )
            ->first();

        if ( !$article ) {
            return redirect()->back()->with( 'error', 'Article not found!' );
        }

        return view( 'customer.article.article_detail', compact( 'article' ) );
    }

    public function storeComment( Request $request ) {
        $article = Article::where( 'slug', $request->slug )->first();

        if ( !$article ) {
            return redirect()->back()->with( 'error', 'Article not found!' );
        }

        $article_comment = ArticleComment::create( array(
            'user_id'    => auth()->user()->id,
            'article_id' => $article->id,
            'comment'    => $request->txtComment,
        ) );

        return response()->json( array( 'data' => $article_comment ) );
    }

    public function storeLikeCount( Request $request ) {
        $article = Article::where( 'slug', $request->slug )->first();

        if ( !auth()->check() ) {
            return array(
                'status'  => 'fail',
                'message' => 'Please login first!',
            );
        }

        if ( !$article ) {
            return redirect()->back()->with( 'error', 'Article not found!' );
        }

        $article->update( array(
            'like_count' => $article->like_count + 1,
        ) );
        return response()->json( array('data' => $article->like_count) );
    }

}
