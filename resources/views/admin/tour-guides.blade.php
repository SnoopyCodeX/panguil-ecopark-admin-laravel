@extends('admin.index')

@section('tour-guides-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endsection

@section('tour-guides-scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>
@endsection

@section('tour-guides')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">EcoPark</a></li>
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
                        <table id="dataTableExample" class="table">
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
                                <tr>
                                    <td>1</td>
                                    <td>Mang Berting</td>
                                    <td>2023-06-12 / 12:40 PM</td>
                                    <td>Tiger Nixon</td>
                                    <td>Male</td>
                                    <td>25 yrs old</td>
                                    <td>091234567</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Mang Roberto</td>
                                    <td>2023-06-12 / 12:40 PM</td>
                                    <td>Mary Jane Dela Cruz</td>
                                    <td>Female</td>
                                    <td>28 yrs old</td>
                                    <td>091234567</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Mang Raul</td>
                                    <td>2023-06-12 / 12:40 PM</td>
                                    <td>Robert Santos</td>
                                    <td>Male</td>
                                    <td>30 yrs old</td>
                                    <td>091234567</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
