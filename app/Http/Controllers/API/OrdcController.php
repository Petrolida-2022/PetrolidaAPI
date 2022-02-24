<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrdCompetition;
use App\Models\OrdMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdcController extends Controller
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
            'leader_email'  => 'required|email:dns|max:255|unique:ord_competitions,leader_email',
            'team_name'     => 'required|max:255',
            'university'    => 'required|max:255',
            'phone'         => 'required|min:10|max:14|unique:ord_competitions,phone',
            'member1_name'  => 'required|max:255',
            'member1_email' => 'required|email:dns|max:255|unique:ord_members,member_email',
            'member1_phone' => 'required|min:10|max:14|unique:ord_members,member_email',
            'member2_name'  => 'required|max:255',
            'member2_email' => 'required|email:dns|max:255|unique:ord_members,member_email',
            'member2_phone' => 'required|min:10|max:14|unique:ord_members,member_email',
            'member3_name'  => 'required|max:255',
            'member3_email' => 'required|email:dns|max:255|unique:ord_members,member_email',
            'member3_phone' => 'required|min:10|max:14|unique:ord_members,member_email',
            'member4_name'  => 'max:255',
            'member4_email' => 'email:dns|max:255|unique:ord_members,member_email',
            'member4_phone' => 'min:10|max:14|unique:ord_members,member_email',
            'leader_file'   => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
            'member1_file'  => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
            'member2_file'  => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
            'member3_file'  => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
            'member4_file'  => 'max:2048|mimes:pdf,jpg,jpeg,png',
        ]);

        // Validator Failed
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // Converting to Array
        $validated = $validator->validated();

        // Generate Register Code
        $register_code = 'ORDC-' . (OrdCompetition::count() ?? 0) + 1;

        // Modify Phone Number
        $firstNumber = substr($validated['phone'], 0, 1);
        if ($firstNumber === '0') {
            $validated['phone'] = $validated['phone'];
        } else {
            $validated['phone'] = '0' . $validated['phone'];
        }

        // Modify Leader File Name and Store Leader File
        $leader_file = $register_code . '_Leader.' . $request->leader_file->extension();
        $request->leader_file->move(public_path('files/ordc'), $leader_file);

        // Store Leader Data and get Data ID
        $register_id = OrdCompetition::create([
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
        for ($i = 1; $i <= 4; $i++) {
            // Check if empty
            if ($validated["member${i}_name"] && $validated["member${i}_email"] && $validated["member${i}_phone"]) {
                // Modify Member File Name and Store Member File
                $member_file = $register_code . "_Member$i." . $validated["member${i}_file"]->extension();
                $validated["member${i}_file"]->move(public_path('files/ordc'), $member_file);

                // Store Member Data
                OrdMember::create([
                    'user_id'               => auth()->user()->id,
                    'ord_competition_id'    => $register_id,
                    'register_code'         => $register_code,
                    'name'                  => $validated["member${i}_name"],
                    'email'                 => $validated["member${i}_email"],
                    'phone'                 => $validated["member${i}_phone"],
                    'file'                  => $member_file
                ]);
            }
        }

        return response()->json('Form was Submited created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrdCompetition  $ordCompetition
     * @return \Illuminate\Http\Response
     */
    public function show(OrdCompetition $ordCompetition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrdCompetition  $ordCompetition
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdCompetition $ordCompetition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrdCompetition  $ordCompetition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdCompetition $ordCompetition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrdCompetition  $ordCompetition
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdCompetition $ordCompetition)
    {
        //
    }
}
