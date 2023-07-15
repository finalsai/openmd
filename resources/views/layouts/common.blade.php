<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'text.is')</title>

    @stack('styles')
    @vite('resources/css/app.css')
</head>

<body class=" max-w-screen-lg mx-auto bg-slate-50 p-5 h-screen flex flex-col gap-4">
    <div class=" inline-block bg-white mx-auto p-4 rounded uppercase font-bold select-none">text.is</div>

    @yield('content')

    <footer class=" mt-8 flex flex-col justify-center items-center">
        <div class=" text-slate-800">&copy; text.is 2023</div>
    </footer>

    @stack('scripts')
    @vite('resources/js/app.js')
</body>

</html>