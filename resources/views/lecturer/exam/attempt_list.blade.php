
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Student Exam') }}
        </h2>
    </x-slot>
    <x-slot name="headerBtn">
        <a class="btn btn-sm btn-secondary" href="{{ route('lect.exam.index') }}"><i class="fa fa-arrow-left"></i></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                <section>

                    <div class="table-responsive-md">
                        <table class="table table-striped table-bordered custom-class">

                            <thead>
                                <th>Name</th>
                                <th>Start At</th>
                                <th>End At</th>
                                <th>Score</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if (count($studentAttempt) > 0)
                                    
                                    @foreach($studentAttempt as $sAttempt )
                                        <tr>
                                            <td>{{ $sAttempt->student?->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sAttempt->start_at)->format('d M Y, h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sAttempt->end_at)->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <span class="">{{ $sAttempt->score ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary btn-approve" href="{{ route('lect.exam.attempt.detail', $sAttempt->id) }}"><i class="fa fa-eye me-2"></i>{{ __('Details') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="5">
                                        <center><span class="text-secondary"><i>No data in the list.</i></span></center>
                                    </td>
                                </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>

                </section>

            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                
            });
        </script>

    @endpush
</x-app-layout>
