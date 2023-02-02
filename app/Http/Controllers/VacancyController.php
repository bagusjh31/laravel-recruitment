<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacancyController extends Controller
{
    public function index()
    {
        //get data from table Users
        $vacancy = Vacancy::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Lowongan Pekerjaan',
            'data'    => $vacancy
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'position'  => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $vacancy = Vacancy::create([
            'position'  => $request->position
        ]);

        //success save to database
        if ($vacancy) {
            return response()->json([
                'success' => true,
                'message' => 'Vacancy Created',
                'data'    => $vacancy
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Vacancy Failed to Save',
        ], 409);
    }
}
