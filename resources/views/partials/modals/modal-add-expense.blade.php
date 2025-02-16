@php
$fromPage = $fromPage ?? 'show';
@endphp

@push('page-styles')
<style>
    /* Example custom CSS */
    #expenseModal .modal-content {
        border-radius: 10px;
    }

    #expenseModal .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    #expenseModal .modal-footer {
        border-top: 1px solid #dee2e6;
    }
</style>
@endpush


<!-- Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="expenseModalLabel">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Validation Errors -->
                <div id="validation-errors" style="color: red; display: none;">
                    <ul id="error-list"></ul>
                </div>

                <form id="expense-form" method="POST" action="{{ route('expenses.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="expense-method" value="POST"> <!-- Dynamically updated for edit -->

                    @if($fromPage == 'show')
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    @elseif($fromPage == 'index')
                    <div class="mb-3">
                        <label for="vehicle_id" class="form-label">Vehicle:</label>
                        <select class="form-control form-select" name="vehicle_id" id="vehicle_id">
                            @foreach(auth()->user()->vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }} | {{ $vehicle->make }} | {{ $vehicle->model }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="expense_amount" class="form-label">Expense Amount:</label>
                        <input type="number" name="expense_amount" id="expense_amount" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="expense_date" class="form-label">Expense Date:</label>
                        <input type="date" name="expense_date" id="expense_date" class="form-control" required>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="expense-form" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
<script>

    $('#expenseModal').on('show.bs.modal', function (e) {
        const isEdit = $('#expense-method').val() == 'PUT'; 

        if (!isEdit) {
            $('#expense-form')[0].reset();
            $('#expense-method').val('POST');
            $('#expense-form').attr('action', "{{ route('expenses.store') }}"); 
        }
    });

    $(document).ready(function() {
        $('#expense-form').submit(function(e) {
            e.preventDefault(); 

            $('#validation-errors').hide();
            $('#error-list').empty();

            $.ajax({
                url: this.action,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#expenseModal').modal('hide');
                    window.location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            errors[field].forEach(error => {
                                $('#error-list').append(`<li>${error}</li>`);
                            });
                        }
                        $('#validation-errors').show();
                    } else if(xhr.status === 500) {
                        $('#error-list').append(`<li>Server is unable to process the request.</li>`);
                        $('#validation-errors').show();
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });
    });

    $('#btnAddExpense').on('click', function(){
        $('#expense-form')[0].reset(); 
        $('#expense-method').val('POST'); 
        $('#expense-form').attr('action', "{{ route('expenses.store') }}"); 
        $('#expenseModal').modal('show');
    });

    $('.btnEditExpense').on('click', function(){
        const expenseId = $(this).data('expense-id');
        const showUrl = "{{ route('expenses.show', ':id') }}".replace(':id', expenseId);
        const updateUrl = "{{ route('expenses.update', ':id') }}".replace(':id', expenseId);

        $.ajax({
            url: showUrl,
            method: 'GET',
            data: $(this).serialize(),
            success: function(response) {
                // Populate form fields
                $('#expense_date').val(formatISO8601Date(response.expense_date));
                $('#vehicle_id').val(response.vehicle_id);
                $('#expense_amount').val(response.amount);

                // Update form attributes for editing
                $('#expense-form').attr('action', updateUrl);
                $('#expense-method').val('PUT'); 

                // Show modal
                $('#expenseModal').modal('show');
            },
            error: function(xhr) {
                $('#error-list').empty(); // Clear previous errors

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function (key, errors) {
                        errors.forEach(error => {
                            $('#error-list').append(`<li>${error}</li>`);
                        });
                    });
                    $('#validation-errors').show();
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

</script>
@endpush