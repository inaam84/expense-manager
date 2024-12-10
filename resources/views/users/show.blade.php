@extends('layouts.master')

@push('page-styles')
@endpush

@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">View User</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-light waves-effect btn-sm"
                            onclick="window.location.href='{{ route('users.index') }}'">
                            <i class="fas fa-times"></i> <span class="ms-2 d-none d-md-inline-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm"
                            onclick="window.location.href='{{ route('users.edit', $user) }}'">
                            <i class="fas fa-edit"></i> <span class="ms-2 d-none d-md-inline-block">Edit</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">User Details</h4>

                        <div class="row">
                            <div class="col-sm-6">
                                @include('partials.user-avatar-with-status', ['partial_user' => $user])

                                <dl class="row">
                                    <dt>Name:</dt>
                                    <dd>{{ $user->title }} {{ $user->firstname }} {{ $user->lastname }}</dd>

                                    <dt>User Type:</dt>
                                    <dd>{{ App\Models\Lookups\UserType::getDescription($user->user_type) }}</dd>

                                    <dt class="col-sm-3 text-truncate">Department:</dt>
                                    <dd>{{ $user->department }}</dd>

                                    <dt>Work Phone:</dt>
                                    <dd>{{ $user->phone_work ?? '' }}</dd>

                                    <dt>Mobile:</dt>
                                    <dd>{{ $user->phone_mobile ?? '' }}</dd>

                                    <dt>Home Phone:</dt>
                                    <dd>{{ $user->phone_home ?? '' }}</dd>

                                    <dt>Notify New Tickets: </dt>
                                    <dd>{{ $user->notify_new_ticket ? 'Yes' : 'No' }}</dd>
                                </dl>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Access & Logins</h4>

                                        <dl class="row">
                                            <dt>System Access:</dt>
                                            <dd>@include('partials.user_access_badge', ['user' => $user])</dd>

                                            <dt>Username: </dt>
                                            <dd>
                                                <code>{{ $user->username }}</code>
                                            </dd>

                                            <dt>Email:</dt>
                                            <dd>{{ $user->email }}</dd>


                                            <dt>Last Login At:</dt>
                                            <dd>{{ $user->lastSuccessfulLoginAt() ? \Carbon\Carbon::parse($user->lastSuccessfulLoginAt())->format('d/m/Y H:i:s') : 'no login record' }}</dd>

                                            <dt>Total Logins:</dt>
                                            <dd>{{ $user->successfulLogins() }}</dd>

                                        </dl>

                                    </div>
                                </div>
                            </div>
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
</script>
@endpush