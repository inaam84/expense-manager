<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Filters\UserFilters;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            'admin',
        ];
    }

    public function index(UserFilters $filters)
    {
        $users = User::filter($filters)
            ->paginate(20);

        return view('users.index', compact('users', 'filters'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
