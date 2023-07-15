<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PasteMD</title>
    <link rel="stylesheet" href="https://unpkg.com/vditor/dist/index.css" />
    @vite('resources/css/app.css')
</head>

<body class=" max-w-screen-lg mx-auto bg-slate-50 p-5 h-screen flex flex-col">
    <div class=" inline-block bg-white mx-auto p-4 rounded uppercase font-bold select-none">paste markdown</div>
    <div class=" mt-8 flex-1 flex flex-col">
        <div id="area" class=" flex-1"></div>

        @if($errors->any())
        <div class=" mt-4 bg-red-200 text-black p-2 rounded">{{ $errors->first() }}</div>
        @endif

        <form name="mainform" action="" method="post" onsubmit="event.preventDefault()" class=" mt-4 flex items-center justify-between">
            @csrf
            <input type="hidden" name="markdown">
            <input type="text" name="slug" placeholder="Custom URL" value="{{ old('slug') }}" id="slug" class=" outline outline-slate-200 p-2 rounded bg-white" autocomplete="off">
            <input type="text" name="edit" placeholder="Edit Password" value="{{ old('edit') }}" id="edit" class=" outline outline-slate-200 p-2 rounded bg-white" autocomplete="off">
            <input type="text" name="access" placeholder="Access Password" value="{{ old('access') }}" id="access" class=" outline outline-slate-200 p-2 rounded bg-white" autocomplete="off">

            <label class="relative inline-flex items-center cursor-pointer select-none">
                <input type="checkbox" name="onetime" value="1" @checked(old('onetime')) class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 uppercase">Burn after read</span>
            </label>

            <button onclick="submitForm()" class=" min-w-[8rem] py-2 rounded bg-zinc-950 text-white">Go</button>
        </form>
    </div>
    <footer class=" mt-8 flex flex-col justify-center items-center">
        <div class=" text-slate-800">&copy; PasteMD</div>
    </footer>

    <script src="https://unpkg.com/vditor/dist/index.min.js"></script>
    @vite('resources/js/app.js')
    <script>
        const vditor = new Vditor('area', {
            height: '100%',
            toolbar: [
                'emoji', 'headings', 'bold', 'italic', 'strike', '|',
                'line', 'quote', 'list', 'ordered-list', 'check',
                'outdent', 'indent', 'code', 'inline-code',
                'insert-after', 'insert-before', 'undo', 'redo',
                'link', 'table', 'record', 'fullscreen', 'outline',
                'export', 'br',
            ]
        });

        function submitForm() {
            document.getElementsByName('markdown')[0].value = vditor.getValue();
            vditor.clearStack();
            document.forms['mainform'].submit();
        }
    </script>
</body>

</html>