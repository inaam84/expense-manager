<?php

use App\Models\Lookups\TicketStatusLookup;
use Illuminate\Support\Str;

/**
 * Henerate UUID.
 *
 * @return uuid
 */
function generateUuid()
{
    return Str::uuid();
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        return 'frontend.index';
    }
}

if (! function_exists('getUniqueUsername')) {
    function getUniqueUsername($firstnames, $surname)
    {
        $attempts = 0;
        $i = 0;
        do {
            if (++$attempts > 100) {
                $username = Str::lower(Str::random());
                break;
            }

            $username = Str::lower(Str::substr(Str::substr($firstnames, 0, 1).$surname, 0, 50));
            $username = preg_replace('/[^a-zA-Z0-9]+/', '', $username);
            $username = $i == 0 ? $username : $username.$i++;
        } while (App\Models\User::where('username', $username)->count() > 0);

        return strtolower($username);
    }
}

if (! function_exists('replaceTicketStatusWithDescription')) {
    function replaceTicketStatusWithDescription($ticketsCollection)
    {
        $ticketStatues = collect(TicketStatusLookup::pluck('description', 'id')->toArray());

        $updatedCollection = $ticketsCollection->map(function ($item) use ($ticketStatues) {
            $status_id = $item['status'];
            $description = $ticketStatues->get($status_id, 'Unknown');
            $item['status_description'] = $description;

            return $item;
        });

        return $updatedCollection;
    }
}

if (! function_exists('getPerPageDdl')) {
    /**
     * @return array
     */
    function getPerPageDdl()
    {
        return [
            10 => '10',
            20 => '20',
            30 => '30',
            40 => '40',
            50 => '50',
            100 => '100',
            500 => '500',
        ];
    }
}

if (! function_exists('filtersFormReset')) {
    function filtersFormReset($title = '<i class="fas fa-sync"></i> Reset', $classes = 'btn btn-outline-light waves-effect btn-sm', $attributes = [])
    {
        $defaults = ['onclick' => 'resetViewFilters(this);'];

        $attributes = $attributes + $defaults;

        return html()->button($title)->class($classes)->type('button')->attributes($attributes);
    }
}

if (! function_exists('formSubmit')) {
    function formSubmit($title, $classes = 'btn btn-success btn-sm pull-right')
    {
        return html()->submit($title)->class($classes);
    }
}

/**
 * Format bytes to kb, mb, gb, tb
 *
 * @param  int  $size
 * @param  int  $precision
 * @return int
 */
if (! function_exists('formatBytes')) {
    function formatBytes($size, $precision = 0)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];

            return round(pow(1024, $base - floor($base)), $precision).$suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}
