<?php

namespace App\Models;

use App\Models\ArticleComment;
use App\Models\CourseComment;
use App\Models\StudentEnroll;
use App\Models\StudentEnrollHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = array(
        'name',
        'email',
        'password',
        'image',
        'role',
    );

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = array(
        'password',
        'remember_token',
    );

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = array(
        'email_verified_at' => 'datetime',
    );

    public function courseComment() {
        return $this->hasMany( CourseComment::class );
    }

    public function ArticleComment() {
        return $this->hasMany( ArticleComment::class );
    }

    public function enroll() {
        return $this->hasMany( StudentEnroll::class );
    }

    public function enrollHistory() {
        return $this->hasMany( StudentEnrollHistory::class );
    }
}
