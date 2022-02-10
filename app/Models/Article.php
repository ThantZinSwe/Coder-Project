<?php

namespace App\Models;

use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    use HasFactory;

    protected $fillable = array( 'category_id', 'slug', 'title', 'image', 'like_count', 'description' );

    public function category() {
        return $this->belongsTo( Category::class );
    }

    public function language() {
        return $this->belongsToMany( Language::class, 'article_language' );
    }

    public function comment() {
        return $this->hasMany( ArticleComment::class );
    }
}
