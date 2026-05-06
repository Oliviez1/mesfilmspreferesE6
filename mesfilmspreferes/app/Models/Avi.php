<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Avi
 * 
 * @property int $id
 * @property int|null $favori_id
 * @property int|null $user_id
 * @property int|null $rating
 * @property string|null $texte
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Favori|null $favori
 * @property User|null $user
 *
 * @package App\Models
 */
class Avi extends Model
{
	protected $table = 'avis';

	protected $casts = [
		'favori_id' => 'int',
		'user_id' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'favori_id',
		'user_id',
		'rating',
		'texte'
	];

	public function favori()
	{
		return $this->belongsTo(Favori::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
