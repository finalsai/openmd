<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize to {{ $content->slug }} - PasteMD.com</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class=" max-w-screen-lg mx-auto bg-slate-50 p-5 h-screen flex flex-col gap-4">
    <div class=" inline-block bg-white mx-auto p-4 rounded uppercase font-bold select-none">paste markdown</div>
    <form action="{{ route('content.auth', ['content' => $content->slug]) }}" method="post" class=" flex-1 flex flex-col items-center justify-center gap-4">
        @csrf
        <input class=" outline outline-slate-200 p-2 rounded bg-white w-full md:max-w-sm" type="text" name="token" placeholder="Enter password" value="{{ old('password') }}" autocomplete="off">

        @if ($errors->any())
        <div class=" bg-red-200 text-slate-900 p-2 rounded">{{ $errors->first() }}</div>
        @endif

        <button type="submit" class=" min-w-[8rem] py-2 rounded bg-zinc-950 text-white">Check In</button>
    </form>

    <footer class=" mt-8 flex flex-col justify-center items-center">
        <div class=" text-slate-800">&copy; PasteMD</div>
    </footer>

    @vite('resources/js/app.js')
</body>

</html>