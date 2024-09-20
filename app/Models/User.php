<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

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
        $userId = $this->id;
        $vocabularyEditorPrivilegeLabel = 'Edit Vocabulary';
        $roles = DB::table('appuser')->join('appuser_role_link', function ($join) use ($userId) {
            $join->on('appuser.id', '=', 'appuser_role_link.uid')->where('appuser.id', '=', $userId);
        })->join('privilege_role_link', 'privilege_role_link.rid', '=', 'appuser_role_link.rid')->
            join('privilege', function ($join) use ($vocabularyEditorPrivilegeLabel) {
            $join->on('privilege_role_link.pid', '=', 'privilege.id')->where('privilege.label', '=', $vocabularyEditorPrivilegeLabel);
        })->select('appuser_role_link.rid')->get();
        return $roles->count() > 0;
    }
}
