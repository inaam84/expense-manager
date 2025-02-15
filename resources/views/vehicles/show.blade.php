@extends('layouts.master')

@push('page-styles')
@endpush

@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">View Vehicle</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-light waves-effect btn-sm"
                            onclick="window.location.href='{{ route('vehicles.index') }}'">
                            <i class="fas fa-times"></i> <span class="ms-2 d-none d-md-inline-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm"
                            onclick="window.location.href='{{ route('vehicles.edit', $vehicle) }}'">
                            <i class="fas fa-edit"></i> <span class="ms-2 d-none d-md-inline-block">Edit</span>
                        </button>
                        {{ html()->form('DELETE', route('vehicles.destroy', $vehicle))->attributes(['style' => 'display: inline;', 'name' => 'frmDeleteVehicle'])->open() }}
                        <button type="button" class="btn btn-danger waves-effect waves-light btn-sm float-end" id="btnDeleteVehicle">
                            <i class="fas fa-trash"></i> <span class="ms-2 d-none d-md-inline-block">Delete</span>
                        </button>
                        {{ html()->form()->close() }}
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ $vehicle->registration_number }}
                        </h3>

                        <div class="col-sm-6">
                            <dl class="row">
                                <dt class="col-sm-6">Make: </dt>
                                <dd class="col-sm-6">{{ $vehicle->make }}</dd>

                                <dt class="col-sm-6">Model: </dt>
                                <dd class="col-sm-6">{{ $vehicle->model }}</dd>

                                <dt class="col-sm-6">Year: </dt>
                                <dd class="col-sm-6">{{ $vehicle->year }}</dd>

                                <dt class="col-sm-6">Color: </dt>
                                <dd class="col-sm-6">{{ $vehicle->color }}</dd>

                                <dt class="col-sm-6">Engine Size: </dt>
                                <dd class="col-sm-6">{{ $vehicle->engine_size }}</dd>

                                <dt class="col-sm-6">Fuel Type: </dt>
                                <dd class="col-sm-6">{{ $vehicle->fuel_type }}</dd>

                                <dt class="col-sm-6">MOT Due Date: </dt>
                                <dd class="col-sm-6">
                                    {{ optional($vehicle->mot_due_date)->format('d/m/Y') }}
                                    @include('partials.remaining_period_string', ['_date' => optional($vehicle->mot_due_date)])
                                </dd>

                                <dt class="col-sm-6">MOT Due Date: </dt>
                                <dd class="col-sm-6">
                                    {{ optional($vehicle->tax_due_date)->format('d/m/Y') }}
                                    @include('partials.remaining_period_string', ['_date' => optional($vehicle->tax_due_date)])
                                </dd>
                            </dl>

                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- End Page-content -->
@endsection

@push('page-scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $("#btnDeleteVehicle").on("click", function() {
        Swal.fire({
                title: "Delete Vehicle?",
                text: "This action is irreversibe, are you sure?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#1cbb8c",
                cancelButtonColor: "#f32f53",
                confirmButtonText: "Yes, Delete",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $('form[name=frmDeleteVehicle]').submit();
                }
            });
    });
</script>
@endpush