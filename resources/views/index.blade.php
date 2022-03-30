@extends('layout.layout')
@section('section')
    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif
    <div>
        {{-- <form action="" id="awcawe">
            @method('DELETE')
        </form> --}}
        <a href="{{ route('user.create') }}" class="btn btn-primary">Add</a>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@push('after-script')
    <script>
        $(document).ready(function() {
            var tb = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": true,
                ajax: {
                    url: "{{ route('ajax') }}",
                    type: "GET",
                },
                columns: [{
                        "data": "id",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'created_at_obj',
                        name: 'created_at_obj'
                    },
                    {
                        data: 'updated_at_obj',
                        name: 'updated_at_obj'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        });

        $('.display').on('click', '#btn-delete', function(e) {
            e.preventDefault();
            let idd = $(this).data('id');
            // alert(idd);
            Swal.fire({
                title: 'Are you sure want to delete this user?',
                showCancelButton: true,
                confirmButtonText: ['Yes'],
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete' + idd).submit();
                    // Swal.fire('Saved!', '', 'success')
                }
            })
        });
    </script>
@endpush
