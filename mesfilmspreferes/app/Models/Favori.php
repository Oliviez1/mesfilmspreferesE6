<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Favori
 * 
 * @property int $id
 * @property string $favori_id
 * @property string $film_title
 * @property string|null $film_year
 * @property string|null $film_overview
 * @property string|null $film_poster_path
 * @property string|null $avis
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class Favori extends Model
{
	protected $table = 'favoris';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'favori_id',
		'film_title',
		'film_year',
		'film_overview',
		'film_poster_path',
		'avis',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function avis()
	{
		return $this->hasMany(Avi::class);
	}
}
