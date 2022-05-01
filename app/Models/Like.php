<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Post;

class Like extends Model
{
    use HasFactory;

    const TABLE_NAME = 'facilities';

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['relateUser', 'relatePost', 'created_at', 'updated_at'];
    protected $appends = ['user'];

    protected $guard_name = 'api';


    // RELATIONS

    public function relateUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function relatePost()
    {
        return $this->belongsTo(Post::class);
    }


    // ATTRIBUTES

    public function getUserAttribute(): \App\Models\User
    {
        return $this->relateUser;
    }
}
