<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>{{ config('app.name') }} - Email Verified</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ config('app.name') }} Expenses Manager" name="description" />
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
                                    <img src="{{ asset('images/logos/company_logo.png') }}" height="100" class="logo-dark mx-auto" alt="">
                                </a>
                                <hr>
                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>{{ __('Email Verification Required') }}</b></h4>

                        <div class="p-3">

                            <p>{{ __('It looks like you haven’t verified your email address yet.') }}</p>

                            <p>{{ __('Please check your inbox for the verification email. If you didn’t receive the email, you can request a new one.') }}</p>

                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit">{{ __('Send Verification Email Again') }}</button>
                            </form>

                            <p>{{ __('Once you verify your email, you will be able to log in and access your dashboard.') }}</p>                            
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

