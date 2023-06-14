@extends('admin.index')

@section('registered-tourists-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
@endsection

@section('registered-tourists-scripts')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>
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
                        <table id="dataTableExample" class="table">
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
                                <tr>
                                    <td>1</td>
                                    <td>Tiger Nixon</td>
                                    <td>Male</td>
                                    <td>25 yrs old</td>
                                    <td>09123456789</td>
                                    <td>2023-04-25 / 10:30 AM</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Mary Jane Dela Cruz</td>
                                    <td>Female</td>
                                    <td>28 yrs old</td>
                                    <td>09123456789</td>
                                    <td>2023-04-15 / 10:30 AM</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Robert Santos</td>
                                    <td>Male</td>
                                    <td>30 yrs old</td>
                                    <td>09123456789</td>
                                    <td>2023-04-05 / 10:30 AM</td>
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
