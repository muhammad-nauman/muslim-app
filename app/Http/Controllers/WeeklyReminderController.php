<?php

namespace App\Http\Controllers;

use App\WeeklyReminder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\QueryBuilder\QueryBuilder;

class WeeklyReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
//        $this->validate(request(), [
//            'filter.status' => 'required'
//        ]);
        $weeklyReminders = QueryBuilder::for(WeeklyReminder::class)
            ->allowedFilters('status')
            ->get();

        return view('weekly_reminders.index', [
            'weeklyReminders' => $weeklyReminders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('weekly_reminders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id'           => 'required|exists:categories,id',
            'author_name'           => 'required',
            'title'                 => 'required|unique:weekly_reminders',
            'publishing_timestamp'  => 'required|after:today',
            'type'                  => 'required|in:audio,article',
            'content' => 'required_if:type,article|min:3|max:20000',
            'file' => 'required_if:type,audio|mimes:mpga,wav',
        ]);

        if($request->input('type') === 'article' && $request->input('content') === '<p><br></p>') {
            return redirect()->back()->with('error', 'Please write full content');
        }

        $weeklyReminder = new WeeklyReminder($request->only('category_id', 'author_name', 'title', 'type', 'publishing_timestamp'));

        if($request->input('type') === 'audio') {
            $fileName = $request->input('title') . '.' . $request->file->getClientOriginalExtension();
            $path = $request->file->storeAs('public/audios/reminders', $fileName);
            $weeklyReminder->content = $path;

            $weeklyReminder->duration = get_audio_duration(get_storage_driver_path($path));

            $weeklyReminder->save();
            return redirect()->route('weekly_reminders.index', ['filter[status]' => 0]);
        }

        $weeklyReminder->content = $request->input('content');

        $weeklyReminder->save();

        return redirect()->route('weekly_reminders.index', ['filter[status]' => 0]);
    }

    /**
     * Display the specified resource.
     *
     * @param  WeeklyReminder  $weeklyReminder
     * @return Response
     */
    public function show(WeeklyReminder $weeklyReminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  WeeklyReminder  $weeklyReminder
     * @return Factory| View
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
     * @param  Request  $request
     * @param  WeeklyReminder  $weeklyReminder
     * @return Response
     */
    public function update(Request $request, WeeklyReminder $weeklyReminder)
    {
        $this->validate($request, [
            'category_id'           => 'required|exists:categories,id',
            'author_name'           => 'required',
            'title'                 => 'required|unique:weekly_reminders,title,' . $weeklyReminder->id,
            'publishing_timestamp'  => 'required|after:today',
            'type'                  => 'required|in:audio,article',
            'content'               => 'sometimes|min:3|max:20000',
            'file'                  => 'sometimes|mimes:mpga,wav',
        ]);

        if($request->input('type') === 'article' && $request->input('content') === '<p><br></p>') {
            return redirect()->back()->with('error', 'Please write full content');
        }

        $weeklyReminder
            ->update($request->only('category_id', 'author_name', 'title', 'type', 'publishing_timestamp'));

        if($request->hasFile('file') && $request->input('type') == 'audio') {
            $fileName = $request->input('title') . '.' . $request->file->getClientOriginalExtension();
            $path = $request->file->storeAs('public/audios/reminders', $fileName);
            $weeklyReminder->content = $path;

            $weeklyReminder->duration = get_audio_duration(get_storage_driver_path($path));

            $weeklyReminder->save();
            return redirect()->route('weekly_reminders.index', ['filter[status]' => 0]);
        }

        $weeklyReminder->content = $request->input('type') === 'audio' ? $request->input('old_file') : $request->input('content');

        $weeklyReminder->save();

        return redirect()->route('weekly_reminders.index', ['filter[status]' => 0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WeeklyReminder  $weeklyReminder
     * @return RedirectResponse
     */
    public function destroy(WeeklyReminder $weeklyReminder)
    {
        $weeklyReminder->delete();

        return redirect()->back();
    }
}
