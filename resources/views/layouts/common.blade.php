<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='manifest' href='/manifest.json'>
    <link rel="icon" href="/favicon.ico">

    {!! seo($page ?? null) !!}

    @stack('styles')
    @vite('resources/css/app.css')
</head>

<body class=" max-w-screen-lg mx-auto bg-slate-50 p-5 h-screen flex flex-col gap-8">
    <nav class=" w-full bg-white mx-auto p-4 rounded select-none flex justify-between">
        <a href="{{ url('') }}" class=" uppercase font-bold">{{ config('app.name') }}</a>
        <div class=" flex gap-4 text-base text-slate-600 transition-colors">
            @foreach ($links as $link)
            <a target="{{ $link->target }}" class=" hover:text-slate-900" href="{{ $link->url }}">{{ $link->title }}</a>
            @endforeach
        </div>
    </nav>

    @yield('content')

    <footer class=" flex flex-col justify-center items-center">
        <div class=" text-slate-800">&copy; {{ config('app.name') }} 2023</div>
    </footer>

    @stack('scripts')
    @vite('resources/js/app.js')
</body>

</html>
