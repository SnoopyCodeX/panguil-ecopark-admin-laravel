@extends('tourist.index')

@section('login')
    <div class="col-md d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">

        <h6 class="landing-heading-title">
            Welcome to EcoPark!
        </h6>

        <div class="card" style="width: 30rem;">
            <div class="card-body">
                <h5 class="card-title">Login to your account</h5>
                <form class="mt-2" method="post" action="{{ route('tourist.login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ old('email') }}" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}" required>
                    </div>

                    @if(Session::has('error'))
                        <div class="alert alert-danger mb-3" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                Don't have an account? <a href="{{ route('tourist.register') }}">Create an account</a>.
            </div>
        </div>

    </div>
@endsection
