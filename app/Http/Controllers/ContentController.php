<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Models\Content;
use App\Models\Report;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $data['edit'] = $data['edit'] ?? Str::random(5);

        $row = new Content();
        $row->slug = $data['slug'] ?? Str::random(5);
        $row->edit_token = Hash::make($data['edit']);
        $row->markdown = Crypt::encryptString($data['markdown']);
        $row->disposable = boolval($data['onetime'] ?? '0');

        if ($data['access']) {
            $crypter = new Encrypter(substr(hash('sha256', $data['access']), -32), 'aes-256-gcm');
            $row->markdown = $crypter->encryptString($row->markdown);
            $row->access_token = Hash::make($data['access']);
        }

        $row->saveOrFail();

        session()->put('owner:' . $row->slug, time());
        session()->flash('edit', $data['edit']);
        session()->flash('access', $data['access'] ?? null);

        return redirect()->route('content.show', ['content' => $row->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        if ($content->disposable && ($content->view_count + 1) > 1) {
            $content->delete();
            abort(404);
        }

        $access = session('access:' . $content->slug);

        if ($content->access_token && !Hash::check($access, $content->access_token)) {
            return view('auth')->with('kind', 'Access')->with('content', $content)->with('page', $content);
        }

        if (!session('owner:' . $content->slug)) {
            $content->update(['view_count' => ++$content->view_count]);
        }

        if ($content->access_token) {
            $crypter = new Encrypter(substr(hash('sha256', $access), -32), 'aes-256-gcm');
            $content->markdown = $crypter->decryptString($content->markdown);
        }

        $content->markdown = Crypt::decryptString($content->markdown);

        return view('show')->with('content', $content)->with('page', $content);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        $access = session('access:' . $content->slug);
        $edit = session('edit:' . $content->slug);

        if ($content->access_token && !Hash::check($access, $content->access_token)) {
            return view('auth')->with('kind', 'Access')->with('content', $content)->with('page', $content);
        }

        if ($content->edit_token && !Hash::check($edit, $content->edit_token)) {
            return view('auth')->with('kind', 'Edit')->with('content', $content)->with('page', $content);
        }

        session()->put('owner:' . $content->slug, time());

        if ($content->access_token) {
            $crypter = new Encrypter(substr(hash('sha256', $access), -32), 'aes-256-gcm');
            $content->markdown = $crypter->decryptString($content->markdown);
        }

        $content->markdown = Crypt::decryptString($content->markdown);
        $content->access_token = $access;
        $content->edit_token = $edit;

        return view('edit')->with('content', $content)->with('page', $content);
    }

    public function auth(Content $content)
    {
        $kind = request('kind');
        $kind = $kind == 'Edit' ? 'Edit' : 'Access';

        $token = request('token');

        session()->put(strtolower($kind) . ':' . $content->slug, $token);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContentRequest $request, Content $content)
    {
        $data = $request->validated();

        $content->edit_token = Hash::make($data['edit']);
        $content->markdown = Crypt::encryptString($data['markdown']);
        if ($data['access']) {
            $crypter = new Encrypter(substr(hash('sha256', $data['access']), -32), 'aes-256-gcm');
            $content->markdown = $crypter->encryptString($content->markdown);
            $content->access_token = Hash::make($data['access']);
        }

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

        // $count = $content->reports()->count();
        // if ($count > 5) {
        //     $content->delete();
        // }
    }
}
