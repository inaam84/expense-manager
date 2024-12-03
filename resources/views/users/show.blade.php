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
                <div class="col-sm-8">

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
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Tickets</h4>
                            <h4 class="text-center d-none loadingSpinner">
                                <div class="spinner-grow text-warning m-1" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tblUserTickets">
                                    <thead><tr><th>Status</th><th>Count</th></tr></thead>
                                    <tbody></tbody>
                                </table>
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

        const tableBody = document.querySelector('#tblUserTickets tbody');
        $.ajax({
            type: "POST",
            data: {user_id: '{{ $user->id }}'},
            url: "{{ route('ajax.getUserTicketsSummary', $user) }}",
            beforeSend: function() {
                $('.loadingSpinner').removeClass('d-none');
            },
            success: function (response) {
                tableBody.innerHTML = '';

                response = $.parseJSON(response);
                response.forEach((ticket) => {
                    const row = document.createElement('tr');
                    const statusCell = document.createElement('td');
                    statusCell.innerHTML = '<a href="' + ticket.url + '">' + ticket.status_description + '</a>';
                    const countCell = document.createElement('td');
                    countCell.textContent = ticket.total;

                    row.appendChild(statusCell);
                    row.appendChild(countCell);
                    tableBody.appendChild(row);
                });
            },
            error: function (error) {
                console.error("Error:", error);
            },
            complete: function() {
                $('.loadingSpinner').addClass('d-none');
            },
        });

    </script>
@endpush
