<?php
namespace Domain\User;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    const DEFAULT_LIMIT = 10;
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    const ROLE_USER = 1;
    const ROLE_EDITOR = 2;
    const ROLE_ADMIN = 3;

    const PATREON_BRONZE_LEVEL = 1;
    const PATREON_SILVER_LEVEL = 2;
    const PATREON_GOLD_LEVEL = 3;

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
        return $this->hasMany('Domain\Post\Post');
    }

    public function logs()
    {
        return $this->hasMany('Domain\User\Log');
    }
}
