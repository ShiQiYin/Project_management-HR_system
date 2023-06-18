<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model 
{

    use HasFactory;
    use Uuids;
    protected $primaryKey = 'leaves_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'category', 'start_date', 'end_date', 'reason', 'status', 'days', 'approval', 'approved_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function category()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
