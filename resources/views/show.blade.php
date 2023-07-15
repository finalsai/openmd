<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $content->slug }} - PasteMD.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown-light.min.css" integrity="sha512-bm684OXnsiNuQSyrxuuwo4PHqr3OzxPpXyhT66DA/fhl73e1JmBxRKGnO/nRwWvOZxJLRCmNH7FII+Yn1JNPmg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class=" max-w-screen-lg mx-auto bg-slate-50 p-5 h-screen flex flex-col gap-4">
    @if (request()->session()->has('edit'))
    <div class=" p-4 rounded bg-green-600 text-white font-sans text-base select-none cursor-default">
        Your edit password is <b class=" select-all text-lg">{{ request()->session()->get('edit') }}</b>
    </div>
    @endif
    <div id="md" class=" flex-1 w-full rounded p-4 markdown-body">
        @markdown($content->markdown)
    </div>

    <div class=" flex justify-between items-center">
        <div class=" p-2 bg-white text-slate-700 rounded select-none">Already {{ $content->view_count }} people have viewed</div>

        <div class=" flex gap-4 items-center select-none">
            <a href="{{ route('content.edit', ['content' => $content->slug]) }}" class=" px-4 py-1 bg-red-200 disabled:bg-red-100 text-black disabled:text-slate-500 cursor-pointer rounded">Edit</a>
            <a class=" px-4 py-1 text-2xl text-red-600 cursor-pointer rounded" onclick="toggle('report')"><i class="ri-alarm-warning-fill"></i></a>
            <a class=" px-4 py-1 bg-slate-900 text-white cursor-pointer rounded" onclick="exportPng()">Export as .png</a>
            <a class=" px-4 py-1 bg-slate-900 text-white cursor-pointer rounded" onclick="exportPdf()">Export as .pdf</a>
        </div>
    </div>

    <footer class=" mt-8 flex flex-col justify-center items-center">
        <div class=" text-slate-800">&copy; PasteMD</div>
    </footer>

    <div id="report" tabindex="-1" class="fixed top-0 left-0 w-screen min-h-screen z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 justify-center items-center bg-[rgba(0,0,0,0.2)]">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="toggle('report')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this markdown?</h3>
                    <button onclick="report(this)" type="button" class="text-white bg-red-600 hover:bg-red-800 disabled:bg-red-100 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </button>
                    <button onclick="toggle('report')" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    @vite('resources/js/app.js')
    <script>
        function exportPng() {
            domtoimage.toBlob(document.getElementById('md'))
                .then(blob => window.saveAs(blob, 'exported.png'))
                .catch(e => console.error(e));
        }

        function exportPdf() {
            domtopdf(document.getElementById('md'), {
                filename: 'exported.pdf'
            }, (pdf) => {
                console.log('done');
            });
        }

        function toggle(id) {
            const dom = document.getElementById(id);
            if (dom.classList.contains('hidden')) {
                dom.classList.remove('hidden');
                dom.classList.add('flex');
            } else {
                dom.classList.remove('flex');
                dom.classList.add('hidden')
            }
        }

        function report(e) {
            e.setAttribute('disabled', 'disabled');

            fetch('', {
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }).then(() => {
                alert('ok')
            }).finally(() => {
                e.removeAttribute('disabled');
                toggle('report');
            })
        }
    </script>
</body>

</html>