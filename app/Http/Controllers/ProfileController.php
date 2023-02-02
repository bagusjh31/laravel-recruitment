<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get data from table Users
        $profiles = Profile::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Profile',
            'data'    => $profiles
        ], 200);
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
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'            => 'required',
            'firstName'     => 'required',
            'lastName'      => 'required',
            'birthday'      => 'required',
            'address'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $image = time() . '_' . $request->photo->getClientOriginalName();
        $pdf = time() . '_' . $request->cv->getClientOriginalName();
        $request->photo->move(public_path('images'), $image);
        $request->cv->move(public_path('doc'), $pdf);

        $profile = Profile::create([
            'user_id'       => $request->id,
            'first_name'    => $request->firstName,
            'last_name'     => $request->lastName,
            'birthday'      => $request->birthday,
            'address'       => $request->address,
            'image'         => $image,
            'cv'            => $pdf,
        ]);

        //success save to database
        if ($profile) {
            return response()->json([
                'success' => true,
                'message' => 'Profile Created',
                'data'    => $profile
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Profile Failed to Save',
        ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::where('user_id', $id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Detail Data User',
            'data'    => $profile
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'birthday'      => 'required',
            'address'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $profile->update([
            'first_name'    => $request->get('first_name'),
            'last_name'     => $request->get('last_name'),
            'birthday'      => $request->get('birthday'),
            'address'       => $request->get('address'),
        ]);

        return response()->json([
            'message' => 'Post updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
