<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StockCompetition;
use App\Models\StockMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'leader_name'   => 'required|max:255',
            'leader_email'  => 'required|email:dns|max:255|unique:stock_competitions,email',
            'team_name'     => 'required|max:255',
            'university'    => 'required|max:255',
            'phone'         => 'required|min:10|max:14|unique:stock_competitions,phone',

            'member_name'   => 'required|max:255',
            'member_email'  => 'required|email:dns|max:255|unique:stock_members,email',
            'member_phone'  => 'required|min:10|max:14|unique:stock_members,phone',

            'leader_file'   => 'required|max:2048|mimes:zip,rar',
            'member_file'   => 'required|max:2048|mimes:zip,rar',
            'payment'       => 'required|max:2048|mimes:jpg,jpeg,png',
        ]);

        // Validator Failed
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // Converting to Array
        $validated = $validator->validated();

        // Generate Register Code
        $register_code = 'STC-' . (StockCompetition::count() + 1);

        // Modify Leader File Name and Store Leader File
        $leader_file = $register_code . '_Leader.' . $request->leader_file->extension();
        $request->leader_file->move(public_path('files/stc'), $leader_file);

        // Modify Payment Slip and Store File
        $payment_file = $register_code . '_payment.' . $request->payment->extension();
        $request->payment->move(public_path('files/stc'), $payment_file);

        // Store Leader Data and get Data ID
        $register_id = StockCompetition::create([
            'user_id'       => auth()->user()->id,
            'register_code' => $register_code,
            'name'          => $validated["leader_name"],
            'email'         => $validated["leader_email"],
            'team_name'     => $validated["team_name"],
            'university'    => $validated["university"],
            'phone'         => $validated["phone"],
            'file'          => $leader_file,
            'payment'       => $payment_file
        ])->id;

        // Modify Member File Name and Store Member File
        $member_file = $register_code . "_Member." . $validated["member_file"]->extension();
        $validated["member_file"]->move(public_path('files/stc'), $member_file);

        // Store Member Data
        StockMember::create([
            'user_id'               => auth()->user()->id,
            'stock_competition_id'  => $register_id,
            'register_code'         => $register_code,
            'name'                  => $validated["member_name"],
            'email'                 => $validated["member_email"],
            'phone'                 => $validated["member_phone"],
            'file'                  => $member_file
        ]);

        return response()->json('Form was Submited created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockCompetition  $stockCompetition
     * @return \Illuminate\Http\Response
     */
    public function show(StockCompetition $stockCompetition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockCompetition  $stockCompetition
     * @return \Illuminate\Http\Response
     */
    public function edit(StockCompetition $stockCompetition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockCompetition  $stockCompetition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockCompetition $stockCompetition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockCompetition  $stockCompetition
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockCompetition $stockCompetition)
    {
        //
    }
}
