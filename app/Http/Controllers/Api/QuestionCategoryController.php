<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\QuestionCategory;
use Illuminate\Http\Request;

class QuestionCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $categories = QuestionCategory::get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
