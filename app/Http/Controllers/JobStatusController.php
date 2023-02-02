<?php

namespace App\Http\Controllers;

use App\Models\JobStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobStatusController extends Controller
{
    public function index()
    {
        //get data from table Users
        $Status = JobStatus::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Status Lamaran',
            'data'    => $Status
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required',
            'job_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $Status = JobStatus::create([
            'user_id'  => $request->user_id,
            'job_id'  => $request->job_id,
        ]);

        if ($Status) {
            return response()->json([
                'success' => true,
                'message' => 'Status Created',
                'data'    => $Status
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Status Failed to Save',
        ], 409);
    }

    public function show($id)
    {
        $status = DB::table('job_statuses')
            ->join('vacancies', 'job_statuses.job_id', '=', 'vacancies.id')
            ->where('user_id', $id)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Status Lamaran',
            'data'    => $status
        ], 200);
    }
}
