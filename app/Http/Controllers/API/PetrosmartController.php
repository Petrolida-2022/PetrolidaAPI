<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PetrosmartCompetition;
use App\Models\PetrosmartMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetrosmartController extends Controller
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
            'leader_email'  => 'required|email:dns|max:255|unique:petrosmart_competitions,email',
            'team_name'     => 'required|max:255',
            'university'    => 'required|max:255',
            'phone'         => 'required|min:10|max:14|unique:petrosmart_competitions,phone',

            'member1_name'  => 'required|max:255',
            'member1_email' => 'required|email:dns|max:255|unique:petrosmart_members,email',
            'member1_phone' => 'required|min:10|max:14|unique:petrosmart_members,phone',
            'member2_name'  => 'required|max:255',
            'member2_email' => 'required|email:dns|max:255|unique:petrosmart_members,email',
            'member2_phone' => 'required|min:10|max:14|unique:petrosmart_members,phone',

            'leader_file'   => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
            'member1_file'  => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
            'member2_file'  => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
            'payment'       => 'required|max:2048|mimes:pdf,jpg,jpeg,png',
        ]);

        // Validator Failed
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // Converting to Array
        $validated = $validator->validated();

        // Generate Register Code
        $register_code = 'Petrosmart-' . (PetrosmartCompetition::count() + 1);

        // Modify Leader File Name and Store Leader File
        $leader_file = $register_code . '_Leader.' . $request->leader_file->extension();
        $request->leader_file->move(public_path('files/petrosmart'), $leader_file);

        // Modify Payment Slip and Store File
        $payment_file = $register_code . '_payment.' . $request->payment->extension();
        $request->payment->move(public_path('files/stc'), $payment_file);

        // Store Leader Data and get Data ID
        $register_id = PetrosmartCompetition::create([
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

        // Store Members Data
        for ($i = 1; $i <= 2; $i++) {
            // Check if empty
            if (isset($validated["member${i}_name"]) && isset($validated["member${i}_email"]) && isset($validated["member${i}_phone"])) {
                // Modify Member File Name and Store Member File
                $member_file = $register_code . "_Member$i." . $validated["member${i}_file"]->extension();
                $validated["member${i}_file"]->move(public_path('files/petrosmart'), $member_file);

                // Store Member Data
                PetrosmartMember::create([
                    'user_id'                   => auth()->user()->id,
                    'petrosmart_competition_id' => $register_id,
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
     * @param  \App\Models\PetrosmartCompetition  $petrosmartCompetition
     * @return \Illuminate\Http\Response
     */
    public function show(PetrosmartCompetition $petrosmartCompetition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PetrosmartCompetition  $petrosmartCompetition
     * @return \Illuminate\Http\Response
     */
    public function edit(PetrosmartCompetition $petrosmartCompetition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PetrosmartCompetition  $petrosmartCompetition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PetrosmartCompetition $petrosmartCompetition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PetrosmartCompetition  $petrosmartCompetition
     * @return \Illuminate\Http\Response
     */
    public function destroy(PetrosmartCompetition $petrosmartCompetition)
    {
        //
    }
}
