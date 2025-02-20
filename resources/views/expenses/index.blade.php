@extends('layouts.master')

@push('page-styles')
<style>
    dl {
        display: grid;
        grid-template-columns: max-content auto;
    }

    dt {
        grid-column-start: 1;
    }

    dd {
        grid-column-start: 3;
    }
</style>
@endpush

@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm" id="btnAddExpense">
                            <i class="fas fa-plus"></i> <span class="ms-2 d-none d-md-inline-block">Add Expense</span>
                        </button>
                    </div>

                    <div class="card-body pb-0">

                        <h4 class="card-title mb-4">Expenses List</h4>

                        {{ $expenses->links('layouts.pagination', ['collection' => $expenses]) }}

                        <div class="table-responsive" id="tblExpenses">
                            <table id="tblExpenses" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Expense Date</th>
                                        <th>Expense Amount (&pound;)</th>
                                        <th>Vehicle Details</th>
                                        <th>Details</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ optional($expense->expense_date)->format('d/m/Y') }}</td>
                                        <td>{{ $expense->amount }}</td>
                                        <td>
                                            <dl>
                                                <dt>Registration: </dt>
                                                <dd>{{ $expense->vehicle->registration_number }}</dd>
                                                <dt>Make: </dt>
                                                <dd>{{ $expense->vehicle->make }}</dd>
                                                <dt>Model: </dt>
                                                <dd>{{ $expense->vehicle->model }}</dd>
                                                <dt>Year: </dt>
                                                <dd>{{ $expense->vehicle->year }}</dd>
                                            </dl>
                                        </td>
                                        <td>{!! nl2br(e($expense->details)) !!}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary waves-effect waves-light btn-sm btnEditExpense" 
                                                title="Click to edit the information" data-expense-id="{{ $expense->id }}" >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            {{ html()->form('DELETE', route('expenses.destroy', $expense))->attributes(['style' => 'display: inline;'])->open() }}
                                            <button type="button" class="btn btn-outline-danger waves-effect waves-light btn-sm btnDeleteExpense" title="Delete the information">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            {{ html()->form()->close() }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        {{ $expenses->appends($_GET)->links('layouts.pagination', ['collection' => $expenses]) }}
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>

    @include('partials.modals.modal-add-expense', ['fromPage' => 'index'])
</div>
<!-- End Page-content -->
@endsection

@push('page-scripts')
<script>
    $(".btnDeleteExpense").on("click", function() {
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