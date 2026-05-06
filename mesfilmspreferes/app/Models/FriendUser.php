<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FriendUser
 * 
 * @property int $id
 * @property int $friend_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class FriendUser extends Model
{
	protected $table = 'friend_user';

	protected $casts = [
		'friend_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'friend_id',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
