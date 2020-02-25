<?php


namespace App\Traits;


use App\Device;
use Illuminate\Http\Request;

trait Likeable
{
    public function likeIt(Request $request, $content)
    {
        $this->validate($request, [
            'device_id' => 'required|exists:devices,id',
        ]);


        if($content->devices()->where('device_id', $request->input('device_id'))->exists()) {
            $content->devices()->where('device_id', $request->input('device_id'))->detach();

            return response()->json([
                'success' => true,
                'data' => $content,
                'action' => 'unlike',
            ]);
        }

        optional(Device::find($request->input('device_id')), function($device) use ($content) {
            $content->devices()->save($device, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return response()->json([
            'success' => true,
            'data' => $content,
            'action' => 'like',
        ]);
    }
}
