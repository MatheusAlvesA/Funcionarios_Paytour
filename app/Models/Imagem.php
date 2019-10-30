<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
	protected $table = 'imagens';
	public $timestamps = false;

	protected $fillable = [ 'data' ];
	protected $hidden = [ 'data' ];
}
