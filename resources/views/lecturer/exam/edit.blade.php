<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($type == 'edit')
                {{ __('Edit Exam Session') }}
            @else
                {{ __('Create Exam Session') }}
            @endif
        </h2>
    </x-slot>
    <x-slot name="headerBtn">
        <a class="btn btn-sm btn-secondary" href="{{ route('lect.exam.index') }}"><i class="fa fa-arrow-left"></i></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="tabMenu" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="detail-tab" data-bs-toggle="tab"
                                    data-bs-target="#detail" type="button" role="tab"
                                    aria-controls="detail" aria-selected="true">Details</a>
                            </li>
                            @if ($type == 'edit')
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="question-tab" data-bs-toggle="tab"
                                    data-bs-target="#question" type="button" role="tab"
                                    aria-controls="question" aria-selected="false">Questionnaire</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <div class="tab-pane fade show active" id="detail" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                @include('lecturer.exam.partial.detail')
                            </div>
                            @if ($type == 'edit')
                            <div class="tab-pane fade" id="question" role="tabpanel"
                                aria-labelledby="profile-tab" tabindex="0">
                                @include('lecturer.exam.partial.question')
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabLinks = document.querySelectorAll('#tabMenu a[data-bs-toggle="tab"]');
                tabLinks.forEach(function (tabLink) {
                    tabLink.addEventListener('shown.bs.tab', function (e) {
                        const tabId = e.target.getAttribute('data-bs-target').substring(1);
                        const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tab=' + tabId;
                        window.history.replaceState({ path: newUrl }, '', newUrl);
                    });
                });

                const urlParams = new URLSearchParams(window.location.search);
                const tabId = urlParams.get('tab') || 'home-tab-pane';
                const targetTab = document.querySelector('#tabMenu a[data-bs-target="#' + tabId + '"]');

                if (targetTab) {
                    const tabInstance = new bootstrap.Tab(targetTab);
                    tabInstance.show();
                }
            });

        </script>


    @endpush
</x-app-layout>
