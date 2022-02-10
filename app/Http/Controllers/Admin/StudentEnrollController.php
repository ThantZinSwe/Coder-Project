<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudentEnrollController extends Controller {
    public function index() {
        $enroll = StudentEnroll::with( 'user', 'member' );

        if ( request()->type ) {
            $enroll->where( 'type', request()->type );
        }

        $enroll = $enroll->orderBy( 'id', 'desc' )->paginate( 10 );

        return view( 'admin.enroll.index', compact( 'enroll' ) );
    }

    public function search( Request $request ) {
        $search = $request->searchData;
        $enroll = StudentEnroll::with( 'user', 'member' )
            ->orWhereHas( 'user', function ( $q ) use ( $search ) {
                $q->where( 'name', 'like', '%' . $search . '%' );
            } )
            ->orWhereHas( 'member', function ( $q ) use ( $search ) {
                $q->where( 'title', 'like', '%' . $search . '%' );
            } )
            ->orWhere( 'learn_date', 'like', '%' . $search . '%' )
            ->orWhere( 'type', 'like', '%' . $search . '%' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 10 );
        $enroll->appends( $request->all() );

        return view( 'admin.enroll.index', compact( 'enroll' ) );
    }

    public function enrollActive( $id ) {
        $enroll = StudentEnroll::where( 'id', $id )->first();
        $learn_date = $enroll->learn_date;
        $start_date = date( 'Y-m-d' );
        $expire_date = Carbon::parse( $start_date )->addDays( $learn_date )->format( 'Y-m-d' );

        $enroll->update( array(
            'type'        => 'active',
            'start_date'  => $start_date,
            'expire_date' => $expire_date,
        ) );

        return redirect()->route( 'enroll.index' )->with( 'success', 'Active success!' );
    }

}
