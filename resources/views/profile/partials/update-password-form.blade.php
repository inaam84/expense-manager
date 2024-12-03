{{ html()->form('PUT', route('password.update'))->open() }}
<div class="card">
    <div class="card-body">

        <h4 class="card-title">Update Password</h4>
        <p class="card-title-desc">Ensure your account is using a long, random password to stay secure.</p>

        <div class="row mb-3 @error('current_password', 'updatePassword') text-danger @enderror">
            {{ html()->label('Current Password *')->for('current_password')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->password('current_password')->class('form-control')->attributes(['required', 'autocomplete' => 'current-password']) }}
                @error('current_password', 'updatePassword') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('password', 'updatePassword') text-danger @enderror">
            {{ html()->label('New Password *')->for('password')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->password('password')->class('form-control')->attributes(['required', 'autocomplete' => 'new-password']) }}
                @error('password', 'updatePassword') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('password_confirmation', 'updatePassword') text-danger @enderror">
            {{ html()->label('Confirm Password *')->for('password_confirmation')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->password('password_confirmation')->class('form-control')->attributes(['required', 'autocomplete' => 'new-password']) }}
                @error('password_confirmation', 'updatePassword') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
    </div>
    <div class="card-footer">
        <div class="d-grid">
            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                <i class="fas fa-save"></i> Update Password
            </button>
        </div>
    </div>
</div>
{{ html()->form()->close() }}

