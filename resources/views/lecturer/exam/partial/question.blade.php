@push('css')

    <style>

    </style>
    
@endpush


<div class="py-2">
    <form method="POST" action="{{ route('lect.exam.question', $examSession) }}">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Create Questionnaire</h5>
            </div>

            <div class="card-body">

                <!-- Questions -->
                <div id="questions-wrapper">
                    @foreach ($questions as $question )
                    
                        <div class="card mb-3 question-item" data-index="qi-{{ $question->id }}">
                            <div class="card-body">

                                <input type="hidden" name="questionIndex[]" value="qi-{{ $question->id }}">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Question</strong>
                                    <button type="button" class="btn btn-sm btn-danger btn-remove-question">
                                        Remove
                                    </button>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <input type="text"
                                        class="form-control"
                                        name="questions[qi-{{ $question->id }}][title]"
                                        value="{{ $question->quest_text }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Answer Type</label>
                                    {!! Form::select(
                                        "questions[qi-{$question->id}][type]",
                                        $questionType,
                                        $question->quest_type,
                                        [
                                            'id' => "question_type_{$question->id}",
                                            'class' => 'form-select question-type',
                                            'placeholder' => __('Select'),
                                            'data-question-id' => $question->id, // optional but useful
                                        ]
                                    ) !!}
                                </div>

                                <!-- MCQ -->
                                <div class="mcq-wrapper @if($question->quest_type == 'text') d-none @endif">
                                    <label class="form-label">Options <small class="text-muted">(select correct answer)</small></label>
                                    <div class="options-wrapper">
                                        @foreach ($question->questionOption as $option )
                                        
                                            <div class="input-group mb-2 align-items-center">
                                                <div class="input-group-text">
                                                    <input type="radio"
                                                        name="questions[qi-{{ $question->id }}][correct]"
                                                        value="opt-{{ $option->id }}" @if($option->is_answer == 1) checked @endif>
                                                </div>

                                                <input type="text"
                                                    class="form-control"
                                                    name="questions[qi-{{ $question->id }}][options][opt-{{ $option->id }}]"
                                                    value="{{ $option->option_text }}"
                                                    placeholder="Option text"
                                                    required>

                                                <button type="button" class="btn btn-outline-danger btn-remove-option">
                                                    ×
                                                </button>
                                            </div>
                                            
                                        @endforeach
                                    </div>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary btn-add-option mt-2">
                                        + Add Option
                                    </button>
                                </div>

                            </div>
                        </div>
                        
                    @endforeach
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-4 area-action">
                    <button type="button" class="btn btn-outline-primary btn-add-question">
                        + Add Question
                    </button>

                    <button type="submit" class="btn btn-success ms-auto">
                        Save Questionnaire
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

@push('scripts')

<script>
    $(document).ready(function () {

        let questionIndex = 0;

        $(document).on('click', '.btn-add-question', function () {
            // questionIndex++;
            var questionIndex = Math.random().toString(36).substring(2, 7).toUpperCase();

            let html = `
            <div class="card mb-3 question-item" data-index="${questionIndex}">
                <div class="card-body">

                    <input type="hidden" name="questionIndex[]" value="${questionIndex}">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Question</strong>
                        <button type="button" class="btn btn-sm btn-danger btn-remove-question">
                            Remove
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text"
                            class="form-control"
                            name="questions[${questionIndex}][title]"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer Type</label>
                        <select class="form-select question-type" name="questions[${questionIndex}][type]">
                            <option value="text">Text</option>
                            <option value="mcq">Multiple Choice</option>
                        </select>
                    </div>

                    <!-- MCQ -->
                    <div class="mcq-wrapper d-none">
                        <label class="form-label">Options <small class="text-muted">(select correct answer)</small></label>
                        <div class="options-wrapper"></div>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary btn-add-option mt-2">
                            + Add Option
                        </button>
                    </div>

                </div>
            </div>
            `;

            $('#questions-wrapper').append(html);
        });

        $(document).on('click', '.btn-remove-question', function () {
            let card = $(this).closest('.question-item');
            let qIndex = card.data('index');
            isData = qIndex.indexOf('qi-');

            //if existing data
            if(isData == 0){
                var id = qIndex.replace('qi-', '');
                removeQuest = removeQuestion(id);
            }

            $(this).closest('.question-item').remove();
        });

        $(document).on('change', '.question-type', function () {
            let card = $(this).closest('.question-item');
            let mcqWrapper = card.find('.mcq-wrapper');

            if ($(this).val() === 'mcq') {
                mcqWrapper.removeClass('d-none');
            } else {
                mcqWrapper.addClass('d-none');
                mcqWrapper.find('.options-wrapper').empty();
            }
        });

        $(document).on('click', '.btn-add-option', function () {
            let card = $(this).closest('.question-item');
            let qIndex = card.data('index');
            let optionsWrapper = card.find('.options-wrapper');
            let optionIndex = optionsWrapper.children().length;

            optionIndex = Math.random().toString(36).substring(2, 7).toUpperCase();

            let html = `
            <div class="input-group mb-2 align-items-center">
                <div class="input-group-text">
                    <input type="radio"
                        name="questions[${qIndex}][correct]"
                        value="${optionIndex}">
                </div>

                <input type="text"
                    class="form-control"
                    name="questions[${qIndex}][options][${optionIndex}]"
                    placeholder="Option text"
                    required>

                <button type="button" class="btn btn-outline-danger btn-remove-option">
                    ×
                </button>
            </div>
            `;

            optionsWrapper.append(html);
        });

        $(document).on('click', '.btn-remove-option', function () {
            $(this).closest('.input-group').remove();
        });

        function removeQuestion(id){

            var route = '{{ route('lect.exam.question.remove') }}';
            
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
                        toastr.success('{{ __('Successfully remove.') }}')
                        return true;
                    } else {
                        toastr.error(response.message);
                        return false;
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

        }

    });
</script>

    
@endpush