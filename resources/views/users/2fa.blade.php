@extends('layouts.master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><strong>Two Factor Authentication</strong></div>
                        <div class="card-body">

                            @if (! auth()->user()->two_factor_secret )
                                <p>Two factor authentication (2FA) strengthens access security by requiring two methods
                                    (also referred to as factors) to verify your identity. Two factor authentication
                                    protects against phishing, social engineering and password brute force attacks and
                                    secures your logins from attackers exploiting weak or stolen credentials.</p>

                                <form class="form-horizontal" method="POST" action="{{ route('two-factor.enable') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            Enable Two Factor Authentication
                                        </button>
                                    </div>
                                </form>
                            @elseif(! auth()->user()->two_factor_confirmed_at )
                            <p>
                                1. Scan this QR code with your Google Authenticator App.
                                Alternatively, you can use the code: <code>{{ decrypt(auth()->user()->two_factor_secret) }}</code>
                            </p>
                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            <br/><br/>
                            <p>2. Enter the pin from Google Authenticator app or any other compatible TOTP app:</p>
                            <form class="form-horizontal" method="POST" action="{{ route('two-factor.confirm') }}">
                                {{ csrf_field() }}
                                <div class="form-group mb-3 {{ $errors->confirmTwoFactorAuthentication->any() ? 'text-danger' : '' }} ">
                                    <label for="code" class="control-label">Authenticator Code</label>
                                    <input id="code" type="password" class="form-control col-md-4" name="code" required>

                                    @if ($errors->confirmTwoFactorAuthentication->any())
                                    <div class="error">
                                        @foreach($errors->confirmTwoFactorAuthentication->all() as $error)
                                        <span>{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    @endif

                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Verify Code
                                </button>
                            </form>
                            @elseif (session('status') == 'two-factor-authentication-confirmed' || auth()->user()->hasEnabledTwoFactorAuthentication())

                                <div class="alert alert-success">
                                    Two factor authentication is currently <strong>enabled</strong> on your account.
                                </div>
                                <p>If you are looking to disable Two Factor Authentication. Please Click Disable Two Factor Authentication Button.</p>
                                <form class="form-horizontal" method="POST" action="{{ route('two-factor.disable') }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger ">Disable Two Factor Authentication</button>
                                </form>

                                <div class="float-end col-sm-5">
                                    <strong>Recovery Codes</strong>
                                    <p>Please keep the following codes at safe palce. If you're unable to use your app to get authentication code,
                                        you can use any of the following codes to login.</p>
                                    @foreach((array) auth()->user()->recoveryCodes() AS $recoveryCode)
                                    {{ $recoveryCode }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
