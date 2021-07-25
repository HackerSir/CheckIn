<?php

namespace App\Models;

use App\Traits\LegacySerializeDate;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $nid
 * @property string $email
 * @property string $password
 * @property string|null $confirm_code
 * @property string|null $confirm_at
 * @property string|null $register_at
 * @property string|null $register_ip
 * @property string|null $last_login_at
 * @property string|null $last_login_ip
 * @property string|null $google2fa_secret
 * @property Carbon|null $agree_terms_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ClubSurvey|null $clubSurvey
 * @property-read Collection|DataUpdateRequest[] $dataUpdateRequests
 * @property-read int|null $data_update_requests_count
 * @property-read Collection|Club[] $favoriteClubs
 * @property-read int|null $favorite_clubs_count
 * @property-read Club|null $club
 * @property-read string $display_name
 * @property-read bool $is_confirmed
 * @property-read bool $is_local_account
 * @property-read string $nid_or_email
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PaymentRecord[] $paymentRecords
 * @property-read int|null $payment_records_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|Record[] $scannedRecords
 * @property-read int|null $scanned_records_count
 * @property-read Student|null $student
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User orWherePermissionIs($permission = '')
 * @method static Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static Builder|User query()
 * @method static Builder|User whereAgreeTermsAt($value)
 * @method static Builder|User whereConfirmAt($value)
 * @method static Builder|User whereConfirmCode($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDoesntHavePermission()
 * @method static Builder|User whereDoesntHaveRole()
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereGoogle2faSecret($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastLoginAt($value)
 * @method static Builder|User whereLastLoginIp($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereNid($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static Builder|User whereRegisterAt($value)
 * @method static Builder|User whereRegisterIp($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use LegacySerializeDate;
    use LaratrustUserTrait;
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nid',
        'email',
        'password',
        'confirm_code',
        'confirm_at',
        'register_at',
        'register_ip',
        'last_login_at',
        'last_login_ip',
        'google2fa_secret',
        'agree_terms_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $appends = [
        'is_confirmed',
        'is_local_account',
        'nid_or_email',
    ];

    protected $dates = [
        'agree_terms_at',
    ];

    /**
     * 帳號是否完成驗證
     *
     * @return bool
     */
    public function getIsConfirmedAttribute()
    {
        return !empty($this->confirm_at);
    }

    /**
     * 是否為本地帳號（非NID登入）
     *
     * @return bool
     */
    public function getIsLocalAccountAttribute()
    {
        return !$this->nid;
    }

    /**
     * @return HasOne|Builder
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'nid', 'nid');
    }

    /**
     * @return HasMany|Builder
     */
    public function dataUpdateRequests()
    {
        return $this->hasMany(DataUpdateRequest::class);
    }

    /**
     * @return HasOne
     */
    public function clubSurvey()
    {
        return $this->hasOne(ClubSurvey::class);
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class);
    }

    public function scannedRecords()
    {
        return $this->hasMany(Record::class, 'scanned_by_user_id');
    }

    /**
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->student->display_name ?? $this->name;
    }

    /**
     * @return \App\Club|null
     */
    public function getClubAttribute()
    {
        if (!$this->student) {
            return null;
        }

        return $this->student->clubs()->first();
    }

    /**
     * @return string
     */
    public function getNidOrEmailAttribute()
    {
        return $this->nid ?: $this->email;
    }

    /**
     * 新增收藏社團
     *
     * @param Club $club
     */
    public function addFavoriteClub(Club $club)
    {
        $this->favoriteClubs()->syncWithoutDetaching($club);
    }

    /**
     * @return BelongsToMany
     */
    public function favoriteClubs()
    {
        return $this->belongsToMany(Club::class, 'favorite_club')->withTimestamps();
    }

    /**
     * 移除收藏社團
     *
     * @param Club $club
     */
    public function removeFavoriteClub(Club $club)
    {
        $this->favoriteClubs()->detach($club);
    }

    /**
     * 是否收藏該社團
     *
     * @param Club $club
     * @return bool
     */
    public function isFavoriteClub(Club $club)
    {
        return $this->favoriteClubs()->where('club_id', $club->id)->exists();
    }
}
