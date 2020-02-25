<?php

namespace App\Http\Controllers\Api;

use App\Classes\PopularSort;
use App\Device;
use App\Http\Controllers\Controller;
use App\Traits\Likeable;
use Illuminate\Http\Request;
use App\Content;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Sorts\Sort;

class ContentController extends Controller
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

        $content = QueryBuilder::for(Content::class)
            ->allowedFilters(['category_id', 'type'])
            ->allowedSorts(AllowedSort::custom('popular', new PopularSort(), ''))
            ->get()
            ->groupBy('type');

        return response()->json(
            [
            'success' => true,
            'data' => $content,
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


    public function like(Request $request, Content $content)
    {
        return $this->likeIt($request, $content);
    }
}
