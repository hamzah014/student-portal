
<section>

    <div class="mt-2">
        <x-input-label for="code" :value="__('Subject Code')" />
        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $classSubject->code)" disabled />
    </div>

    <div class="mt-2">
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $classSubject->name)" disabled/>
    </div>

    <div class="mt-2">
        <x-input-label for="lecturer_id" :value="__('Lecturer Assigned')" />
        {!! Form::select('lecturer_id', $listLecturer, old('status', $classSubject->lecturer_id), [
            'id' => 'lecturer_id',
            'class' => 'form-control ' . ($errors->has('lecturer_id') ? ' is-invalid' : ''),
            'placeholder' => __('Select'),
            'disabled'
        ]) !!}
    </div>


</section>