<?php

namespace App\Http\Requests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'nullable', 'max:255'],
            'email' => ['string', 'nullable', 'email', 'unique:users'],
            'age' => ['integer', 'nullable'],
            'gender' => ['string', 'nullable'],
            'password' => ['string', 'nullable', 'min:4', 'confirmed'],
            'profile-photo' => ['file', 'nullable', 'mimes:png,jpg'],
        ];
    }

    public function updateProfilePhoto(User $user)
    {
        $this->validated();

        $profilePhoto = $this->file('profile-photo');

        try {
            if($profilePhoto instanceof UploadedFile) {
                $filename = Carbon::now()->format('Y_m_d_H_i_s-') . Str::slug($profilePhoto->getClientOriginalName(), '_');
                $directory = public_path('uploads/profiles');

                // Remove old profile photo from the uploads folder
                if($user->photo != null)
                    @unlink(public_path('uploads/profiles/' . $user->photo));

                // If directory doesn't exist, create it
                if(!File::exists($directory) && !File::isDirectory($directory))
                    File::makeDirectory($directory, 0755, true);

                $profilePhoto->move($directory, $filename);
                $user->photo = $filename;
            }
        } catch(FileException $fe) {
            return redirect()->back()->with('error', 'Failed to upload profile photo. Cause: '. $fe->getMessage())->withInput();
        }
    }
}
