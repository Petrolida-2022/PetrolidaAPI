<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaperCompetition;
use App\Models\PaperMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaperController extends Controller
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
            'leader_email'  => 'required|email:dns|max:255|unique:paper_competitions,email',
            'team_name'     => 'required|max:255',
            'university'    => 'required|max:255',
            'phone'         => 'required|min:10|max:14|unique:paper_competitions,phone',

            'member1_name'  => 'nullable|max:255',
            'member1_email' => 'nullable|email:dns|max:255|unique:paper_members,email',
            'member1_phone' => 'nullable|min:10|max:14|unique:paper_members,phone',
            'member2_name'  => 'nullable|max:255',
            'member2_email' => 'nullable|email:dns|max:255|unique:paper_members,email',
            'member2_phone' => 'nullable|min:10|max:14|unique:paper_members,phone',

            'leader_file'   => 'required|max:2048|mimes:zip,rar',
            'member1_file'  => 'nullable|max:2048|mimes:zip,rar',
            'member2_file'  => 'nullable|max:2048|mimes:zip,rar',
            'payment'       => 'required|max:2048|mimes:jpg,jpeg,png',
        ]);

        // Validator Failed
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // Converting to Array
        $validated = $validator->validated();

        // Generate Register Code
        $register_code = 'PAPER-' . (PaperCompetition::count() + 1);

        // Modify Leader File Name and Store Leader File
        $leader_file = $register_code . '_Leader.' . $request->leader_file->extension();
        $request->leader_file->move(public_path('files/paper'), $leader_file);

        // Modify Payment Slip and Store File
        $payment_file = $register_code . '_payment.' . $request->payment->extension();
        $request->payment->move(public_path('files/paper'), $payment_file);

        // Store Leader Data and get Data ID
        $register_id = PaperCompetition::create([
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
                $validated["member${i}_file"]->move(public_path('files/paper'), $member_file);

                // Store Member Data
                PaperMember::create([
                    'user_id'               => auth()->user()->id,
                    'paper_competition_id'    => $register_id,
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
     * @param  \App\Models\PaperCompetition  $paperCompetition
     * @return \Illuminate\Http\Response
     */
    public function show(PaperCompetition $paperCompetition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaperCompetition  $paperCompetition
     * @return \Illuminate\Http\Response
     */
    public function edit(PaperCompetition $paperCompetition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaperCompetition  $paperCompetition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaperCompetition $paperCompetition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaperCompetition  $paperCompetition
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaperCompetition $paperCompetition)
    {
        //
    }
}
