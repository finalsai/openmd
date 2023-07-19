@extends('layouts.common')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown-light.min.css" integrity="sha512-bm684OXnsiNuQSyrxuuwo4PHqr3OzxPpXyhT66DA/fhl73e1JmBxRKGnO/nRwWvOZxJLRCmNH7FII+Yn1JNPmg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.min.css" integrity="sha512-13RM4Q4wPLiDEFNxKQbZMoyM3qR3eIsTYoXy6hJlqWmPzFCBLyxG3LGx/48N+sTcLxvN3IoThkZYxo3yuaGSvw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')

@if (request()->session()->has('edit'))
<div class=" p-4 rounded bg-green-600 text-white font-sans text-base select-none cursor-default">
    Your edit password is <b class=" select-all text-lg">{{ request()->session()->get('edit') }}</b>
</div>
@endif

<section>
    <main id="md" class=" flex-1 w-full rounded p-4 markdown-body">
        @markdown($content->markdown)
    </main>

    <footer class=" p-1 text-xs text-slate-600 rounded select-none flex justify-between">
        <p class=" uppercase">
        visits: {{ $content->view_count }}
        </p>
        <p class=" uppercase">
        updated: {{ $content->updated_at }}
        </p>
    </footer>
</section>

<div class=" grid grid-cols-2 md:flex flex-row gap-4 md:justify-end md:items-center">
    <a id="spam" class=" px-4 py-1 bg-red-700 hover:bg-red-600 text-white cursor-pointer rounded uppercase w-full md:w-auto" onclick="toggle('report')"><i class="ri-spam-2-line"></i> Spam</a>
    <a class=" px-4 py-1 bg-red-200 hover:bg-red-100 disabled:bg-red-100 text-black disabled:text-slate-500 cursor-pointer rounded uppercase" href="{{ route('content.edit', ['content' => $content->slug]) }}">Edit</a>
    <a id="png" class=" px-4 py-1 bg-slate-900 hover:bg-slate-700 text-white cursor-pointer rounded uppercase"><i class="ri-image-line"></i> Export .png</a>
    <a id="pdf" class=" px-4 py-1 bg-slate-900 hover:bg-slate-700 text-white cursor-pointer rounded uppercase"><i class="ri-file-pdf-line"></i> Export .pdf</a>
</div>

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
@endsection

@push('scripts')
<script>
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
@endpush
