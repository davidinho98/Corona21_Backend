<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'start', 'end', 'amount', 'location_id'];

    /*
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }*/

    public function users() : HasMany{
        return $this->hasMany(User::class);
    }

    public function location() : BelongsTo {
        return $this->belongsTo(Location::class);
    }

}
