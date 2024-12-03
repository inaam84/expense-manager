<div class="row">
    <div class="col-md-8">
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
        <div class="row mb-3 @error('user_type') text-danger @enderror">
            {{ html()->label('User Type')->for('user_type')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->select('user_type')->class('form-select')->options(App\Models\Lookups\UserType::getList()) }}
                @error('user_type') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('department') text-danger @enderror">
            {{ html()->label('Department')->for('department')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                {{ html()->text('department')->class('form-control')->attributes(['id' => 'department', 'maxlength' => 50]) }}
                @error('department') <div class="error">{{ $message }}</div> @enderror
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
        <div class="row mb-3 @error('notify_new_ticket') text-danger @enderror">
            {{ html()->label('Notify New Ticket')
                ->for('notify_new_ticket')->class('col-sm-4 col-form-label') }}
            <div class="col-sm-7">
                <input type="checkbox" id="notify_new_ticket" name="notify_new_ticket" switch="bool" value="1" {{ (isset($user) && $user->notify_new_ticket) == 1 ? 'checked' : '' }} >
                <label for="notify_new_ticket" data-on-label="Yes" data-off-label="No"></label>
                @error('notify_new_ticket') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->

    </div>
    <div class="col-md-4">
        <div class="row mb-3 @error('username') text-danger @enderror">
            {{ html()->label('Username')->for('username')->class('col-sm-12 col-form-label') }}
            <div class="col-sm-12">
                {{ html()->text('username')->class('form-control')->attributes([
                    'id' => 'username', 'required', 'maxlength' => 50, 'onkeypress' => 'formatUsername(event)',
                    'onkeyup' => 'forceLowercase(this)',
                    ]) }}
                @error('username') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('email') text-danger @enderror">
            {{ html()->label('Email')->for('email')->class('col-sm-12 col-form-label') }}
            <div class="col-sm-12">
                {{ html()->text('email')->class('form-control')->attributes(['id' => 'email', 'type' => 'email', 'required', 'maxlength' => 70]) }}
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->
        <div class="row mb-3 @error('system_access') text-danger @enderror">
            {{ html()->label('System Access')->for('system_access')->class('col-sm-12 col-form-label') }}
            <div class="col-sm-12">
                {{ html()->select('system_access')->class('form-select  mb-3')->options(App\Models\Lookups\UserWebAccess::getList()) }}
                @error('system_access') <div class="error">{{ $message }}</div> @enderror
            </div>
        </div>
        <!-- end row -->

    </div>
</div>

@push('page-scripts')

<script>
    $("input[name=username]").on('focus', function(){
        if(
            this.value.trim() == '' &&
            $("input[name=firstname]").val().trim() != '' &&
            $("input[name=lastname]").val().trim() != ''
        )
        {
            var suggestion = $("input[name=firstname]").val().trim()[0] + $("input[name=lastname]").val().trim().replace(/[^a-zA-Z]/g, '');
            if(suggestion.length < 5)
            {
                suggestion.padEnd(5, '1234');
            }
            $(this).val(suggestion.toLowerCase());
        }
    });

    function formatUsername(event)
    {
        var charCode = event.which || event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || (charCode >= 97 && charCode <= 122) || (charCode >= 65 && charCode <= 90))
        {
            return true;
        }
        else
        {
            event.preventDefault();
            return false;
        }
    }
</script>

@endpush
