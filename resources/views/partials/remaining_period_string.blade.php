@if( isset($_date) && !is_null($_date) )
    <p class="text-info small" style="margin: 0; padding: 0;">{{ $_date->diffForHumans() }}</p>
@endif
