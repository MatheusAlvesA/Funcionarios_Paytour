<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
	
	public $timestamps = false;

	protected $fillable = [
        'nome', 'email', 'cpf', /*'foto',*/ 'telefone', 'observacoes' 
	];
	
}
