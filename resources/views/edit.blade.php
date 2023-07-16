@extends('layouts.common')

@section('title', 'Edit ' . $content->slug . ' - text.is')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/vditor/dist/index.css" />
@endpush

@section('content')
<div class=" mt-8 flex-1 flex flex-col">
    <div id="area" class=" flex-1"></div>

    @if($errors->any())
    <div class=" mt-4 bg-red-200 text-black p-2 rounded">{{ $errors->first() }}</div>
    @endif

    <form name="mainform" action="{{ route('content.update', ['content' => $content->slug]) }}" method="post" onsubmit="event.preventDefault()" class=" mt-4 flex items-center justify-between">
        @method('put')
        @csrf
        <input type="hidden" name="markdown">
        <input type="text" name="slug" disabled placeholder="Custom URL" value="{{ $content->slug }}" id="slug" class=" outline outline-slate-200 p-2 rounded bg-white disabled:bg-slate-100 disabled:text-slate-600" autocomplete="off">
        <input type="text" name="edit" minlength="1" maxlength="64" placeholder="Edit Password" value="{{ $content->edit_token }}" id="edit" class=" outline outline-slate-200 p-2 rounded bg-white" autocomplete="off">
        <input type="text" name="access" minlength="1" maxlength="64" placeholder="Access Password" value="{{ $content->access_token }}" id="access" class=" outline outline-slate-200 p-2 rounded bg-white" autocomplete="off">

        <label class="relative inline-flex items-center cursor-pointer select-none">
            <input type="checkbox" disabled name="onetime" value="1" @checked($content->disposable) class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600 peer-disabled:bg-green-200 peer-disabled:cursor-default"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 uppercase">Burn after read</span>
        </label>

        <button onclick="submitForm()" class=" min-w-[8rem] py-2 rounded bg-zinc-950 text-white">Save</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/vditor/dist/index.min.js"></script>
<script>
    const vditor = new Vditor('area', {
        value: `{!! $content->markdown !!}`,
        height: '100%',
        mode: 'sv',
        preview: {
            actions: 'none',
        },
        toolbar: [
            "emoji",
            "headings",
            "bold",
            "italic",
            "strike",
            "link",
            "table",
            "|",
            "list",
            "ordered-list",
            "check",
            "outdent",
            "indent",
            "|",
            "quote",
            "line",
            "code",
            "inline-code",
            "insert-before",
            "insert-after",
            "|",
            "undo",
            "redo",
            "|",
            "fullscreen",
            "edit-mode",
            "export",
            "outline",
        ]
    });

    function submitForm() {
        document.getElementsByName('markdown')[0].value = vditor.getValue();
        vditor.clearStack();
        document.forms['mainform'].submit();
    }

    function toggleToolbar() {
        vditor.vditor.toolbar.element.classList.toggle('hidden')
    }
</script>
@endpush