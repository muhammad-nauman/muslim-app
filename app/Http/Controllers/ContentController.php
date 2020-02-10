<?php

namespace App\Http\Controllers;

use App\Category;
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
        $categories = Category::where('is_active', 1)->get();
        return view('content.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|min:3|max:200',
            'type' => 'required|in:audio,article',
            'content' => 'required_if:type,article|min:3|max:2000',
            'file' => 'required_if:type,audio|mimes:mpga,wav',
        ]);

        
        if($request->input('type') === 'article' && $request->input('content') === '<p><br></p>') {
            return redirect()->back()->with('error', 'Please write full content');
        }
        
        $content = new Content($request->only('category_id', 'title', 'type'));

        if($request->input('type') === 'audio') {
            $fileName = $request->input('title') . '.' . $request->file->extension();
            $path = $request->file->storeAs('public/audios', $fileName);
            $content->content = $path;

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
        $categories = Category::where('is_active', 1)->get();

        return view('content.edit', [
            'categories' => $categories,
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
        //
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
