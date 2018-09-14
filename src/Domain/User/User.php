<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    const DEFAULT_LIMIT = 10;
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
        'username',
        'role',
        'patreon_level',
        'avatar',
        'rank',
        'twitter'
    ];

    protected $hidden = ['password'];

    public function posts()
    {
        return $this->hasMany('Domain\Posts\Posts');
    }

    public function logs()
    {
        return $this->hasMany('Domain\User\Log');
    }
}
