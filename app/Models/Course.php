<?php

namespace App\Models;

use App\Models\Category;
use App\Models\CourseComment;
use App\Models\CourseVideo;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    use HasFactory;

    protected $fillable = array( 'category_id', 'slug', 'title', 'image', 'type', 'like_count', 'description' );

    public function category() {
        return $this->belongsTo( Category::class );
    }

    public function courseVideo() {
        return $this->hasMany( CourseVideo::class );
    }

    public function language() {
        return $this->belongsToMany( Language::class, 'course_language' );
    }

    public function comment() {
        return $this->hasMany( CourseComment::class );
    }
}
