<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        @stack('css')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <center>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
                
                @isset($title)
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $title }}
                    </h2>
                @endisset

                </center>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
            
            
            <div class="d-flex justify-center items-center w-full my-3">
                <div class="gap2">
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.login') }}"><i class="fa fa-solid fa-user-tie me-2"></i>{{ __('Admin Portal') }}</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('lect.login') }}"><i class="fa fa-solid fa-person-chalkboard me-2"></i>{{ __('Lecturer Portal') }}</a>
                    <a class="btn btn-sm btn-primary" href="/"><i class="fa fa-solid fa-user-graduate me-2"></i>{{ __('Student Portal') }}</a>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
            
            @if(session()->has('flash_notification'))
                @foreach(session('flash_notification') as $flash)
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "3000",
                    };

                    // Map 'danger' from PHP to 'error' in Toastr
                    let type = "{{ $flash['level'] }}" === 'danger' ? 'error' : "{{ $flash['level'] }}";

                    // Show the toastr notification
                    toastr[type](
                        "{{ $flash['message'] }}", // message
                        "{{ $flash['title'] }}"    // title
                    );
                @endforeach

                {{-- Clear session flash notifications after rendering --}}
                {{ session()->forget('flash_notification') }}
            @endif
        </script>

        @stack('scripts')

    </body>
</html>
