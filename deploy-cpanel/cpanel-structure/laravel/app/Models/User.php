<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'usuarios';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email',
        'password',
        'nombre',
        'apellido',
        'id_rol',
        'id_escuela',
        'email_verificado',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'token_verificacion',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verificado' => 'boolean',
        'activo' => 'boolean',
        'fecha_registro' => 'datetime',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['role'];

    /**
     * Get the user's full name.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    /**
     * Check if user is active.
     */
    public function isActive()
    {
        return $this->activo;
    }

    /**
     * Check if email is verified.
     */
    public function hasVerifiedEmail()
    {
        return $this->email_verificado;
    }

    /**
     * Get the role for this user based on id_rol.
     */
    public function getRolAttribute()
    {
        // Mapeo de IDs de rol a nombres de rol según la base de datos
        $roles = [
            1 => 'usuario_general', // Usuario General (Escuela)
            2 => 'admin',           // Administrador
            3 => 'medico_auditor',  // Auditor (usado como médico auditor)
        ];

        return $roles[$this->id_rol] ?? 'usuario_general';
    }

    /**
     * Get the role for this user from the roles table.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_rol', 'id_rol');
    }

    /**
     * Get the school for this user from the escuelas table.
     */
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    /**
     * Get the role name in Spanish for display.
     */
    public function getRolNombreAttribute()
    {
        return $this->role ? $this->role->nombre_rol : 'Usuario General';
    }

    /**
     * Get the school name for display.
     */
    public function getEscuelaNombreAttribute()
    {
        return $this->escuela ? $this->escuela->nombre : 'Sin escuela asignada';
    }
}