<?php

namespace App\Http\Controllers\Api;

use App\Classes\PopularSort;
use App\Content;
use App\Http\Controllers\Controller;
use App\Traits\Likeable;
use App\WeeklyReminder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class WeeklyRemindersController extends Controller
{
    use Likeable;
    /**
     * Display a listing of the resource.
     *
     * @throws
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

        $reminders = QueryBuilder::for(WeeklyReminder::class)->published()
            ->allowedFilters([
                'category_id',
                'type',
                'status',
                'title',
                'content'
            ])
            ->allowedSorts([
                AllowedSort::custom('popular', new PopularSort(), ''),
                'id',
                'created_at'
            ])
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

    public function like(Request $request, WeeklyReminder $weeklyReminder)
    {
        return $this->likeIt($request, $weeklyReminder);
    }
}
