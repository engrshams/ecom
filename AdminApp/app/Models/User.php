<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable{
    use HasFactory, Notifiable;
    protected $fillable = ['otp','role','email','password' ];
    protected $hidden = [//'otp',//'password',
        'remember_token',
    ];

    protected function casts(): array{
        return [
            'password' => 'hashed',
        ];
    }
    public function profile(){
        return $this->hasOne(CustomerProfile::class);
    }
}
