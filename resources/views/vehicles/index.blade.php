@extends('layouts.master')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <button type="button" class="btn btn-primary waves-effect waves-light btn-sm" onclick="window.location.href='{{ route('vehicles.create') }}'">
                                <i class="fas fa-plus"></i> <span class="ms-2 d-none d-md-inline-block">Add Vehicle</span>
                            </button>
                        </div>

                        <div class="card-body pb-0">

                            <h4 class="card-title mb-4">Vehicles List (Total: {{ $vehicles->count() }})</h4>

                            {{ $vehicles->links('layouts.pagination', ['collection' => $vehicles]) }}

                            <div class="table-responsive" id="tblVehicles">
                                <table id="tblVehicles" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Owner</th>
                                            <th>Registration Number</th>
                                            <th>Make</th>
                                            <th>Model</th>
                                            <th>Year</th>
                                            <th>Color</th>
                                            <th>Engine Size</th>
                                            <th>Fuel Type</th>
                                            <th>MOT Due Date</th>
                                            <th>Tax Due Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vehicles as $vehicle)
                                            <tr>
                                                <th><i class="fas fa-user"></i> {{ optional($vehicle->owner)->full_name }}</th>
                                                <td>{{ $vehicle->registration_number }}</td>
                                                <td>{{ $vehicle->make }}</td>
                                                <td>{{ $vehicle->model }}</td>
                                                <td>{{ $vehicle->year }}</td>
                                                <td>{{ $vehicle->color }}</td>
                                                <td>{{ $vehicle->engine_size }}</td>
                                                <td>{{ $vehicle->fuel_type }}</td>
                                                <td>
                                                    {{ optional($vehicle->mot_due_date)->format('d/m/Y') }}
                                                    @include('partials.remaining_period_string', ['_date' => optional($vehicle->mot_due_date)])
                                                </td>
                                                <td>
                                                    {{ optional($vehicle->tax_due_date)->format('d/m/Y') }}
                                                    @include('partials.remaining_period_string', ['_date' => optional($vehicle->tax_due_date)])
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-info waves-effect waves-light btn-sm" title="Click to view detail"
                                                        onclick="window.location.href='{{ route('vehicles.show', $vehicle) }}'">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light btn-sm" title="Click to edit the information"
                                                        onclick="window.location.href='{{ route('vehicles.edit', $vehicle) }}'">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            {{ $vehicles->appends($_GET)->links('layouts.pagination', ['collection' => $vehicles]) }}
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>

    </div>
    <!-- End Page-content -->
@endsection

@push('page-scripts')

<script src="{{ asset('backend/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

@endpush