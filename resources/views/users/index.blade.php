@extends('layouts.master')

@push('page-styles')

@endpush

@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary waves-effect waves-light btn-sm" onclick="window.location.href='{{ route('users.create') }}'">
                                <i class="fas fa-user-plus"></i> <span class="ms-2 d-none d-md-inline-block">Create User</span>
                            </button>
                        </div>
                        <div class="card-body pb-0">

                            <div class="float-end d-none d-md-inline-block">
                                <button type="button" class="btn btn-outline-info waves-effect waves-light btn-sm" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>

                            @include('partials.filters', ['searchRoute' => route('users.index'), 'filters' => $filters])

                            <h4 class="card-title mb-4">Users</h4>

                            {{ $users->appends($_GET)->links('layouts.pagination', ['collection' => $users]) }}

                            <div class="table-responsive" id="tblUsers">
                                <table id="tblUsers" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>System Access</th>
                                            <th class="text-center">Reopened Tickets</th>
                                            <th class="text-center">Due Today Tickets</th>
                                            <th class="text-center">Overdue Tickets</th>
                                            <th class="text-center">Assigned Tickets</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <th style="width: 25%;">
                                                    {{ $user->full_name }}<br>
                                                    <i class="fas fa-envelope"></i> {{ $user->email }}<br>
                                                    @include('partials.badge', [
                                                        'badgeClass' => $user->isOnline() ? 'success' : 'info',
                                                        'badgeText' => $user->isOnline() ? 'online' : 'offline'
                                                        ])
                                                </th>
                                                <td>
                                                    <code>{{ $user->username ?? '' }}</code>
                                                </td>
                                                <td>
                                                    @include('partials.user_access_badge', ['user' => $user])
                                                </td>
                                                <th class="text-info text-center" style="cursor: pointer"
                                                    onclick="window.location.href='{{ route('tickets.index') }}?_reset=2&assigned_agent_id={{ $user->id }}&ticket_status={{ App\Models\Lookups\TicketStatusLookup::STATUS_REOPENED }}'">
                                                    {{ $user->reopened_tickets_count }}
                                                </th>
                                                <th class="text-warning text-center" style="cursor: pointer"
                                                    onclick="window.location.href='{{ route('tickets.index') }}?_reset=2&assigned_agent_id={{ $user->id }}&due_today=1'">
                                                    {{ $user->due_today_tickets_count }}
                                                </th>
                                                <th class="text-danger text-center" style="cursor: pointer"
                                                    onclick="window.location.href='{{ route('tickets.index') }}?_reset=2&assigned_agent_id={{ $user->id }}&overdue=1'">
                                                    {{ $user->overdue_tickets_count }}
                                                </th>
                                                <th class="text-danger text-center" style="cursor: pointer"
                                                    onclick="window.location.href='{{ route('tickets.index') }}?_reset=2&assigned_agent_id={{ $user->id }}'">
                                                    {{ $user->assigned_tickets_count }}
                                                </th>
                                                <th>
                                                    <button type="button" class="btn btn-outline-info waves-effect waves-light btn-sm" title="Click to view detail"
                                                        onclick="window.location.href='{{ route('users.show', $user) }}'">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light btn-sm" title="Click to edit the information"
                                                        onclick="window.location.href='{{ route('users.edit', $user) }}'">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            {{ $users->appends($_GET)->links('layouts.pagination', ['collection' => $users]) }}
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>

    </div>
    <!-- End Page-content -->
@endsection

@push('page-scripts')



@endpush
