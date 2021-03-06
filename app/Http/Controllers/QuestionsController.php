<?php

namespace App\Http\Controllers;

use App\QuestionCategory;
use Illuminate\Http\Request;
use App\Question;
use App\Category;
use App\Answer;
use App\Quiz;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('question_categories:name')->withCount('answers')->get();
        return view('questions.index', ['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = QuestionCategory::get();
        return view('questions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'question_category_id' => 'required|array',
            'question' => 'required|unique:questions',
            'answers' => 'required|array|between:2,4',
            'correct' => 'required|min:0|max:3',
        ]);

        if(! isset(request('answers')[request('correct')]) && is_null(request('answers')[request('correct')]['answer'])) {
            return redirect()->back()->with('message', 'Please select correct answer');
        }

        $question = Question::create($request->only( 'question'));
        $question->question_categories()->attach($request->input('question_category_id'));
        $answers = $request->answers;
        $answers[request('correct')] = array_merge($answers[request('correct')], ['is_right' => true]);

        collect($answers)->filter(function($answer) {
            return ! is_null($answer['answer']);
        })->map(function($answer) use ($question) {
            $question->answers()->save(new Answer($answer));
        });

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Quiz  $quiz
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz, Question $question)
    {
        $categories = QuestionCategory::get();
        $question->load('answers');

        $question->category_ids = $question->question_categories()->pluck('question_category_id');

        return view('questions.edit', [
            'question'   => $question,
            'quiz'       => $quiz,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $this->validate($request, [
            'question_category_id' => 'required|array',
            'question_category_id.*' => 'required|exists:question_categories,id',
            'question' => 'required|unique:questions,question,'. $question->id,
            'answers' => 'required|array|between:2,4',
            'correct' => 'required|min:0|max:3',
        ]);

        if(! isset(request('answers')[request('correct')]) && is_null(request('answers')[request('correct')]['answer'])) {
            return redirect()->back()->with('message', 'Please select correct answer');
        }

        $question->question_categories()->detach();

        $question->question_categories()->attach($request->input('question_category_id'));

        $question->update($request->only('question'));
        $answers = $request->answers;
        $answers[request('correct')] = array_merge($answers[request('correct')], ['is_right' => true]);

        collect($answers)->filter(function($answer) {
            return ! is_null($answer['answer']);
        })->map(function($answer) {
            Answer::findOrFail($answer['answer_id'])->update(collect($answer)->except('answer_id')->toArray());
        });

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index');
    }
}
