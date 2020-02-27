<?php

namespace App\Http\Controllers\Api;

use App\Classes\PopularSort;
use App\Content;
use App\Http\Controllers\Controller;
use App\Traits\Likeable;
use App\WeeklyReminder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class WeeklyRemindersController extends Controller
{
    use Likeable;
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
            ->allowedSorts(AllowedSort::custom('popular', new PopularSort(), ''))
            ->defaultSort('-created_at')
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

    public function like(Request $request, WeeklyReminder $weeklyReminder)
    {
        return $this->likeIt($request, $weeklyReminder);
    }
}
