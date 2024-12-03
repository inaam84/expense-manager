<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>{{ config('app.name') }} - Reset Password</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ config('app.name') }} Tickests Management System" name="description" />
        <meta content="Themesdesign" name="author" />
        @include('layouts.auth-common-styles')

    </head>

    <body class="auth-body-bg">
        <div class="bg-overlay"></div>
        <div class="wrapper-page">
            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center mt-4">
                            <div class="mb-3">
                                <a href="index.html" class="auth-logo">
                                    <img src="{{ asset('images/logos/company_logo.png') }}" height="30" class="logo-dark mx-auto" alt="">
                                </a>
                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>Reset Your Password</b></h4>

                        <div class="p-3">
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                        <input
                                            id="email"
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email"
                                            placeholder="Enter your email address"
                                            required
                                            maxlength="255"
                                            autocomplete="email"
                                            value="{{ old('email', $request->email) }}"
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
                                        <label class="form-label" for="password">{{ __('New Password') }}</label>
                                        <input
                                            id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="Enter your new password"
                                            required
                                            maxlength="50"
                                            autocomplete="new-password" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                        <input
                                            id="password_confirmation"
                                            type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation"
                                            placeholder="Confirm your new password"
                                            required
                                            maxlength="50"
                                            autocomplete="new-password" />
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 text-center row mt-3 pt-1">
                                    <div class="col-12">
                                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit">{{ __('Reset Password') }}</button>
                                    </div>
                                </div>

                            </form>
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




    </body>
</html>
