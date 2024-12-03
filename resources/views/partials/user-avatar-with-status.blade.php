<div class="avatar avatar-4xl text-center">
    <img class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm" src="{{ $partial_user->getPicture() }}" alt="Profile Image" width="100"><br>
    @include('partials.badge', [
        'badgeClass' => $partial_user->isOnline() ? 'success' : 'info',
        'badgeText' => $partial_user->isOnline() ? 'online' : 'offline'
        ])
</div>
