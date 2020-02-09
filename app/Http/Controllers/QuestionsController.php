<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Category;
use App\Answer;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::withCount('answers')->get();
        return view('questions.index', ['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('questions.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'question' => 'required|unique:questions',
            'answers' => 'required|array|between:2,4',
            'correct' => 'required|min:0|max:3',
        ]);

        if(! isset(request('answers')[request('correct')]) && is_null(request('answers')[request('correct')]['answer'])) {
            return redirect()->back()->with('message', 'Please select correct answer');
        }

        $question = Question::create($request->only('category_id', 'question'));
        $answers = $request->answers;
        $answers[request('correct')] = array_merge($answers[request('correct')], ['is_right' => true]);

        collect($answers)->filter(function($answer) {
            return ! is_null($answer['answer']);
        })->map(function($answer) use ($question) {
            $question->answers()->save(new Answer($answer));
        });

        return redirect()->route('questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $categories = Category::where('is_active', 1)->get();
        $question->load('answers');

        return view('questions.edit', [
            'question' => $question,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'question' => 'required|unique:questions,question,'. $question->id,
            'answers' => 'required|array|between:2,4',
            'correct' => 'required|min:0|max:3',
        ]);
        // dd($request->all());

        if(! isset(request('answers')[request('correct')]) && is_null(request('answers')[request('correct')]['answer'])) {
            return redirect()->back()->with('message', 'Please select correct answer');
        }

        $activeStatus = [
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        $question->update(array_merge($request->only('category_id', 'question'), $activeStatus));
        $answers = $request->answers;
        $answers[request('correct')] = array_merge($answers[request('correct')], ['is_right' => true]);

        collect($answers)->filter(function($answer) {
            return ! is_null($answer['answer']);
        })->map(function($answer) {
            Answer::findOrFail($answer['answer_id'])->update(collect($answer)->except('answer_id')->toArray());
        });

        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index');
    }
}
