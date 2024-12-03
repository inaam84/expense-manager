
<div class="card" id="assignedTicketsTile">
    <div class="card-body">
        <div class="d-flex">
            <div class="flex-grow-1">
                <p class="text-truncate font-size-14 mb-2">
                    <a href="{{ route('tickets.index') }}?_reset=2&ticket_status_multi[]={{ App\Models\Lookups\TicketStatusLookup::STATUS_ASSIGNED }}">
                        Assigned Tickets
                    </a>
                </p>
                <h4 class="mb-2 tileSum">
                    <div class="spinner-grow text-primary m-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </h4>
            </div>
            <div class="avatar-sm">
                <span class="avatar-title bg-light text-primary rounded-3">
                    <i class="fas fa-concierge-bell fa-3x"></i>
                </span>
            </div>
        </div>
    </div><!-- end cardbody -->
</div><!-- end card -->
