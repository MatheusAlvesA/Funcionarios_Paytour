<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Funcionario;

class FuncionariosController extends Controller {
	
	public function index() {
		return Funcionario::all();
	}

	public function cadastrarFuncionario(Request $r) {
		try {
			Funcionario::create($r->all());
			return response([
				'erro' => false,
				'mensagem' => 'Funcionário cadastrado com sucesso'
			], 201);
		} catch(\Exception $e) {
			// TODO validar entrada
			return response($e->getMessage(), 400);
		}
	}

	public function getFuncionario(int $id) {
		try {
			return Funcionario::findOrFail($id);
		} catch(ModelNotFoundException $e) {
			return response([
				'erro' => true,
				'mensagem' => "Não foi possível encontrar Funcionário com id $id"
			], 404);
		}
		catch(\Exception $e) {
			return response([
				'erro' => true,
				'mensagem' => $e->getMessage()
			], 500);
		}
	}

	public function atualizarFuncionario(Request $r, int $id) {
			try {
				$funcionario = Funcionario::findOrFail($id);
				$funcionario->update($r->all());
				
				return response([
					'erro' => false,
					'mensagem' => 'Funcionário atualizado com sucesso'
				], 200);
			} catch(ModelNotFoundException $e) {
				return response([
					'erro' => true,
					'mensagem' => "Não foi possível encontrar Funcionário com id $id"
				], 404);
			}
			catch(\Exception $e) {
				return response([
					'erro' => true,
					'mensagem' => $e->getMessage()
				], 500);
			}
		}

		public function removerFuncionario(int $id) {
			try {
				$funcionario = Funcionario::findOrFail($id);
				$funcionario->delete();
				
				return response([
					'erro' => false,
					'mensagem' => 'Funcionário removido com sucesso'
				], 200);
			} catch(ModelNotFoundException $e) {
				return response([
					'erro' => true,
					'mensagem' => "Não foi possível encontrar Funcionário com id $id"
				], 404);
			}
			catch(\Exception $e) {
				return response([
					'erro' => true,
					'mensagem' => $e->getMessage()
				], 500);
			}
		}
}
