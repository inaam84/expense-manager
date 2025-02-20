@push('page-styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

<div class="row">
    <div class="col-md-8">
        <div class="row mb-1 @error('registration_number') text-danger @enderror">
            {{ html()->label('Registration Number')->for('registration_number')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('registration_number')->class('form-control')->attributes(['id' => 'registration_number', 'maxlength' => 15])->required() }}
                @error('registration_number') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('make') text-danger @enderror">
            {{ html()->label('Make')->for('make')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('make')->class('form-control')->attributes(['id' => 'make', 'maxlength' => 50])->required() }}
                @error('make') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('model') text-danger @enderror">
            {{ html()->label('Model')->for('model')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('model')->class('form-control')->attributes(['id' => 'model', 'maxlength' => 50])->required() }}
                @error('model') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('year') text-danger @enderror">
            {{ html()->label('Year')->for('year')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->select('year', ['' => '']+array_combine(range(date('Y')+1, 1950), range(date('Y')+1, 1950)))->class('form-select') }}
                @error('year') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('color') text-danger @enderror">
            {{ html()->label('Color')->for('color')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('color')->class('form-control')->attributes(['id' => 'color', 'maxlength' => 25])->required() }}
                @error('color') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('engine_size') text-danger @enderror">
            {{ html()->label('Engine Size')->for('engine_size')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('engine_size')->class('form-control')->attributes(['id' => 'engine_size', 'maxlength' => 25])->required() }}
                @error('engine_size') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('fuel_type') text-danger @enderror">
            {{ html()->label('Fuel Type')->for('fuel_type')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('fuel_type')->class('form-control')->attributes(['id' => 'fuel_type', 'maxlength' => 25])->required() }}
                @error('fuel_type') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('mot_due_date') text-danger @enderror">
            {{ html()->label('MOT Due Date')->for('mot_due_date')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('mot_due_date')->class('form-control')->attributes(['id' => 'mot_due_date', 'type' => 'date'])
                    ->value(isset($vehicle->mot_due_date) ? $vehicle->mot_due_date->format('Y-m-d') : '') }}
                @error('mot_due_date') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('tax_due_date') text-danger @enderror">
            {{ html()->label('Tax Due Date')->for('tax_due_date')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('tax_due_date')->class('form-control')->attributes(['id' => 'tax_due_date', 'type' => 'date'])
                    ->value(isset($vehicle->tax_due_date) ? $vehicle->tax_due_date->format('Y-m-d') : '') }}
                @error('tax_due_date') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-1 @error('insurance_due_date') text-danger @enderror">
            {{ html()->label('Insurance Due Date')->for('insurance_due_date')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-8">
                {{ html()->text('insurance_due_date')->class('form-control')->attributes(['id' => 'insurance_due_date', 'type' => 'date'])
                    ->value(isset($vehicle->insurance_due_date) ? $vehicle->insurance_due_date->format('Y-m-d') : '') }}
                @error('insurance_due_date') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
    </div>
</div>

@push('page-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
    const makes = @json($vehicleMakes); 

    $("#make").autocomplete({
        source: makes
    });

</script>
@endpush