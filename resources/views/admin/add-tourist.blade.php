@extends('admin.index')

@section('add-tourist-css')
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
<link href="{{ asset('assets/vendors/toastr.js/toastr.min.css') }}" rel="stylesheet" />
@endsection

@section('add-tourist-scripts')
<script src="{{ asset('assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/vendors/toastr.js/toastr.min.js') }}"></script>
<script>
    $(document).on("DOMContentLoaded", function() {
        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    });
</script>
@endsection

@section('add-tourist')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">EcoPark</a></li>
                <li class="breadcrumb-item active" aria-current="page">Register Tourist</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Register Tourist</h6>
                        <form method="POST" action="{{ route('admin.add-tourist.store') }}">
                            @csrf

                            <div class="row">
                                @if($errors->any())
                                    <div class="alert alert-danger mb-4" role="alert">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tourist name</label>
                                        <input type="text" class="form-control" name="tourist_name" placeholder="Enter tourist name" required>
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" name="gender" required>
                                            <option selected>Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Age</label>
                                        <input type="number" class="form-control" name="age" placeholder="Enter age" required>
                                    </div>
                                </div><!-- Col -->

                            </div><!-- Row -->

                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cellphone No.</label>
                                        <input type="phone" class="form-control" name="cellphone_number" placeholder="Enter cellphone number" required>
                                    </div>
                                </div><!-- Col -->

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Assign Date/Time</label>
                                        <div class="input-group flatpickr" id="flatpickr-datetime-add-tourist">
                                            <input type="text" class="form-control" placeholder="Select date" name="assign_datetime" data-input required>
                                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div><!-- Col -->

                            </div><!-- Row -->

                            <button type="submit" class="btn btn-primary submit">Add Tourist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
