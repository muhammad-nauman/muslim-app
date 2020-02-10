<?php

namespace App\Http\Controllers;

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
    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions()->withCount('answers')->get();
        return view('questions.index', ['questions' => $questions, 'quiz' => $quiz]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Quiz $quiz)
    {
        return view('questions.create', [
            'quiz' => $quiz,
            'questions' => $quiz->questions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quiz $quiz)
    {
        $this->validate($request, [
            'question' => 'required|unique:questions',
            'answers' => 'required|array|between:2,4',
            'correct' => 'required|min:0|max:3',
        ]);

        if(! isset(request('answers')[request('correct')]) && is_null(request('answers')[request('correct')]['answer'])) {
            return redirect()->back()->with('message', 'Please select correct answer');
        }

        $question = new Question($request->only( 'question'));
        $quiz->questions()->save($question);
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
     * @param  Question  $question
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
     * @param  Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $this->validate($request, [
            'question' => 'required|unique:questions,question,'. $question->id,
            'answers' => 'required|array|between:2,4',
            'correct' => 'required|min:0|max:3',
        ]);

        if(! isset(request('answers')[request('correct')]) && is_null(request('answers')[request('correct')]['answer'])) {
            return redirect()->back()->with('message', 'Please select correct answer');
        }

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
