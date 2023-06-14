@extends('admin.index')

@section('assign-tour-guide-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
@endsection

@section('assign-tour-guide-scripts')
<script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
@endsection

@section('assign-tour-guide')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">EcoPark</a></li>
                <li class="breadcrumb-item active" aria-current="page">Assign Tour Guide</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Assign a Tour Guide</h6>
                        <form method="POST" autocomplete="off">
                            @csrf
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tour guide name</label>
                                        <input type="text" class="form-control" placeholder="Enter tour guide name">
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Assign Date/Time</label>
                                        <div class="input-group flatpickr" id="flatpickr-datetime-assign-tour-guide">
                                            <input type="text" class="form-control" placeholder="Select date" data-input>
                                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tourist Name</label>
                                        <input type="text" class="form-control" placeholder="Enter tourist name">
                                    </div>
                                </div><!-- Col -->

                            </div><!-- Row -->

                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Age</label>
                                        <input type="number" class="form-control" placeholder="Enter age">
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select">
                                            <option selected>Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cellphone No.</label>
                                        <input type="phone" class="form-control" placeholder="Enter cellphone number">
                                    </div>
                                </div><!-- Col -->

                            </div><!-- Row -->
                        </form>

                        <button type="button" class="btn btn-primary submit">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
