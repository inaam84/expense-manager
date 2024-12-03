@extends('layouts.master')

@push('page-styles')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>
<style>
    .filepond--item { width: calc(50% - .5em); }
</style>
@endpush

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Update Profile</h4>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-sm-6">
                    @include('profile.partials.update-profile-information-form', ['user' => $user])
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            @include('profile.partials.update-user-profile-image-form', ['user' => $user])
                        </div>
                        <div class="col-sm-12">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
    <!-- End Page-content -->
@endsection

@push('page-scripts')


@endpush
