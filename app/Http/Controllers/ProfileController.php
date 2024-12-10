<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\FilepondService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        auth()->user()->fill($request->validated());

        if (auth()->user()->isDirty('email')) {
            auth()->user()->email_verified_at = null;
        }

        auth()->user()->save();

        return Redirect::route('profile.edit')->with('message', 'Profile information updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function uploadAvatar(Request $request)
    {
        if ($request->has('profile_image')) {
            if (is_file(Storage::disk('public')->path(auth()->user()->avatar_location))) {
                Storage::disk('public')->delete(auth()->user()->avatar_location);
            }

            $filepond_service = new FilepondService;
            $filepond_file = $filepond_service->retrieve($request->profile_image);

            $avatar_new_name_and_ext = Str::random(12).'.'.$filepond_file->extension;

            File::put(
                Storage::disk('public')->path('users/profile_images/'.auth()->user()->username.'/'.$avatar_new_name_and_ext),
                Storage::disk('local')->get($filepond_file->filepath),
            );

            auth()->user()->update([
                'avatar_type' => 'storage',
                'avatar_location' => 'users/profile_images/'.auth()->user()->username.'/'.$avatar_new_name_and_ext,
            ]);

            $filepond_service->delete($filepond_file);
        }

        return back()->with('success', 'Profile image updated successfully !!');
    }
}
