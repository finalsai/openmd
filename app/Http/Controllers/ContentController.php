<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Models\Content;
use App\Models\Report;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContentRequest $request)
    {
        $data = $request->validated();
        $row = new Content();
        $row->slug = $data['slug'] ?? uniqid('s');
        $row->edit_token = $data['edit'] ?? uniqid('e');
        $row->access_token = $data['access'] ?? null;
        $row->markdown = $data['markdown'];
        $row->disposable = boolval($data['onetime'] ?? 'no');
        $row->saveOrFail();

        session()->put('owner:' . $row->slug, time());
        session()->flash('edit', $row->edit_token);
        session()->flash('access', $row->access_token);

        return redirect()->route('content.show', ['content' => $row->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        if (session('owner:' . $content->slug)) {
            return view('show')->with('content', $content);
        }

        if ($content->access_token && session('access:' . $content->slug) != $content->access_token) {
            return view('auth')->with('content', $content);
        }

        $content->update(['view_count' => ++$content->view_count]);
        return view('show')->with('content', $content);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        if (session('owner:' . $content->slug)) {
            return view('edit')->with('content', $content);
        }

        if ($content->edit_token && session('edit:' . $content->slug) != $content->edit_token) {
            return view('auth')->with('content', $content);
        }

        return view('edit')->with('content', $content);
    }

    public function auth(Content $content)
    {
        $token = request('token');

        if ($content->edit_token == $token) {
            session()->put('edit:' . $content->slug, $token);
        }
        if ($content->access_token == $token) {
            session()->put('access:' . $content->slug, $token);
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentRequest $request, Content $content)
    {
        $data = $request->validated();
        $content->markdown = $data['markdown'];
        $content->access_token = $data['access'];
        $content->edit_token = $data['edit'];
        $content->saveOrFail();

        return redirect()->route('content.show', ['content' => $content->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        $report = new Report();
        $report->content_id = $content->id;
        $report->ip = request()->ip();
        $report->useragent = request()->userAgent();
        $report->referrer = request()->header('Referer');
        $report->save();

        $count = $content->reports()->count();
        if ($count > 5) {
            $content->delete();
        }
    }
}