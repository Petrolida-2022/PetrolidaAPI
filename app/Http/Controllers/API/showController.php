<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class showController extends Controller
{
    public function index()
    {
        $data = Program::latest()->get();
        return response()->json([showController::collection($data), 'Programs fetched.']);
    }
}
