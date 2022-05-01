<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['likes'];
    protected $guard_name = 'api';


    // RELATIONS

    public function relateLikes()
    {
        return $this->hasMany(Like::class);
    }


    // ATTRIBUTES

    public function getLikesAttribute(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->relateLikes;
    }
}
