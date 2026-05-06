<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Partage
 * 
 * @property int $id
 * @property int $user_id
 * @property int $favori_id
 * @property string $film_title
 * @property string|null $film_poster_path
 * @property int|null $film_tmdb_id
 * @property int $friend_id
 * @property string|null $message
 * @property string|null $avis
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Partage extends Model
{
	protected $table = 'partages';

	protected $casts = [
		'user_id' => 'int',
		'favori_id' => 'int',
		'film_tmdb_id' => 'int',
		'friend_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'favori_id',
		'film_title',
		'film_poster_path',
		'film_tmdb_id',
		'friend_id',
		'message',
		'avis'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
