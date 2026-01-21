<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($type == 'edit')
            {{ __('Edit Class') }}
            @else
            {{ __('Create Class') }}
            @endif
        </h2>
    </x-slot>
    <x-slot name="headerBtn">
        <a class="btn btn-sm btn-secondary" href="{{ route('admin.class.index') }}"><i class="fa fa-arrow-left"></i></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                <section>

                    <form method="post" action="{{ $formRoute }}" class="">
                        @csrf
                        @method('POST')

                        <div class="mt-2">
                            <x-input-label for="code" :value="__('Subject Code')" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $classSubject->code)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('code')" />
                        </div>

                        <div class="mt-2">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $classSubject->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-2">
                            <x-input-label for="lecturer_id" :value="__('Lecturer Assigned')" />
                            {!! Form::select('lecturer_id', $listLecturer, old('status', $classSubject->lecturer_id), [
                                'id' => 'lecturer_id',
                                'class' => 'form-control ' . ($errors->has('lecturer_id') ? ' is-invalid' : ''),
                                'placeholder' => __('Select'),
                            ]) !!}
                            <x-input-error class="mt-2" :messages="$errors->get('lecturer_id')" />
                        </div>

                        <div class="flex items-center gap-4 mt-2">
                            <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>

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
</x-admin-layout>
