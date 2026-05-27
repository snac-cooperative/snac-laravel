<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'username',
        'email',
        'first',
        'last',
        'fullname',
        'password',
        'avatar',
        'avatar_small',
        'avatar_large',
        'work_email',
        'work_phone',
        'affiliation',
        'preferred_rules',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'appuser';

    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'appuser_role_link', 'uid', 'rid');
    }

    /**
     * Assign a role to the user.
     *
     * @param string $roleName
     * @return void
     */
    public function assignRole(string $roleName)
    {
        $role = Role::where('label', $roleName)->firstOrFail();
        $this->roles()->attach($role);
    }

    /**
     * The permissions that belong to the user.
     */
    public function getPermissions()
    {
        return Permission::whereIn('id', function ($query) {
            $query->select('pid')
                ->from('privilege_role_link')
                ->whereIn('rid', function ($query) {
                    $query->select('rid')
                        ->from('appuser_role_link')
                        ->where('uid', $this->id);
                });
        })->get();
    }

    public function isVocabularyEditor()
    {
        $permissions = $this->getPermissions();
        $vocabEditor = Permission::where('label', 'Edit Vocabulary')->first();

        return $permissions->contains($vocabEditor);
    }
}
