<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ Auth::user()->role == \App\Models\User::LECTURER_ROLE ? __('Lecturer') : __('Student') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
    </style>

    @stack('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="container-fluid">
                    <div class="row align-items-center">

                        <div class="col-md-9">
                            <div class="py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>

                        @isset($headerBtn)
                            <div class="col-md-3 text-end">
                                <div class="py-6 px-4 sm:px-6 lg:px-8">
                                    {{ $headerBtn }}
                                </div>
                            </div>
                        @endisset

                    </div>
                </div>
            </header>

        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
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

        @if (session()->has('flash_notification'))
            @foreach (session('flash_notification') as $flash)
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
                    "{{ $flash['title'] }}" // title
                );
            @endforeach

            {{-- Clear session flash notifications after rendering --}}
            {{ session()->forget('flash_notification') }}
        @endif
    </script>

    @stack('scripts')
</body>

</html>
