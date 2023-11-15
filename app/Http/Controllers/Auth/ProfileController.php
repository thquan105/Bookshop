<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

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

		return redirect()->route('profile.index')->with(['message' => 'success updated']);
	}
}
