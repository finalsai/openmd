<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'text.is')</title>

    @stack('styles')
    @vite('resources/css/app.css')
</head>

<body class=" max-w-screen-lg mx-auto bg-slate-50 p-5 h-screen flex flex-col gap-8">
    <nav class=" w-full bg-white mx-auto p-4 rounded select-none flex justify-between">
        <div class=" uppercase font-bold">text.is</div>
        <div class=" flex gap-4 text-base text-slate-600 transition-colors">
            <!-- <a class=" hover:text-slate-900" href="">What</a>
            <a class=" hover:text-slate-900" href="">How</a>
            <a class=" hover:text-slate-900" href="">Lang</a>
            <a class=" hover:text-slate-900" href="">Contact</a> -->
        </div>
    </nav>

    @yield('content')

    <footer class=" flex flex-col justify-center items-center">
        <div class=" text-slate-800">&copy; text.is 2023</div>
    </footer>

    @stack('scripts')
    @vite('resources/js/app.js')
</body>

</html>