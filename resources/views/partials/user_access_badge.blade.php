@php
if ($user->system_access == App\Models\Lookups\UserWebAccess::ACCESS_ENABLED)
{
    $accessBadge = 'success';
}
elseif($user->system_access == App\Models\Lookups\UserWebAccess::ACCESS_DISABLED)
{
    $accessBadge = 'danger';
}
elseif($user->system_access == App\Models\Lookups\UserWebAccess::ACCESS_READ_ONLY)
{
    $accessBadge = 'warning';
}
else
{
    $accessBadge = 'info';
}

@endphp


@include('partials.badge', [
    'badgeClass' => $accessBadge,
    'badgeText' => App\Models\Lookups\UserWebAccess::getDescription($user->system_access)
])
