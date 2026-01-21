<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exam') }} - {{ $examSession->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                <section>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <x-input-label :value="__('Subject :')" />
                            <h5>{{ $examSession->classSubject->name }}</h5>
                        </div>
                        @if ($studentAttempt)

                            <div>
                                @if ($studentAttempt->submit_at == null)
                                <x-input-label :value="__('Duration :')" />
                                <h5 id="exam-duration">{{ $examSession->duration_min }}:00 minutes</h5>
                                @else
                                <x-input-label :value="__('Submitted at :')" />
                                <h5>{{ \Carbon\Carbon::parse($studentAttempt->submit_at)->format('d M Y, h:i A') }}</h5>
                                @endif
                            </div>
                        
                            @if($studentAttempt->result_at != null)
                            <div>
                                <h5>Marks: <large>{{ $studentAttempt->score }}%</large></h5>
                            </div>
                            @endif
                        @else
                            <div>
                                <x-input-label :value="__('Duration :')" />
                                <h5>{{ $examSession->duration_min }}:00 minutes</h5>
                            </div>
                        @endif
                    </div>
                </section>

                @if ($studentAttempt)
                
                <section class="mt-4">
                    <form id="exam-form" method="POST" action="{{ route('exam.submit', $examSession->id) }}">
                        @csrf

                        <div id="questions-wrapper">
                            @foreach($examSession->questions as $qIndex => $question)
                                <input name="attemptId" value="{{ $studentAttempt->id }}" type="hidden">
                                <input name="questionIndex[]" value="answ-{{ $question->id }}" type="hidden">

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-between items-center">
                                            <div>
                                                <strong>Question {{ $loop->iteration }}:</strong>
                                                <p>{{ $question->quest_text }}</p>
                                            </div>
                                            <div>
                                                @if (isset($studentAnswerResult['answ-' . $question->id]) && $studentAnswerResult['answ-' . $question->id] !== null)
                                                    @if ($studentAnswerResult['answ-' . $question->id] == 1)
                                                        <h5 class="text-success">Correct <i class="fa-regular fa-circle-check"></i></h5>
                                                    @else
                                                        <h5 class="text-danger">Wrong <i class="fa-regular fa-circle-xmark"></i></h5>
                                                        @if($question->quest_type === 'mcq')
                                                        <small class="text-danger">Answer: {{ $studentAnswer['answ-' . $question->id] }}</small>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>

                                        </div>

                                        @if($question->quest_type === 'text')
                                            <textarea class="form-control mb-2"
                                                      name="answers[answ-{{ $question->id }}]"
                                                      placeholder="Type your answer here">{{ $studentAnswer['answ-' . $question->id] ?? null }}</textarea>
                                        @elseif($question->quest_type === 'mcq')
                                            <div>
                                                @foreach($question->questionOption as $oIndex => $option)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="answers[answ-{{ $question->id }}]"
                                                               id="q{{ $qIndex }}o{{ $oIndex }}"
                                                               value="{{ $option->id }}"
                                                               @if(isset($studentAnswer['answ-' . $question->id]) && $studentAnswer['answ-' . $question->id] == $option->id) checked @endif>
                                                        <label class="form-check-label" for="q{{ $qIndex }}o{{ $oIndex }}">
                                                            {{ $option->option_text }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($studentAttempt->submit_at == null)
                        <button type="submit" class="btn btn-success">Submit Exam</button>
                        @endif
                    </form>
                </section>

                @else

                <section class="p-5 d-flex justify-center items-center text-center">
                    <div>
                        <h5>Please answer all question.</h5>
                        <button  type="button" class="btn btn-lg btn-primary btn-start" data-id="{{ $examSession->id }}">{{ __('Start Exam') }}</button>
                    </div>
                </section>
                    
                @endif


            </div>
        </div>
    </div>
    @push('scripts')
    
    <script>
        $(document).ready(function() {
            // ===== Countdown Timer =====
            let duration = {{ $examSession->duration_min }} * 60; // in seconds
            let display = $('#exam-duration');

            function startTimer(duration, display) {
                let timer = duration, minutes, seconds;
                let countdown = setInterval(function() {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.text(minutes + ":" + seconds + " minutes");

                    if (--timer < 0) {
                        clearInterval(countdown);
                        alert("Time is up! The exam will be submitted automatically.");
                        $('#exam-form').submit();
                    }
                }, 1000);
            }

            @if ($studentAttempt && $studentAttempt->submit_at == null)
                startTimer(duration, display);
            @endif

            $(document).on('click', '.btn-start', function () {

                let id = $(this).data('id');
                var route = '{{ route('exam.session') }}';
                
                var formData = new FormData();
                formData.append('id', id);
                        
                $.ajax({
                    url: route,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        if (response.success) {
                            window.location.reload(true);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(error) {
                        
                        console.log('error', error);

                        var response = error.responseJSON;
                        console.log(response);

                        if (response && response.error) {
                            // Laravel validation errors
                            var messages = [];

                            for (var field in response.error) {
                                if (response.error.hasOwnProperty(field)) {
                                    messages.push(response.error[field].join(', '));
                                }
                            }

                            alert('Error:\n' + messages.join('\n'));
                        } 
                        else if (response && response.message) {
                            // Other error message
                            alert('Error - ' + response.message);
                        } 
                        else {
                            alert('An unknown error occurred!');
                        }

                        return false;
                    }
                });
            });

        });

    </script>

    @endpush
</x-app-layout>
