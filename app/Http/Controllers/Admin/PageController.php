<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Course;
use App\Models\StudentEnroll;
use App\Models\User;

class PageController extends Controller {
    public function home() {
        $user_count = User::where( 'role', 'user' )->count();
        $course_count = Course::count();
        $article_count = Article::count();
        $active_count = StudentEnroll::where( 'type', 'active' )->count();

        $data = array();

        for ( $i = 1; $i <= 5; $i++ ) {
            $data[] = StudentEnroll::whereMonth( 'created_at', $i )
                ->whereYear( 'created_at', now()->format( 'Y' ) )
                ->count();
        }

        return view( 'index', compact( 'user_count', 'course_count', 'article_count', 'active_count', 'data' ) );
    }

}
