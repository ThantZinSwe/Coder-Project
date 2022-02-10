<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Course;

class PageController extends Controller {
    public function index() {
        $course = Course::withCount( 'courseVideo as video_count', 'comment as comment_count' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 8 );

        $article = Article::withCount( 'comment as comment_count' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 8 );
        return view( 'customer.index', compact( 'course', 'article' ) );
    }
}
