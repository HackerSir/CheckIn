<?php

namespace App;

use App\Traits\LegacySerializeDate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $nid NID
 * @property string $email
 * @property string $password
 * @property string|null $confirm_code
 * @property string|null $confirm_at
 * @property string|null $register_at
 * @property string|null $register_ip
 * @property string|null $last_login_at
 * @property string|null $last_login_ip
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $google2fa_secret
 * @property \Illuminate\Support\Carbon|null $agree_terms_at 同意條款時間
 * @property-read \App\ClubSurvey|null $clubSurvey
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataUpdateRequest[] $dataUpdateRequests
 * @property-read int|null $data_update_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Club[] $favoriteClubs
 * @property-read int|null $favorite_clubs_count
 * @property-read \App\Club|null $club
 * @property-read string $display_name
 * @property-read bool $is_confirmed
 * @property-read bool $is_local_account
 * @property-read string $nid_or_email
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PaymentRecord[] $paymentRecords
 * @property-read int|null $payment_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Record[] $scannedRecords
 * @property-read int|null $scanned_records_count
 * @property-read \App\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgreeTermsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConfirmAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConfirmCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogle2faSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegisterAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegisterIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use LegacySerializeDate;
    use LaratrustUserTrait;
    use Notifiable;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'nid', 'nid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function dataUpdateRequests()
    {
        return $this->hasMany(DataUpdateRequest::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function clubSurvey()
    {
        return $this->hasOne(ClubSurvey::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoriteClubs()
    {
        return $this->belongsToMany(Club::class, 'favorite_club')->withTimestamps();
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
