<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller {
    public function showPlan() {
        $plan = Member::all();
        $enroll = '';
        $isEnroll = false;

        if ( auth()->check() ) {
            $enroll = StudentEnroll::where( 'user_id', auth()->user()->id )->orderBy( 'id', 'desc' )->first();

            if ( $enroll ) {
                $isEnroll = true;
            }

        }

        return view( 'customer.plan.index', compact( 'plan', 'enroll', 'isEnroll' ) );
    }

    public function activePlan( $slug ) {
        $plan = Member::where( 'slug', $slug )->first();

        if ( !$plan ) {
            return redirect()->back()->with( 'error', 'Something wrong!' );
        }

        return view( 'customer.plan.active_plan', compact( 'plan' ) );
    }

    public function storePlan( $slug, Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'paymentImage' => 'required',
        ), array(
            'paymentImage.required' => 'Payment image field is required.',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        if ( !auth()->check() ) {
            return redirect()->back()->with( 'fail', 'Please Login first to purchase for a plan' );
        }

        $plan = Member::where( 'slug', $slug )->first();

        $file = $request->file( 'paymentImage' );
        $file_name = uniqid() . $file->getClientOriginalName();

        StudentEnroll::create( array(
            'member_id'     => $plan->id,
            'user_id'       => auth()->user()->id,
            'payment_image' => $file_name,
            'learn_date'    => $plan->learn_date,
        ) );

        Storage::disk( 'paymentImage' )->put( $file_name, file_get_contents( $file ) );

        return redirect()->back()->with( 'success', 'Please wait about 24 hours for check your payment.' );
    }

}
