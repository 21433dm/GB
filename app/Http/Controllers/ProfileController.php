<?php

namespace Greenbook\Http\Controllers;

use Auth;
use Greenbook\Models\User;
use illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            abort(404);
        }

        return view('profile.index')
            ->with('user', $user);
    }

    public function getEdit()
    {
        return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'alpha|max:20',
            'last_name' => 'alpha|max:30',
            'location' => 'max:50',
        ]);

        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location'),
        ]);

        return redirect()
            ->to('/')
            ->with('success', 'Your profile has been updated.');
    }
}