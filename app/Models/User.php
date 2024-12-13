<?php

namespace App\Models;

use App\Models\Auth\AuthenticationLog;
use App\Models\Lookups\UserType;
use App\Models\Lookups\UserWebAccess;
use App\Models\Traits\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Filterable, HasFactory, HasUuids, Notifiable, TwoFactorAuthenticatable;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'email',
        'user_type',
        'system_access',
        'title',
        'department',
        'phone',
        'phone_mobile',
        'status',
        'password',
        'avatar_type',
        'avatar_location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function authentications()
    {
        return $this->morphMany(AuthenticationLog::class, 'authenticatable');
    }

    public function latestAuthentication()
    {
        return $this->morphOne(AuthenticationLog::class, 'authenticatable')->latestOfMany('login_at');
    }

    public function notifyAuthenticationLogVia(): array
    {
        return ['mail'];
    }

    public function successfulLogins()
    {
        return optional($this->authentications()->whereLoginSuccessful(true))->count();
    }

    public function lastSuccessfulLoginAt()
    {
        return optional($this->authentications()->whereLoginSuccessful(true)->first())->login_at;
    }

    public function lastLoginIp()
    {
        return optional($this->authentications()->first())->ip_address;
    }

    public function lastSuccessfulLoginIp()
    {
        return optional($this->authentications()->whereLoginSuccessful(true)->first())->ip_address;
    }

    public function previousLoginAt()
    {
        return optional($this->authentications()->skip(1)->first())->login_at;
    }

    public function previousLoginIp()
    {
        return optional($this->authentications()->skip(1)->first())->ip_address;
    }

    public function getFullNameAttribute()
    {
        return $this->firstname.' '.$this->lastname;
    }

    public function isOnline()
    {
        return \Cache::has('user-is-online-'.$this->id);
    }

    public function isDisabled()
    {
        return $this->system_access == UserWebAccess::ACCESS_DISABLED;
    }

    public function isAdmin()
    {
        return $this->user_type == UserType::TYPE_ADMINISTRATOR;
    }

    public function isUser()
    {
        return $this->user_type == UserType::TYPE_USER;
    }

    public function getPicture($size = false)
    {
        switch ($this->avatar_type) {
            case 'gravatar':
                return url('images/no_image.jpg');
            case 'storage':
                if (is_file(Storage::disk('public')->path($this->avatar_location))) {
                    return asset('storage/'.$this->avatar_location);
                }
                break;
        }

        return url('images/no_image.jpg');
    }
}
