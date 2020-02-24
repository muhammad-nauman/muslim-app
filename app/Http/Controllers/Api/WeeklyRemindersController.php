<?php

namespace App\Http\Controllers\Api;

use App\Content;
use App\Http\Controllers\Controller;
use App\WeeklyReminder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class WeeklyRemindersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->validate(
            request(), [
                'category_id' => 'sometimes|exists:categories,id',
                'type' => 'sometimes|in:audio,article',
            ]
        );

        $reminders = QueryBuilder::for(WeeklyReminder::class)
            ->allowedFilters(['category_id', 'type', 'status'])
            ->get()
            ->groupBy('type');

        return response()->json(
            [
                'success' => true,
                'data' => $reminders,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
