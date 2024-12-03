@extends('layouts.master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><strong>Confirm password</strong></div>
                        <div class="card-body">
                            <p>{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form class="form-horizontal" method="POST" action="{{ route('password.confirm') }}">
                                {{ csrf_field() }}
                                <div class="form-group mb-3 @error('password') text-danger @enderror">

                                    <label for="password" class="control-label">Current Password</label>

                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @error('password') <div class="error">{{ $message }}</div> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary ">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
