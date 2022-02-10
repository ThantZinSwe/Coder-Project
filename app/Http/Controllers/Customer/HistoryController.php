<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\StudentEnroll;

class HistoryController extends Controller {
    public function history() {
        $enroll = StudentEnroll::where( 'user_id', auth()->user()->id )
            ->with( 'user', 'member' )
            ->orderBy( 'id', 'desc' );

        if ( request()->type ) {
            $enroll->where( 'type', request()->type );
        }

        $enroll = $enroll->paginate( 10 );

        return view( 'customer.history', compact( 'enroll' ) );
    }

}
