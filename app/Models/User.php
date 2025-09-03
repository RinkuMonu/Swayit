<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'username',
        'user_role',
        'email',
        'phone',
        'agree_policy',
        'password',
        'profile_photo_path',
        'video_verify',
        'email_verify',
        'mobile_verify',
         'facebook_page_token',  
        'instagram_account_id',
        'company',
        'tags',
        'address',
        'zip',
        'city',
        'state',
        'language',
        'bio',
        'website',
        'industry',
        'about',
        'tiktok_refresh_token',
        'tiktok_token_expires_at',
        'tiktok_access_token',
        'tiktok_open_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'tiktok_access_token',
        'tiktok_refresh_token'
    ];

  
    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tiktok_token_expires_at' => 'datetime',
        ];
    }

    public function twitterConnection()
{
    return $this->hasOne(TwitterConnection::class);
}
}
