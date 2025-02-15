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
                                    <img src="{{ asset('backend/assets/images/logo.png') }}" height="100" class="logo-dark mx-auto" alt="">
                                </a>
                                <hr>
                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>Email Verified</b></h4>

                        <div class="p-3">
                            <p class="text-info">Thank you, your email has been verified successfuly. </p>
                            <p class="text-info">
                                Please navigate to <a href="{{ route('login') }}" rel="noopener noreferrer">Login Page</a> to continue.
                            </p>                            
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
