<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Models\Petrosmartform;
use App\Http\Controllers\Controller;
use App\Http\Resources\PetrosmartformResource;

class PetrosmartformsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Petrosmartforms::latest()->get();
        return response()->json([Petrosmartforms::collection($data), 'Form fetched.']);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'teamleader' => 'required|string|max:255',
            'judulpaper' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $petrosmartform = Petrosmartform::create([
            'teamleader' => $request->teamleader,
            'judulpaper' => $request->judulpaper
         ]);
        
        return response()->json(['Form was Submited created successfully.', new PetrosmartformResource($petrosmartform)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $petrosmartform = Petrosmartform::find($id);
        if (is_null($petrosmartform)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new PetrosmartformResource($petrosmartform)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Petrosmartform $Petrosmartform)
    {
        $validator = Validator::make($request->all(),[
            'teamleader' => 'required|string|max:255',
            'judulpaper' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $petrosmartform->teamleader = $request->teamleader;
        $petrosmartform->judulpaper = $request->judulpaper;
        $petrosmartform->save();
        
        return response()->json(['Form Was Submitted updated successfully.', new PetrosmartformResource($petrosmartform)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Petrosmartform $petrosmartform)
    {
        $petrosmartform->delete();

        return response()->json('Form deleted successfully');
    }
}
