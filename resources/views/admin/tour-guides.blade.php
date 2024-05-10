@extends('admin.index')

@section('tour-guides-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endsection

@section('tour-guides-scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/vendors/moment/moment.min.js') }}"></script>
<script>
    $(document).on("DOMContentLoaded", function() {
        $("#tourGuidesTable").DataTable({
            serverSide: true,
            ajax: "{{ route('admin.tour-guides') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'tour_guide_name', name: 'tour_guide_name'},
                {data: 'assigned_datetime', name: 'assigned_datetime', render: (data) => data != null ? moment(data).format('YYYY-MM-DD / hh:mm A') : 'N/A'},
                {data: 'tourist_name', name: 'tourist_name'},
                {data: 'age', name: 'age', render: (data) => `${data} yrs. old`},
                {data: 'gender', name: 'gender', render: (data) => data.charAt(0).toUpperCase() + data.slice(1)},
                {data: 'contact_number', name: 'contact_number', render: (data) => data ?? 'N/A'},
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

@section('tour-guides')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">EcoPark</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assigned Tour Guides</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Assigned Tour Guides</h6>
                    <p class="text-muted mb-3">List of assigned tour guides and their full information.</p>
                    <div class="table-responsive">
                        <table id="tourGuidesTable" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tour Guide Name</th>
                                    <th>Assign Date / Time</th>
                                    <th>Tourist Name</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Cellphone No.</th>
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
