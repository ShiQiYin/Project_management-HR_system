<?php

namespace App\Models;

use App\Traits\Uuids;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use Uuids;
    protected $primaryKey = 'position_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'position_id',
        // 'guard_name'
        // 'email',
        // 'name',
        // 'password',
        // 'roles'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        // 'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // empty
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        // empty
    ];

    public function canAccessFilament(): bool
    {
        // TODO: Edit based on permission
        return true;
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
