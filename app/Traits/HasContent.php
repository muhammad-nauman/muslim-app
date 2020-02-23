<?php


namespace App\Traits;


trait HasContent
{
    public function validateArticleContent()
    {
        if(request()->input('type') === 'article' && request()->input('content') === '<p><br></p>') {
            return redirect()->back()->with('error', 'Please write full content');
        }
    }

}
