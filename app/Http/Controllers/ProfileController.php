<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $page = 'profile';

        return view("admin.profile", compact('page'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        $name = $request->safe()->only(['name'])['name'] ?? '';
        $email = $request->safe()->only(['email'])['email'] ?? '';
        $age = $request->safe()->only(['age'])['age'] ?? '';
        $gender = $request->safe()->only(['gender'])['gender'] ?? '';
        $new_password = $request->safe()->only(['password'])['password'] ?? '';
        $old_password = $request->safe()->only(['old_password'])['old_password'] ?? '';

        $user = User::find(Auth::user()->id);
        $user->name = empty($name) ? $user->name : $name;
        $user->email = empty($email) ? $user->email : $email;
        $user->age = empty($age) ? $user->age : intval($age);
        $user->gender = empty($gender) ? $user->gender : $gender;

        // Old password verification
        if(!empty($old_password) && !empty($new_password)) {
            if(Hash::check($old_password, $user->password))
                $user->password = Hash::make($new_password);
            else
                return redirect()->back()->with('error', 'Old password is incorrect!')->withInput();
        }

        $request->updateProfilePhoto($user);

        $user->save();

        return redirect()->back()->with('success', 'Account has been updated successfully!');
    }
}
