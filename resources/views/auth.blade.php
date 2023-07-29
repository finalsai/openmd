@extends('layouts.common')

@section('content')
<form action="{{ route('content.auth', ['content' => $content->slug]) }}" method="post" class=" flex-1 flex flex-col items-center justify-center gap-4">
    @csrf
    <input type="hidden" name="kind" value="{{ $kind }}">
    <input class=" outline outline-slate-200 p-2 rounded bg-white w-full md:max-w-sm" type="text" name="token" placeholder="Enter {{ $kind }} Password" value="{{ old('password') }}" autocomplete="off">

    @if ($errors->any())
    <div class=" bg-red-200 text-slate-900 p-2 rounded">{{ $errors->first() }}</div>
    @endif

    <button type="submit" class=" min-w-[8rem] py-2 rounded bg-zinc-950 text-white">Check In</button>
</form>
@endsection
