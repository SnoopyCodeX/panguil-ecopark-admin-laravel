@extends('tourist.index')

@section('register')
    <div class="col d-flex flex-column justify-content-center align-items-center p-2" style="height: 100vh;">

        <h6 class="landing-heading-title">
            Welcome to EcoPark!
        </h6>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Create your account</h5>

                @if(Session::has('error'))
                    <div class="alert alert-danger mb-3 mt-2" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif

                @if(Session::has('success'))
                    <div class="alert alert-success mb-3 mt-2" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <form class="mt-2" method="post" action="{{ route('tourist.register.post') }}" autocomplete="off">
                    @csrf
                    <div class="row mb-2">
                        {{-- Left Section --}}
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" id="password" class="form-control" value="{{ old('password') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <input type="text" name="password_confirm" id="password_confirm" class="form-control" value="{{ old('password_confirm') }}" required>
                            </div>
                        </div>

                        {{-- Right Section --}}
                        <div class="col-md">
                            <div class="mb-3">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="birthday" class="form-label">Date of Birth</label>
                                <input type="date" name="birthday" id="birthday" class="form-control" value="{{ old('birthday') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="tel" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="complete_address" class="form-label">Complete Address</label>
                                <input type="text" name="complete_address" id="complete_address" class="form-control" value="{{ old('complete_address') }}" required>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="agree_with_terms_and_conditions" required>
                                <label class="form-check-label" for="agree_with_terms_and_conditions" required>
                                  AGREE WITH TERMS AND CONDITION
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </div>
                </form>

            </div>

            <div class="card-footer">
                Already have an account? <a href="{{ route('tourist.login') }}">Login here</a>.
            </div>
        </div>

    </div>
@endsection
