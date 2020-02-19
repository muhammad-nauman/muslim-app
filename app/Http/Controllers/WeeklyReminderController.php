<?php

namespace App\Http\Controllers;

use App\WeeklyReminder;
use Illuminate\Http\Request;

class WeeklyReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weeklyReminders = WeeklyReminder::get();

        return view('weekly_reminders.index', [
            'weeklyReminders' => $weeklyReminders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('weekly_reminders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id'           => 'required|exists:categories,id',
            'title'                 => 'required|unique:weekly_reminders',
            'publishing_timestamp'  => 'required|after:today',
            'type'                  => 'required|in:audio,article',
            'content' => 'required_if:type,article|min:3|max:2000',
            'file' => 'required_if:type,audio|mimes:mpga,wav',
        ]);

        if($request->input('type') === 'article' && $request->input('content') === '<p><br></p>') {
            return redirect()->back()->with('error', 'Please write full content');
        }

        $weeklyReminder = new WeeklyReminder($request->only('category_id', 'title', 'type'));

        if($request->input('type') === 'audio') {
            $fileName = $request->input('title') . '.' . $request->file->extension();
            $path = $request->file->storeAs('public/audios/reminders', $fileName);
            $weeklyReminder->content = $path;

            $weeklyReminder->duration = get_audio_duration(get_storage_driver_path($path));

            $weeklyReminder->save();
            return redirect()->route('weekly_reminders.index');
        }

        $weeklyReminder->content = $request->input('content');

        $weeklyReminder->save();

        return redirect()->route('weekly_reminders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WeeklyReminder  $weeklyReminder
     * @return \Illuminate\Http\Response
     */
    public function show(WeeklyReminder $weeklyReminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WeeklyReminder  $weeklyReminder
     * @return \Illuminate\Http\Response
     */
    public function edit(WeeklyReminder $weeklyReminder)
    {
        return view('weekly_reminders.edit', [
            'weeklyReminder' => $weeklyReminder,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WeeklyReminder  $weeklyReminder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeeklyReminder $weeklyReminder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WeeklyReminder  $weeklyReminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeeklyReminder $weeklyReminder)
    {
        //
    }
}
