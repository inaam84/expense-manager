<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>{{ config('app.name') }} - Two Factor Challenge Using Recovery Code</title>
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
                                    <img src="{{ asset('backend/assets/images/logo.png') }}" height="30" class="logo-dark mx-auto" alt="">
                                </a>
                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>Two Factor Challenge Using Recovery Code</b></h4>

                        <div class="p-3">
                            <p>{{ __('Please enter the recovery code.') }}</p>

                            <form class="form-horizontal" method="POST" action="/two-factor-challenge">
                                {{ csrf_field() }}
                                <div class="form-group mb-3 @error('code') text-danger @enderror">

                                    <label for="code" class="control-label">Authenticator Code</label>

                                    <input id="code" type="password" class="form-control" name="code" required>
                                    @error('code') <div class="error">{{ $message }}</div> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary ">Confirm</button>
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

