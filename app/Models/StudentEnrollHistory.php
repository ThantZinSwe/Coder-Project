<?php

namespace App\Models;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrollHistory extends Model {
    use HasFactory;

    protected $fillable = array( 'member_id', 'user_id' );

    public function member() {
        return $this->belongsTo( Member::class );
    }

    public function user() {
        return $this->belongsTo( User::class );
    }
}
