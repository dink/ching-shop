<?php

namespace ChingShop\User;

use Illuminate\Database\Eloquent\Model;

/**
 * ChingShop\User\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('auth.model')[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust.permission')[] $perms
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\User\RoleResource whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\User\RoleResource whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\User\RoleResource whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\User\RoleResource whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\User\RoleResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\ChingShop\User\RoleResource whereUpdatedAt($value)
 */
class RoleResource extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('ChingShop\User');
    }
}
