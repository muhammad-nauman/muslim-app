<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DevicesController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request, [
            'device_id' => 'required',
            ]
        );

        $device = Device::where('device_id', request('device_id'))->first();
        $last_active_session = null;

        if (isset($device->id)) {
            $last_active_session = now();

            $device->update(
                [
                'last_active_session' => now(),
                ]
            );
            return response()->json(
                [
                    'success' => true,
                    'data' => $device,
                    'last_active_session' => $last_active_session,
                ]
            );
        }
        $this->validate(
            $request, [
                'device_type' => 'required',
                'fcm_id' => 'required',
            ]
        );
        $device = Device::create($request->all());

        return response()->json(
            [
                'success' => true,
                'data' => $device,
                'last_active_session' => $last_active_session,
            ], 201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
