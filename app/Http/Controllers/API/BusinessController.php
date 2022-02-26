<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BusinessCompetition;
use App\Models\BusinessMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
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
            'leader_email'  => 'required|email:dns|max:255|unique:business_competitions,email',
            'team_name'     => 'required|max:255',
            'university'    => 'required|max:255',
            'phone'         => 'required|min:10|max:14|unique:business_competitions,phone',

            'member1_name'  => 'required|max:255',
            'member1_email' => 'required|email:dns|max:255|unique:business_members,email',
            'member1_phone' => 'required|min:10|max:14|unique:business_members,phone',
            'member2_name'  => 'required|max:255',
            'member2_email' => 'required|email:dns|max:255|unique:business_members,email',
            'member2_phone' => 'required|min:10|max:14|unique:business_members,phone',

            'leader_file'   => 'required|max:2048|mimes:zip,rar',
            'member1_file'  => 'required|max:2048|mimes:zip,rar',
            'member2_file'  => 'required|max:2048|mimes:zip,rar',
        ]);

        // Validator Failed
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // Converting to Array
        $validated = $validator->validated();

        // Generate Register Code
        $register_code = 'BCC-' . (BusinessCompetition::count() + 1);

        // Modify Leader File Name and Store Leader File
        $leader_file = $register_code . '_Leader.' . $request->leader_file->extension();
        $request->leader_file->move(public_path('files/bcc'), $leader_file);

        // Store Leader Data and get Data ID
        $register_id = BusinessCompetition::create([
            'user_id'       => auth()->user()->id,
            'register_code' => $register_code,
            'name'          => $validated["leader_name"],
            'email'         => $validated["leader_email"],
            'team_name'     => $validated["team_name"],
            'university'    => $validated["university"],
            'phone'         => $validated["phone"],
            'file'          => $leader_file,
        ])->id;

        // Store Members Data
        for ($i = 1; $i <= 2; $i++) {
            // Check if empty
            if (isset($validated["member${i}_name"]) && isset($validated["member${i}_email"]) && isset($validated["member${i}_phone"])) {
                // Modify Member File Name and Store Member File
                $member_file = $register_code . "_Member$i." . $validated["member${i}_file"]->extension();
                $validated["member${i}_file"]->move(public_path('files/bcc'), $member_file);

                // Store Member Data
                BusinessMember::create([
                    'user_id'                   => auth()->user()->id,
                    'business_competition_id'   => $register_id,
                    'register_code'             => $register_code,
                    'name'                      => $validated["member${i}_name"],
                    'email'                     => $validated["member${i}_email"],
                    'phone'                     => $validated["member${i}_phone"],
                    'file'                      => $member_file
                ]);
            }
        }

        return response()->json('Form was Submited created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessCompetition  $businessCompetition
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessCompetition $businessCompetition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessCompetition  $businessCompetition
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessCompetition $businessCompetition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessCompetition  $businessCompetition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessCompetition $businessCompetition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessCompetition  $businessCompetition
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessCompetition $businessCompetition)
    {
        //
    }
}
