@extends('layouts.master')

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

                        <div class="row">
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
                                </dl>

                            </div>
                            <div class="col-sm-6">
                                <dl class="row">
                                    <dt class="col-sm-6">MOT Due Date: </dt>
                                    <dd class="col-sm-6">
                                        {{ optional($vehicle->mot_due_date)->format('d/m/Y') }}
                                        @include('partials.remaining_period_string', ['_date' => optional($vehicle->mot_due_date)])
                                    </dd>

                                    <dt class="col-sm-6">Tax Due Date: </dt>
                                    <dd class="col-sm-6">
                                        {{ optional($vehicle->tax_due_date)->format('d/m/Y') }}
                                        @include('partials.remaining_period_string', ['_date' => optional($vehicle->tax_due_date)])
                                    </dd>

                                    <dt class="col-sm-6">Insurance Due Date: </dt>
                                    <dd class="col-sm-6">
                                        {{ optional($vehicle->insurance_due_date)->format('d/m/Y') }}
                                        @include('partials.remaining_period_string', ['_date' => optional($vehicle->insurance_due_date)])
                                    </dd>
                                </dl>

                            </div>
                        </div>

                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <span>Incomes ({{ count($vehicle->incomes) }})</span>
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm float-end" id="btnAddIncome">
                            Add Income
                        </button>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount (&pound;)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicle->incomes AS $income)
                                <tr>
                                    <td>{{ $income->income_date->format('d/m/Y') }}</td>
                                    <td>{{ $income->amount }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary waves-effect waves-light btn-sm btnEditIncome"
                                            title="Click to edit the information" data-income-id="{{ $income->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        {{ html()->form('DELETE', route('incomes.destroy', $income))->attributes(['style' => 'display: inline;'])->open() }}
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light btn-sm btnDeleteIncome" title="Delete the information">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {{ html()->form()->close() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3"><i class="fa fa-info-circle"></i> No income records found for this vehicle.</td>
                                </tr>
                                @endforelse

                                @if($vehicle->total_income > 0)
                                <tr>
                                    <th>Total</th>
                                    <th colspan="2">{{ $vehicle->total_income }}</th>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <span>Expenses ({{ count($vehicle->expenses) }})</span>
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm float-end" id="btnAddExpense">
                            Add Expense
                        </button>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount (&pound;)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicle->expenses AS $expense)
                                <tr>
                                    <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                                    <td>{{ $expense->amount }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary waves-effect waves-light btn-sm btnEditExpense"
                                            title="Click to edit the information" data-expense-id="{{ $expense->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        {{ html()->form('DELETE', route('expenses.destroy', $expense))->attributes(['style' => 'display: inline;'])->open() }}
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light btn-sm btnDeleteExpense" title="Delete the information">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {{ html()->form()->close() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3"><i class="fa fa-info-circle"></i> No expense records found for this vehicle.</td>
                                </tr>
                                @endforelse
                                @if($vehicle->total_expense > 0)
                                <tr>
                                    <th>Total</th>
                                    <th colspan="2">{{ $vehicle->total_expense }}</th>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.modals.modal-add-income', ['fromPage' => 'show'])
        @include('partials.modals.modal-add-expense', ['fromPage' => 'show'])

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

    $("#btnDeleteVehicle, .btnDeleteIncome, .btnDeleteExpense").on("click", function() {
        const _form = $(this).closest('form');

        Swal.fire({
                title: "Delete Record?",
                text: "This action is irreversibe, are you sure?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#1cbb8c",
                cancelButtonColor: "#f32f53",
                confirmButtonText: "Yes, Delete",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    // $('form[name=frmDeleteVehicle]').submit();
                    _form.submit();
                }
            });
    });
</script>

@endpush