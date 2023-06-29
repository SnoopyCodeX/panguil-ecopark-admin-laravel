@extends('admin.index')

@section('reservations-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endsection

@section('reservations-scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script>
    $(document).on("DOMContentLoaded", function() {
        $("#reservationsTable").DataTable({
            serverSide: true,
            ajax: "{{ route('admin.reservations') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'gender', name: 'gender'},
                {data: 'age', name: 'age'},
                {data: 'contact_number', name: 'contact_number'},
                {data: 'created_at', name: 'created_at'},
                {data: 'number_of_tourists', name: 'number_of_tourists'},
                {data: 'assigned_tour_guide', name: 'assigned_tour_guide'},
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

@section('reservations')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">EcoPark</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reservations</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Tourist Reservations</h6>
                    <p class="text-muted mb-3">List of tourist reservations along with their complete information and assigned tour guide.</p>
                    <div class="table-responsive">
                        <table id="reservationsTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Cellphone No.</th>
                                    <th>Date / Time</th>
                                    <th>Number of Tourists</th>
                                    <th>Assigned Tour GUide</th>
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
