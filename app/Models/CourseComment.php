<?php

namespace App\Models;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model {
    use HasFactory;

    protected $fillable = array( 'user_id', 'course_id', 'comment' );

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function course() {
        return $this->belongsTo( Course::class );
    }
}
