@extends('admin.index')

@section('registered-tourists-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endsection

@section('registered-tourists-scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
<script>
    $(document).on("DOMContentLoaded", function() {
        $("#registeredTouristsTable").DataTable({
            serverSide: true,
            ajax: "{{ route('admin.registered-tourists') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'gender', name: 'gender', render: (data) => data.charAt(0).toUpperCase() + data.slice(1)},
                {data: 'age', name: 'age', render: (data) => `${data} yrs. old`},
                {data: 'cellphone_number', name: 'cellphone_number', render: (data) => data ?? 'N/A'},
                {data: 'assign_datetime', name: 'assign_datetime', render: (data) => data != null ? moment(data).format('YYYY-MM-DD / hh:mm A') : 'N/A'}
            ],
            dom: '<"row"<"col-12 col-md-6"l><"col-12 col-md-6"f>>' +
                    '<"row"<"col-12"t>>' +
                    '<"row"<"col-12 col-md-5"i><"col-12 col-md-7"p>>',
            lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],
            searching: true,
        });
    });
</script>
@endsection

@section('registered-tourists')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">EcoPark</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registered Tourists</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Registered Tourists</h6>
                    <p class="text-muted mb-3">List of registered tourists and their full information.</p>
                    <div class="table-responsive">
                        <table id="registeredTouristsTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Cellphone No.</th>
                                    <th>Date / Time</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
