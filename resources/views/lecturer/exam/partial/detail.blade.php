
<section>

    <form method="post" action="{{ $formRoute }}" class="">
        @csrf
        @method('POST')

        <div class="mt-2">
            <x-input-label for="title" :value="__('Exam Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $examSession->title)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div class="mt-2">
            <x-input-label for="class_id" :value="__('Subject Assigned')" />
            {!! Form::select('class_id', $subjectList, old('status', $examSession->class_id), [
                'id' => 'class_id',
                'class' => 'form-control ' . ($errors->has('class_id') ? ' is-invalid' : ''),
                'placeholder' => __('Select'),
            ]) !!}
            <x-input-error class="mt-2" :messages="$errors->get('class_id')" />
        </div>
        <hr>
        <h5 class="mt-2">{{ __('Session Duration Availability') }}</h5>
        <div class="mt-2 row">

            <div class="col-md-6">
                <x-input-label for="start_at" :value="__('Start Session')" />
                <x-text-input id="start_at" name="start_at" type="datetime-local" class="mt-1 block w-full" :value="old('start_at', $examSession->start_at)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('start_at')" />
            </div>
            <div class="col-md-6">
                <x-input-label for="end_at" :value="__('End Session')" />
                <x-text-input id="end_at" name="end_at" type="datetime-local" class="mt-1 block w-full" :value="old('end_at', $examSession->end_at)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('end_at')" />
            </div>

        </div>

        <div class="mt-2">
            <x-input-label for="duration_min" :value="__('Duration Session (minute)')" />
            <x-text-input id="duration_min" name="duration_min" type="text" class="mt-1 block w-full" :value="old('duration_min', $examSession->duration_min)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('duration_min')" />
        </div>

        <div class="flex items-center gap-4 mt-2">
            <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>

    </form>
</section>