<?php
namespace Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Builder as Query;

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

    const ROLE_USER_NAME = 'Usuario';
    const ROLE_MODERATOR_NAME = 'Moderador';
    const ROLE_EDITOR_NAME = 'Editor';
    const ROLE_ADMIN_NAME = 'Administrador';
    const ROLE_SUPERADMIN_NAME = 'Super Admin';

    const PATREON_BRONZE_LEVEL = 1;
    const PATREON_SILVER_LEVEL = 2;
    const PATREON_GOLD_LEVEL = 3;

    const PATREON_BRONZE_LEVEL_NAME = 'Bronce';
    const PATREON_SILVER_LEVEL_NAME = 'Plata';
    const PATREON_GOLD_LEVEL_NAME = 'Oro';

    const WRITES_ROLES = [
        self::ROLE_EDITOR,
        self::ROLE_ADMIN,
        self::ROLE_SUPERADMIN
    ];

    const ORDER_FIELD_WHITELIST = [
        'created_at',
        'role',
        'name',
        'username',
        'patreon_level'
    ];

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
        return $this->hasMany('Models\Post');
    }

    public function logs()
    {
        return $this->hasMany('Models\Log');
    }

    public function bans()
    {
        return $this->hasMany('Models\Ban');
    }

    public function isBanned(): bool
    {
        return $this->hasMany('Models\Ban')
            ->where('bans.expires', '<', Carbon::now())
            ->exists();
    }

    public function getActiveBan()
    {
        return $this->hasMany('Models\Ban')
            ->where('bans.expires', '<', Carbon::now())
            ->first();
    }

    public function getRoleName()
    {
        switch ($this->role) {
            case self::ROLE_USER:
                $roleName = self::ROLE_USER_NAME;
                break;
            case self::ROLE_MODERATOR:
                $roleName = self::ROLE_MODERATOR_NAME;
                break;
            case self::ROLE_EDITOR:
                $roleName = self::ROLE_EDITOR_NAME;
                break;
            case self::ROLE_ADMIN:
                $roleName = self::ROLE_ADMIN_NAME;
                break;
            case self::ROLE_SUPERADMIN:
                $roleName = self::ROLE_SUPERADMIN_NAME;
                break;
            default:
                $roleName = null;
                break;
        }

        return $roleName;
    }

    public function getPatreonLevelName()
    {
        switch ($this->patreon_level) {
            case self::PATREON_BRONZE_LEVEL:
                $patreonLevelName = self::PATREON_BRONZE_LEVEL_NAME;
                break;
            case self::PATREON_SILVER_LEVEL:
                $patreonLevelName = self::PATREON_SILVER_LEVEL_NAME;
                break;
            case self::PATREON_GOLD_LEVEL:
                $patreonLevelName = self::PATREON_GOLD_LEVEL_NAME;
                break;
            default:
                $patreonLevelName = null;
                break;
        }

        return $patreonLevelName;
    }

    public function checkPassword($password): bool
    {
        // TODO: add old phpBB password check logic
        return password_verify($password, $this->password);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }

    public function scopeFilters(Query $query, array $filters)
    {
        foreach ($filters as $name => $value) {
            if (!empty($value)) {
                $query->where($name, $value);
            }
        }

        return $query;
    }

    public function scopeSearch(Query $query, $search)
    {
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        }

        return $query;
    }

    public function scopeWriters(Query $query)
    {
        return $query->whereIn('role', self::WRITES_ROLES);
    }
}
