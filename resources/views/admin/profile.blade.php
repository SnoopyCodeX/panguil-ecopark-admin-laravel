@extends('admin.index')

@section('profile-css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/dropify.min.css') }}">
    <link href="{{ asset('assets/vendors/toastr.js/toastr.min.css') }}" rel="stylesheet" />
@endsection


@section('profile-scripts')
    <script src="{{ asset('assets/vendors/dropify/dist/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr.js/toastr.min.js') }}"></script>
    <script>
        $(document).on("DOMContentLoaded", function() {
            $('#profilePhotoDropify').dropify();

            let oldFormData = $('#updateForm').serialize();

            $('#updateForm').on('submit', function(e) {
                if($('#updateForm').serialize() == oldFormData && $('#profilePhotoDropify')[0].files.length === 0)
                    e.preventDefault();
            });

            $('#old_password').on('change', function() {
                if($('#updateForm').serialize() != oldFormData) {
                    $('#confirm_password').prop('required', 'true');
                    $('#new_password').prop('required', 'true');
                } else {
                    $('#confirm_password').removeAttr('required');
                    $('#new_password').removeAttr('required');
                }
            });

            $('#new_password').on('change', function() {
                if($('#updateForm').serialize() != oldFormData) {
                    $('#confirm_password').prop('required', 'true');
                    $('#old_password').prop('required', 'true');
                } else {
                    $('#confirm_password').removeAttr('required');
                    $('#old_password').removeAttr('required');
                }
            });

            $('#confirm_password').on('change', function() {
                if($('#updateForm').serialize() != oldFormData) {
                    $('#new_password').prop('required', 'true');
                    $('#old_password').prop('required', 'true');
                } else {
                    $('#new_password').removeAttr('required');
                    $('#old_password').removeAttr('required');
                }
            });

            @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @elseif(Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif
        });
    </script>
@endsection

@section('profile')
    <div class="page-content">
        <div class="row profile-body">
            <!-- left wrapper start -->
            <div class="d-md-block col-md-4 col-xl-3 left-wrapper mb-4">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center mb-2">
                            <img class="flex-item wd-100 ht-100 rounded-circle mb-2" src="{{ app()->isProduction() ? Auth::user()->photo : asset('uploads/profiles/' . Auth::user()->photo) ?? 'https://via.placeholder.com/100x100' }}" alt="profile">
                            <h6 class="flex-item card-title mb-0">{{ Auth::user()->name }}</h6>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Age:</label>
                            <p class="text-muted">{{ Auth::user()->age }} yrs. old</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Gender:</label>
                            <p class="text-muted">{{ Str::ucfirst(Auth::user()->gender) }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Email Address:</label>
                            <p class="text-muted">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Updated On:</label>
                            <p class="text-muted">{{ \Carbon\Carbon::parse(Auth::user()->updated_at)->format('D, M d, Y \@ h:m A') }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Created On:</label>
                            <p class="text-muted">{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('D, M d, Y \@ h:m A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- left wrapper end -->
            <!-- right wrapper start -->
            <div class="col mb-4">
                <!-- Update Profile Information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Update Account Information</h4>
                        <p class="text-muted mb-3">Update profile information. Before submitting, please double check your info.</p>

                        @if($errors->any())
                            <div class="alert alert-danger mb-4" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        @if (!empty($error))
                                            <li>{{ $error }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" class="form-control" name="name" type="text" placeholder="Enter fullname..." value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input id="age" class="form-control" name="age" type="number" placeholder="Enter your age..." value="{{ old('age') }}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" name="email" type="email" placeholder="Enter email address..." value="{{ old('email') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="gender" value="male" id="gender1" @if(!empty(old('gender')) && old('gender') === 'male') checked @endif>
                                        <label class="form-check-label" for="gender1">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="gender" value="female" id="gender2" @if(!empty(old('gender')) && old('gender') === 'female') checked @endif>
                                        <label class="form-check-label" for="gender2">
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="old_password" class="form-label">Old Password <i class="text-muted">(Required only if you want to update your password)</i></label>
                                <input id="old_password" class="form-control" name="old_password" type="password" placeholder="Enter your old password..." value="{{ old('old_password') }}">
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password <i class="text-muted">(Required only if you want to update your password)</i></label>
                                <input id="new_password" class="form-control" name="password" type="password" placeholder="Enter your new password..." value="{{ old('password') }}">
                            </div>

                            <div class="mb-5">
                                <label for="confirm_password" class="form-label">Confirm password <i class="text-muted">(Required only if you want to update your password)</i></label>
                                <input id="confirm_password" class="form-control" name="password_confirmation" type="password" placeholder="Confirm new password..." value="{{ old('password_confirmation') }}">
                            </div>

                            <div class="mb-3">
                                <label for="profilePhotoDropify" class="form-label">Update Profile Photo</label>
                                <p class="text-muted mb-3">Drag and drop your profile photo below.</p>
                                <input type="file" id="profilePhotoDropify" name="profile-photo" accept="image/*" data-allowed-file-extensions="png jpg jpeg" @if(!empty(old('profile-photo'))) data-default-file='{{ old('profile-photo') }}' @endif>
                            </div>

                            <div class="d-grid">
                                <input class="btn btn-primary" type="submit" value="Update Account">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Update profile information -->
            </div>
            <!-- right wrapper end -->
        </div>
    </div>
@endsection
