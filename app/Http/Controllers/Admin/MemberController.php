<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MemberController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $member = Member::orderBy( 'id', 'desc' )->paginate( 10 );
        return view( 'admin.member.index', compact( 'member' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'admin.member.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'title'       => 'required',
            'price'       => 'required',
            'learn_date'  => 'required',
            'description' => 'required',
        ), array(
            'title.required'       => 'Need to fill name',
            'price.required'       => 'Need to fill price',
            'learn_date.required'  => 'Need to fill learn date',
            'description.required' => 'Need to fill description',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $member = $this->memberData( $request );
        Member::create( $member );
        return redirect()->route( 'member.index' )->with( 'create', 'Member create success' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $member = Member::findOrFail( $id );
        return view( 'admin.member.edit', compact( 'member' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id ) {
        $validator = Validator::make( $request->all(), array(
            'title'       => 'required',
            'price'       => 'required',
            'learn_date'  => 'required',
            'description' => 'required',
        ), array(
            'title.required'       => 'Need to fill name',
            'price.required'       => 'Need to fill price',
            'learn_date.required'  => 'Need to fill learn date',
            'description.required' => 'Need to fill description',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $member = $this->memberData( $request );
        Member::findOrFail( $id )->update( $member );
        return redirect()->route( 'member.index' )->with( 'update', 'Member update success' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        Member::findOrFail( $id )->delete();
        return 'success';
    }

    public function search( Request $request ) {
        $member = Member::orWhere( 'title', 'like', '%' . $request->searchData . '%' )
            ->orWhere( 'price', 'like', '%' . $request->searchData . '%' )
            ->orWhere( 'learn_date', 'like', '%' . $request->searchData . '%' )
            ->orWhere( 'description', 'like', '%' . $request->searchData . '%' )
            ->orderBy( 'id', 'desc' )
            ->paginate( 10 );
        $member->appends( $request->all() );

        return view( 'admin.member.index', compact( 'member' ) );
    }

    private function memberData( $request ) {
        return array(
            'slug'        => uniqid() . Str::slug( $request->title ),
            'title'       => $request->title,
            'price'       => $request->price,
            'learn_date'  => $request->learn_date,
            'description' => $request->description,
        );
    }

}
