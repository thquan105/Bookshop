<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
	{
		$provinces = $this->getProvinces();
		//dd($provinces);
		$cities = isset(auth()->user()->province_id) ? $this->getCities(auth()->user()->province_id) : [];
		// dd($cities);
		$user = auth()->user();

		return view('auth.profile', compact('provinces', 'cities','user'));
	}
	
	public function update(ProfileRequest $request){		
        $user = auth()->user();
		//dd($request->validated());
        $user->update($request->validated());

		return redirect()->route('profile.index')->with(['message' => 'Successfully updated !']);
	}

	public function show()
	{
		return view('auth.passwords.change');
	}

	public function change(UpdatePasswordRequest $request)
	{
		$user = auth()->user();
		//dd($request->old_password);

		if (!Hash::check($request->old_password, $user->password)) {
			return redirect()->back()->with('error', 'The old password is incorrect.');
		}

		$user->update(['password' => bcrypt($request->password)]);

        return redirect()->route('passwords.change')->with('success',  'Successfully updated !');
	}
}
