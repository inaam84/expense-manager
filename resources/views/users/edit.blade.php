@extends('layouts.master')

@push('page-styles')

@endpush

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Update User</h4>
                    </div>
                </div>
            </div>

            {{ html()->model($user)->form('PUT', route('users.update', $user))->open() }}

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-light waves-effect btn-sm" onclick="window.location.href='{{ route('users.show', $user) }}'">
                                <i class="fas fa-times"></i> <span class="ms-2 d-none d-md-inline-block">Cancel</span>
                            </button>
                            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                                <i class="fas fa-save"></i> <span class="ms-2 d-none d-md-inline-block">Save Information</span>
                            </button>
                        </div>
                        <div class="card-body">

                            <h4 class="card-title">User Details</h4>

                            @include('users.form')

                        </div>
                    </div>
                </div>
            </div>

            {{ html()->form()->close() }}

        </div>

    </div>
    <!-- End Page-content -->
@endsection

@push('page-scripts')



@endpush
