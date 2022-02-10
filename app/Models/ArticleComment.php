<?php

namespace App\Models;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model {
    use HasFactory;

    protected $fillable = array( 'user_id', 'article_id', 'comment' );

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function article() {
        return $this->belongsTo( Article::class );
    }
}
