<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::whereHas('category', function($query) {
            return $query->where('is_active', 1);
        })->get();

        return view('content.index', ['contents' => $contents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.create');
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
            'title' => 'required|min:3|max:200',
            'type' => 'required|in:audio,article',
            'content' => 'required_if:type,article|min:3|max:20000',
            'file' => 'required_if:type,audio|mimes:mpga,wav',
        ]);


        if($request->input('type') === 'article' && $request->input('content') === '<p><br></p>') {
            return redirect()->back()->with('error', 'Please write full content');
        }

        $content = new Content($request->only('category_id', 'title', 'type'));

        if($request->input('type') === 'audio') {
            $fileName = $request->input('title') . '.' . $request->file->getClientOriginalExtension() === 'mpga' || $request->file->getClientOriginalExtension() === 'mpeg' ? 'mp3' : $request->file->getClientOriginalExtension();
            $path = $request->file->storeAs('public/audios', replace_special_alphabets($fileName));
            $content->content = $path;

            $content->duration = get_audio_duration(get_storage_driver_path($path));

            $content->save();
            return redirect()->route('contents.index');
        }

        $content->content = $request->input('content');

        $content->save();

        return redirect()->route('contents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        return view('content.edit', [
            'content' => $content,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|min:3|max:200',
            'type' => 'required|in:audio,article',
            'content' => 'required_if:type,article|min:3|max:20000',
            'file' => 'sometimes|mimes:mpga,wav',
        ]);


        if($request->input('type') === 'article' && $request->input('content') === '<p><br></p>') {
            return redirect()->back()->with('error', 'Please write full content');
        }

        $content->update($request->only('category_id', 'title', 'type'));

        if($request->hasFile('file') && $request->input('type') === 'audio') {
            $fileName = $request->input('title') . '.' . $request->file->getClientOriginalExtension();
            $path = $request->file->storeAs('public/audios', replace_special_alphabets($fileName));
            $content->content = $path;

            $content->duration = get_audio_duration(get_storage_driver_path($path));

            $content->save();
            return redirect()->route('contents.index');
        }

        $content->content = $request->input('type') === 'audio'
            ? $request->input('old_file')
            : $request->input('content');

        $content->save();

        return redirect()->route('contents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        $content->delete();

        return redirect()->back();
    }
}
