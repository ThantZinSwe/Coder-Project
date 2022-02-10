<?php

namespace App\Models;

use App\Models\Article;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model {
    use HasFactory;

    protected $fillable = array( 'slug', 'name' );

    public function course() {
        return $this->belongsToMany( Course::class, 'course_language' );
    }

    public function article() {
        return $this->belongsToMany( Article::class, 'article_language' );
    }
}
