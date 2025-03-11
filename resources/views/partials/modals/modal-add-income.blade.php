@php
$fromPage = $fromPage ?? 'show';
@endphp

@push('page-styles')
<style>
    /* Example custom CSS */
    #incomeModal .modal-content {
        border-radius: 10px;
    }

    #incomeModal .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    #incomeModal .modal-footer {
        border-top: 1px solid #dee2e6;
    }
</style>
@endpush


<!-- Modal -->
<div class="modal fade" id="incomeModal" tabindex="-1" aria-labelledby="incomeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incomeModalLabel">Add Income</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Validation Errors -->
                <div id="validation-errors" style="color: red; display: none;">
                    <ul id="error-list"></ul>
                </div>

                <form id="income-form" method="POST" action="{{ route('incomes.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="income-method" value="POST"> 

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

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="income_amount" class="form-label">Income Amount:</label>
                                <input type="number" name="income_amount" id="income_amount" class="form-control" step="0.01" required >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="income_date" class="form-label">Income Date:</label>
                                <input type="date" name="income_date" id="income_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="income_details" class="form-label">Notes:</label>
                        <textarea name="income_details" id="income_details" class="form-control" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="income_file" class="form-label">File:</label>
                        <input type="file" id="income_file" name="income_file" />
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="income-form" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
<script>

    $('#incomeModal').on('show.bs.modal', function (e) {
        const isEdit = $('#income-method').val() == 'PUT'; 

        if (!isEdit) {
            $('#income-form')[0].reset();
            $('#income-method').val('POST');
            $('#income-form').attr('action', "{{ route('incomes.store') }}"); 
        }
    });

    $(document).ready(function() {
        $('#income-form').submit(function(e) {
            e.preventDefault(); 

            $('#validation-errors').hide();
            $('#error-list').empty();

            let formData = new FormData(this);
            // formData.append('_token', $('meta[name="csrf-token"]').attr('content')); 

            $.ajax({
                url: this.action,
                method: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting content type
                success: function(response) {
                    $('#incomeModal').modal('hide');
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

    $('#btnAddIncome').on('click', function(){
        $('#income-form')[0].reset(); 
        $('#income-method').val('POST'); 
        $('#income-form').attr('action', "{{ route('incomes.store') }}"); 
        $('#incomeModal').modal('show');
    });

    $('.btnEditIncome').on('click', function(){
        const incomeId = $(this).data('income-id');
        const showUrl = "{{ route('incomes.show', ':id') }}".replace(':id', incomeId);
        const updateUrl = "{{ route('incomes.update', ':id') }}".replace(':id', incomeId);

        $.ajax({
            url: showUrl,
            method: 'GET',
            data: $(this).serialize(),
            success: function(response) {
                // Populate form fields
                $('#income_date').val(formatISO8601Date(response.income_date));
                $('#vehicle_id').val(response.vehicle_id);
                $('#income_amount').val(response.amount);

                // Update form attributes for editing
                $('#income-form').attr('action', updateUrl);
                $('#income-method').val('PUT'); 

                // Show modal
                $('#incomeModal').modal('show');
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