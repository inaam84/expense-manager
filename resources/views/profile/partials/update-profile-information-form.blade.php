{{ html()->model($user)->form('PATCH', route('profile.update'))->open() }}
<div class="card">
    <div class="card-body">

        <h4 class="card-title">Update Profile</h4>
        <p class="card-title-desc">Update your profile and settings</p>

        <div class="row mb-3 @error('title') text-danger @enderror">
            {{ html()->label('Title')->for('title')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->select('title')->class('form-select')->options(['' => '','Mr' => 'Mr', 'Mrs' => 'Mrs', 'Ms' => 'Ms']) }}
                @error('title') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('firstname') text-danger @enderror">
            {{ html()->label('First Name *')->for('firstname')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('firstname')->class('form-control')->attributes(['id' => 'firstname', 'required', 'maxlength' => 70]) }}
                @error('firstname') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('lastname') text-danger @enderror">
            {{ html()->label('Last Name *')->for('lastname')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('lastname')->class('form-control')->attributes(['id' => 'lastname', 'required', 'maxlength' => 70]) }}
                @error('lastname') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('phone_work') text-danger @enderror">
            {{ html()->label('Work Phone')->for('phone_work')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('phone_work')->class('form-control')->attributes(['id' => 'phone_work', 'maxlength' => 50]) }}
                @error('phone_work') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('phone_mobile') text-danger @enderror">
            {{ html()->label('Mobile')->for('phone_mobile')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('phone_mobile')->class('form-control')->attributes(['id' => 'phone_mobile', 'maxlength' => 50]) }}
                @error('phone_mobile') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('phone_home') text-danger @enderror">
            {{ html()->label('Home Phone')->for('phone_home')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('phone_home')->class('form-control')->attributes(['id' => 'phone_home', 'maxlength' => 50]) }}
                @error('phone_home') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('username') text-danger @enderror">
            {{ html()->label('Username')->for('username')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('username')->class('form-control')->attributes([
                    'id' => 'username', 'required', 'maxlength' => 50, 'onkeypress' => 'formatUsername(event)',
                    'onkeyup' => 'forceLowercase(this)',
                    ]) }}
                @error('username') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('email') text-danger @enderror">
            {{ html()->label('Email')->for('email')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('email')->class('form-control')->attributes(['id' => 'email', 'type' => 'email', 'required', 'maxlength' => 70]) }}
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
    </div>
    <div class="card-footer">
        <div class="d-grid">
            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                <i class="fas fa-save"></i> Update Information
            </button>
        </div>
    </div>
</div>
{{ html()->form()->close() }}
