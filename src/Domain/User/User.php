<?php
namespace Domain\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    const DEFAULT_LIMIT = 10;
    const DEFAULT_ORDER_FIELD = 'created_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    const ROLE_USER = 'user';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_EDITOR = 'editor';
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERADMIN = 'superadmin';

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

    public function bans()
    {
        return $this->hasMany('Domain\User\Ban');
    }

    public function isBanned(): bool
    {
        return (bool) $this->hasMany('Domain\User\Ban')
            ->where('bans.expires', '<', Carbon::now())
            ->count();
    }

    public function getActiveBan()
    {
        return (bool) $this->hasMany('Domain\User\Ban')
            ->where('bans.expires', '<', Carbon::now())
            ->first();
    }

    public function checkPassword($password): bool
    {
        // TODO: add old phpBB password check logic
        return password_verify($password, $this->password);
    }

    public function setPassword($string): void
    {
        $hash = password_hash($string, PASSWORD_DEFAULT);
        $this->password = $hash;
    }
}
