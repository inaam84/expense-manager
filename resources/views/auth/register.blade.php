<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>{{ config('app.name') }} - Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ config('app.name') }} Expense Manager" name="description" />
        <meta content="Themesdesign" name="author" />
        @include('layouts.auth-common-styles')

    </head>

    <body class="auth-body-bg">
        <div class="bg-overlay"></div>
        <div class="wrapper-page">
            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center">
                            <div class="mb-3">
                                <a href="/" class="auth-logo">
                                    <img src="{{ asset('backend/assets/images/logo.png') }}" height="100" class="logo-dark mx-auto" alt="">
                                </a>
                                <hr>
                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>Register</b></h4>

                        <div class="p-3">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <label class="form-label" for="firstname">{{ __('First Name') }}</label>
                                        <input
                                            type="text"
                                            id="firstname"
                                            class="form-control @error('firstname') is-invalid @enderror @error('firstname') is-invalid @enderror"
                                            name="firstname"
                                            placeholder="Enter your first name"
                                            required
                                            maxlength="50"
                                            autocomplete="firstname"
                                            value="{{ old('firstname') }}"
                                            autofocus />
                                        @error('firstname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <label class="form-label" for="lastname">{{ __('Lastname') }}</label>
                                        <input
                                            type="text"
                                            id="lastname"
                                            class="form-control @error('lastname') is-invalid @enderror @error('lastname') is-invalid @enderror"
                                            name="lastname"
                                            placeholder="Enter your lastname"
                                            required
                                            maxlength="50"
                                            autocomplete="lastname"
                                            value="{{ old('lastname') }}"
                                            autofocus />
                                        @error('lastname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                        <input
                                            type="email"
                                            id="email"
                                            class="form-control @error('email') is-invalid @enderror @error('email') is-invalid @enderror"
                                            name="email"
                                            placeholder="Enter your email"
                                            required
                                            maxlength="50"
                                            autocomplete="email"
                                            value="{{ old('email') }}"
                                            autofocus />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <label class="form-label" for="username">{{ __('Username') }}</label>
                                        <input
                                            type="text"
                                            id="username"
                                            class="form-control @error('username') is-invalid @enderror @error('email') is-invalid @enderror"
                                            name="username"
                                            placeholder="Enter your username"
                                            required
                                            maxlength="50"
                                            autocomplete="username"
                                            value="{{ old('username') }}"
                                            autofocus />
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                            </div>
                                            <div class="input-group">
                                                <input
                                                    id="password"
                                                    type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password"
                                                    aria-describedby="password"
                                                    required
                                                    autocomplete="current-password" />
                                                <div class="input-group-text">
                                                    <span class="cursor-pointer"><i class="fas fa-eye-slash" onclick="showHidePassword(this);"></i></span>
                                                </div>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <div class="form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                            </div>
                                            <div class="input-group">
                                                <input
                                                    id="password_confirmation"
                                                    type="password"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    name="password_confirmation"
                                                    aria-describedby="password_confirmation"
                                                    required
                                                    autocomplete="confirm-password" />
                                                <div class="input-group-text">
                                                    <span class="cursor-pointer"><i class="fas fa-eye-slash" onclick="showHidePassword(this);"></i></span>
                                                </div>
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="tc" name="tc" onclick="toggleRegisterButton();">
                                            <label class="form-label ms-1" for="tc">I accept <a href="#" class="text-muted">Terms and Conditions</a></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3 text-center row mt-3 pt-1">
                                    <div class="col-12">
                                        <button id="registerButton" class="btn btn-info w-100 waves-effect waves-light " type="submit" disabled>Register</button>
                                    </div>
                                </div>

                            </form>

                            <div class="form-group mb-0 row mt-2">
                                <div class="col-sm-7 mt-3">
                                    <a href="/login" class="text-muted">Already have an account?</a>
                                </div>
                            </div>

                        </div>
                        <!-- end -->
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
            <!-- end container -->
        </div>
        <!-- end -->

        @include('layouts.auth-common-scripts')



        <script>
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type)
            {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
            @endif
        </script>
        <script type="text/javascript">

            function showHidePassword(el)
            {
                const formPasswordToggle = el.closest('.form-password-toggle');
                const formPasswordToggleInput = formPasswordToggle.querySelector('input');
                $(el).toggleClass('fa-eye fa-eye-slash');
                if (formPasswordToggleInput.getAttribute('type') === 'text')
                {
                    formPasswordToggleInput.setAttribute('type', 'password');
                }
                else if (formPasswordToggleInput.getAttribute('type') === 'password')
                {
                    formPasswordToggleInput.setAttribute('type', 'text');
                }
            }

            function toggleRegisterButton() 
            {
                var checkbox = document.getElementById("tc");
                var registerButton = document.getElementById("registerButton");
                registerButton.disabled = !checkbox.checked;
            }

        </script>

    </body>
</html>
