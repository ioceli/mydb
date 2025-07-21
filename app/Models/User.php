<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use App\Mail\TwoFactorCodeMail;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'users'; 
    protected $primaryKey='idUser';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'idEntidad',
        'cedula',
        'name',
        'apellidos',
        'rol',
        'estado',
        'email',
        'genero',
        'telefono',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'two_factor_expires_at' => 'datetime',
];
public function generateTwoFactorCode()
{
    $this->two_factor_code = rand(100000, 999999);
    $this->two_factor_expires_at = now()->addMinutes(10);
    $this->save();

    // Enviar el correo
    Mail::to($this->email)->send(new TwoFactorCodeMail($this));
}

public function resetTwoFactorCode()
{
    $this->two_factor_code = null;
    $this->two_factor_expires_at = null;
    $this->save();
}



    /* RELACION 1:N UNA PERSONA PERTENECE A UNA ENTIDAD*/
public function entidad ():BelongsTo
{
    return $this->belongsTo(entidad::class,'idEntidad','idEntidad');
}
}
