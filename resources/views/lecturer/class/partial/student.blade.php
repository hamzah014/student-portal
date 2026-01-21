@push('css')

    <style>
        .badge-request{
            background: grey;
        }
        .badge-approve{
            background: green;
        }
    </style>
    
@endpush

<section>

    <div class="table-responsive-md">
        <table class="table table-striped table-bordered custom-class">

            <thead>
                <th>Name</th>
                <th>Joined at</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                @if (count($classStudent) > 0)
                    
                    @foreach($classStudent as $cStudent )
                        <tr>
                            <td>{{ $cStudent->student?->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($cStudent->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $cStudent->status }}">{{ strtoUpper($cStudent->status) }}</span>
                            </td>
                            <td>
                                @if($cStudent->status == 'request')
                                    <button type="button" class="btn btn-sm btn-primary btn-approve" data-id="{{ $cStudent->id }}" data-title="{{ $cStudent->student->name }}"><i class="fa fa-check-circle mx-2"></i>{{ __('Approved') }}</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="4">
                        <center><span class="text-secondary"><i>No student on the list.</i></span></center>
                    </td>
                </tr>
                @endif
            </tbody>

        </table>
    </div>

</section>

@push('scripts')

    @include('myclass.inc.script')

@endpush