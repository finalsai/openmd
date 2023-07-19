@extends('layouts.common')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vditor/3.9.4/index.min.css" integrity="sha512-++z6isY6rtpzhsceazm/JqabaSLqL7NIwnQtqbEykNP6SLqy95oEO3NjJAuVoFZyKEpE4E5EDlb2/alGqSgMUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class=" flex-1 flex flex-col">
    <div id="area" class=" flex-1 bg-white"></div>

    @if($errors->any())
    <div class=" mt-4 bg-red-200 text-black p-2 rounded">{{ $errors->first() }}</div>
    @endif

    <form name="mainform" action="" method="post" onsubmit="event.preventDefault()" class=" mt-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        @csrf
        <input type="hidden" name="markdown">
        <input type="text" name="slug" placeholder="Custom URL" value="{{ old('slug') }}" id="slug" class=" outline outline-slate-200 p-1 rounded bg-white" autocomplete="off" min="2" maxlength="32">
        <input type="text" name="edit" placeholder="Edit Password" value="{{ old('edit') }}" id="edit" class=" outline outline-slate-200 p-1 rounded bg-white" autocomplete="off" minlength="1" maxlength="64">
        <input type="text" name="access" placeholder="Access Password" value="{{ old('access') }}" id="access" class=" outline outline-slate-200 p-1 rounded bg-white" autocomplete="off" minlength="1" maxlength="64">

        <label class="relative inline-flex items-center cursor-pointer select-none">
            <input type="checkbox" name="onetime" value="1" @checked(old('onetime')) class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 uppercase">Burn after read</span>
        </label>

        <button id="go" class=" min-w-[8rem] py-2 rounded bg-zinc-950 text-white">Go</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vditor/3.9.4/index.min.js" integrity="sha512-Q/kUYObOmQ7O/rdaRdnkmz4MSYZBWyUcQtIRPyY6dRn0/wEnL5rFioy5h355mLvlb7I+bwVHgj+d8+CE2M8A0w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
