<?php

namespace App\Http\Middleware;

use App\Models\StudentEnroll;
use Closure;
use Illuminate\Http\Request;

class CheckPlan {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle( Request $request, Closure $next ) {

        if ( auth()->check() ) {
            $today = date( 'Y-m-d' );
            $enroll = StudentEnroll::where( 'user_id', auth()->user()->id )
                ->where( 'type', 'active' )
                ->orderBy( 'id', 'desc' );

            if ( $enroll->first() ) {

                if ( $today >= $enroll->first()->expire_date ) {
                    $enroll->first()->update( array(
                        'type' => 'expire',
                    ) );
                }

            }

        }

        return $next( $request );
    }

}
