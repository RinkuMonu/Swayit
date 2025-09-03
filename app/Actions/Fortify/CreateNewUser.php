<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // dd($input);
        $storedOtp = session()->get('new_otp');

        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            // 'username' => ['required', 'string', 'max:255', 'unique:users'],
            'user_type' => ['required'],
            'otp' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'agree_policy' => ['required'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        if($input['user_type'] == 'influencer') {
            $role_id = 3;
        } elseif($input['user_type'] == 'business') {
            $role_id = 4;
        } else {
            $role_id = 0;   
        }

        // $storedOtp = session()->get('new_otp');
        
        if($input['otp'] == $storedOtp) {
            return User::create([
                'role_id' => $role_id,
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                // 'username' => $input['username'],
                'user_role' => $input['user_type'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'agree_policy' => $input['agree_policy'],
                'email_verify' => $input['email_verify'],
                'password' => Hash::make($input['password']),
            ]);
            
            Session::forget('new_otp');
        }
    }
}
