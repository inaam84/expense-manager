@extends('layouts.master')

@push('page-styles')

@endpush

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Vehicle</h4>
                    </div>
                </div>
            </div>

            {{ html()->modelForm($vehicle, 'PUT', route('vehicles.update', $vehicle))->acceptsFiles()->open() }}

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-light waves-effect btn-sm" onclick="window.location.href='{{ route('vehicles.show', $vehicle) }}'">
                                <i class="fas fa-times"></i> <span class="ms-2 d-none d-md-inline-block">Cancel</span>
                            </button>
                            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                                <i class="fas fa-save"></i> <span class="ms-2 d-none d-md-inline-block">Save Information</span>
                            </button>
                        </div>
                        <div class="card-body">

                            @include('vehicles.form')

                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-light waves-effect btn-sm" onclick="window.location.href='{{ route('vehicles.show', $vehicle) }}'">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                                <i class="fas fa-save"></i> Save Information
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{ html()->closeModelForm() }}

        </div>

    </div>
    <!-- End Page-content -->
@endsection

