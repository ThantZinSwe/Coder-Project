<?php

namespace App\Models;

use App\Models\StudentEnroll;
use App\Models\StudentEnrollHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    use HasFactory;

    protected $fillable = array( 'slug', 'title', 'description', 'learn_date', 'price' );

    public function enroll() {
        return $this->hasMany( StudentEnroll::class );
    }

    public function enrollHistory() {
        return $this->hasMany( StudentEnrollHistory::class );
    }
}
