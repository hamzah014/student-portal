
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Student Answer') }}
        </h2>
    </x-slot>
    <x-slot name="headerBtn">
        <a class="btn btn-sm btn-secondary" href="{{ route('lect.exam.attempt', $examSession->id) }}"><i class="fa fa-arrow-left"></i></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                
                <section>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <div>
                            <x-input-label :value="__('Student Name :')" />
                            <h5>{{ $student->name }}</h5>
                        </div>
                        <div>
                            <x-input-label :value="__('Subject :')" />
                            <h5>{{ $examSession->classSubject->name }}</h5>
                        </div>
                    </div>
                </section>
                
                <section class="mt-4">
                    <form id="exam-form" method="POST" action="{{ route('lect.exam.attempt.result', $studentAttempt->id) }}">
                        @csrf

                        <div id="questions-wrapper">
                            @foreach($examSession->questions as $qIndex => $question)
                                <input name="attemptId" value="{{ $studentAttempt->id }}" type="hidden">

                                <input name="answers[answ-{{ $question->id }}][id]" value="{{ $question->id }}" type="hidden">
                                <input name="answers[answ-{{ $question->id }}][answerid]" value="{{ $studentAnswer['answ-' . $question->id]['id'] }}" type="hidden">

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex items-center justify-between">
                                            <div>    
                                                <strong>Question {{ $loop->iteration }}:</strong>
                                                <p>{{ $question->quest_text }}</p>
                                            </div>
                                            <div class="d-flex justify-center gap-2">
                                                <p>Result :</p>
                                                @foreach($answerStatus as $anIndex => $anStatus)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="answers[answ-{{ $question->id }}][correct]"
                                                               id="stat{{ $qIndex }}o{{ $anIndex }}"
                                                               value="{{ $anIndex }}"
                                                               @if($studentAnswer['answ-' . $question->id] && $studentAnswer['answ-' . $question->id]['correct'] != null && $studentAnswer['answ-' . $question->id]['correct'] == $anIndex) checked @endif>
                                                        <label class="form-check-label" for="stat{{ $qIndex }}o{{ $anIndex }}">
                                                            {{ $anStatus }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        @if($question->quest_type === 'text')
                                            <textarea class="form-control mb-2"
                                                      name="answers[answ-{{ $question->id }}][choice]"
                                                      placeholder="Type your answer here">{{ $studentAnswer['answ-' . $question->id]['choice'] }}</textarea>
                                        @elseif($question->quest_type === 'mcq')
                                            <div>
                                                @foreach($question->questionOption as $oIndex => $option)
                                                    <div class="form-check 
                                                        @if($option->is_answer == 1) 
                                                        border 
                                                        @if($studentAnswer['answ-' . $question->id] && $studentAnswer['answ-' . $question->id]['choice'] == $option->id ) 
                                                        border-success
                                                        @else
                                                        border-danger
                                                        @endif  
                                                        border-2 rounded
                                                        @endif
                                                        ">
                                                        <input class="form-check-input" type="radio"
                                                               name="answers[answ-{{ $question->id }}][choice]"
                                                               id="q{{ $qIndex }}o{{ $oIndex }}"
                                                               value="{{ $option->id }}"
                                                               @if($studentAnswer['answ-' . $question->id] && $studentAnswer['answ-' . $question->id]['choice'] == $option->id) checked @endif>
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
                        @if ($studentAttempt->result_at == null)   
                            <button type="submit" class="btn btn-success">Submit Exam</button>
                        @endif
                    </form>
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
