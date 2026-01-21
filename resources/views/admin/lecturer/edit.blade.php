<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($type == 'edit')
            {{ __('Edit Lecturer') }}
            @else
            {{ __('Create Lecturer') }}
            @endif
        </h2>
    </x-slot>
    <x-slot name="headerBtn">
        <a class="btn btn-sm btn-secondary" href="{{ route('admin.lect.index') }}"><i class="fa fa-arrow-left"></i></a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                <section>

                    <form method="post" action="{{ $formRoute }}" class="">
                        @csrf
                        @method('POST')

                        <div class="mt-2">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $lecturer->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-2">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $lecturer->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        @if($type == 'edit')
                        <div class="mt-2">
                            <x-input-label for="refer_code" :value="__('Reference Code')" />
                            <div class="input-group">
                                <input type="text" name="refer_code" id="refer_code" class="form-control" placeholder="{{ __('Reference code') }}" aria-label="{{ __('Reference code') }}" value="{{ old('refer_code', $lecturer->refer_code) }}" disabled>
                                <span class="input-group-text copy-btn " role="button" title="Copy to clipboard"><i class="fa fa-copy"></i></span>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('refer_code')" />
                        </div>
                        <div class="mt-2">
                            <x-input-label for="status" :value="__('Status')" />
                            {!! Form::select('status', $status_lect, old('status', $lecturer->email_verified_at ? 'active' : 'pending'), [
                                'id' => 'status',
                                'class' => 'form-control ' . ($errors->has('status') ? ' is-invalid' : ''),
                                'placeholder' => __('Select'),
                                'disabled'
                            ]) !!}
                        </div>
                        @endif

                        
                        <div class="flex items-center gap-4 mt-2">
                            <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                        </div>

                    </form>
                </section>


            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                
                $('.copy-btn').click(function() {
                    // Select the input
                    var $input = $('#refer_code');
                    
                    // Create a temporary textarea to copy (works reliably)
                    var $temp = $('<textarea>');
                    $('body').append($temp);
                    $temp.val($input.val()).select();
                    document.execCommand('copy'); // Copy to clipboard
                    $temp.remove();

                    // Optional feedback
                    toastr.success('Copy code completed!');
                });
            });
        </script>

    @endpush
</x-admin-layout>
