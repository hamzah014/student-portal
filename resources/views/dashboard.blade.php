<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-header">
                                {{ __('Joined Class') }}
                            </div>
                            <div class="card-body">
                                <h2 class="card-title">{{ $totalMyClass }}</h2>
                                <p class="card-text">{{ __('total of class') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
