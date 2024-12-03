@extends('layouts.master')



@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Settings</h4>
                    </div>
                </div>
            </div>

            {{ html()->form('POST', route('settings.store'))->open() }}

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-light waves-effect btn-sm" onclick="window.location.href='{{ route('home') }}'">
                                <i class="fas fa-times"></i> <span class="ms-2 d-none d-md-inline-block">Cancel</span>
                            </button>
                            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                                <i class="fas fa-save"></i> <span class="ms-2 d-none d-md-inline-block">Save Information</span>
                            </button>
                        </div>
                        <div class="card-body">

                            <h4 class="card-title">Settings</h4>

                            <div class="table-responsive" id="tblSettings">
                                <table id="tblSettings" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 33%">Key</th>
                                            <th style="width: 33%">Value</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($settings as $setting)
                                        <tr>
                                            <td>
                                                {{ Str::title(str_replace('-', ' ', $setting->key)) }}
                                            </td>
                                            <td>
                                                {{ $setting->value }}
                                            </td>
                                            <td class="text-center">

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

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
