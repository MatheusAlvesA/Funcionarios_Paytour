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
		$validacao = $this->validarDadosFuncionario(
							$r->input('nome'),
							$r->input('email'),
							$r->input('cpf'),
							$r->input('imagem'),
							$r->input('telefone'),
							$r->input('observacoes')
						);
		if($validacao['erro'])
			return response($validacao, 400);

		try {
			$imagem = base64_decode($r->input('imagem'));
			$code = str_random(20);
			$path = public_path('imagens');
			file_put_contents($path.DIRECTORY_SEPARATOR.$code.'.jpg', $imagem);

			Funcionario::create(
				[
					'nome' => $r->input('nome'),
					'email' => $r->input('email'),
					'cpf' => $r->input('cpf'),
					'foto' => $code.'.jpg',
					'telefone' => $r->input('telefone'),
					'observacoes' => $r->input('observacoes') 
				]
			);
			return response([
				'erro' => false,
				'mensagem' => 'Funcionário cadastrado com sucesso'
			], 201);
		} catch(\Exception $e) {
			return response([
				'erro' => true,
				'mensagem' => $e->getMessage()
			], 500);
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
		$validacao = $this->validarDadosFuncionario(
					$r->input('nome'),
					$r->input('email'),
					$r->input('cpf'),
					$r->input('imagem'),
					$r->input('telefone'),
					$r->input('observacoes'),
					true
			);
			if($validacao['erro'])
				return response($validacao, 400);

			try {
				$funcionario = Funcionario::findOrFail($id);

				if($r->input('imagem') != null) {
					$imagem = base64_decode($r->input('imagem'));
					$old = $funcionario->foto;
					$code = str_random(20).'.jpg';
					$path = public_path('imagens');
					
					file_put_contents($path.DIRECTORY_SEPARATOR.$code, $imagem);
					unlink($path.DIRECTORY_SEPARATOR.$old);
					$funcionario->update(['foto' => $code]);
				}

				$funcionario->update($r->all());
				
				return response([
					'erro' => false,
					'mensagem' => public_path('imagens').DIRECTORY_SEPARATOR.$code//'Funcionário atualizado com sucesso'
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
			$code = $funcionario->foto;
			$path = public_path('imagens');
			unlink($path.DIRECTORY_SEPARATOR.$code);
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

	private function validarDadosFuncionario(
		$nome,
		$email,
		$cpf,
		$imagem,
		$telefone,
		$observacoes,
		
		$podeSerNulo = false
	) {
		if(
			($nome === null && !$podeSerNulo) ||
			($nome === '')
		)
			return ['erro' => true, 'mensagem' => 'Nome inválido'];

		if(
			($email === null && !$podeSerNulo) ||
			($email !== null && !$this->validarEmail($email))
		)
			return ['erro' => true, 'mensagem' => 'Email inválido'];

		if(
			($cpf === null && !$podeSerNulo) ||
			($cpf !== null && !preg_match('/^(\d){11}$/', $cpf))
		)
			return ['erro' => true, 'mensagem' => 'CPF Inválido'];

		if(
			($telefone === null && !$podeSerNulo) ||
			($telefone !== null && !preg_match_all('/^(\d){8,15}$/', $telefone))
		)
			return ['erro' => true, 'mensagem' => 'Telefone Inválido'];

		if(
			($imagem === null && !$podeSerNulo) ||
			($imagem === '') ||
			($imagem !== null && base64_decode($imagem, true) === false)
		)
			return ['erro' => true, 'mensagem' => 'Imagem inválida'];

		if(($observacoes === null && !$podeSerNulo))
			return ['erro' => true, 'mensagem' => 'Observações não pode ser nulo'];
		
		return ['erro' => false];
	}

	private function validarEmail($email): bool {
		if($email === '')
			return false;

		$partes = explode('@', $email);
		if(count($partes) !== 2)
			return false;

		$usuario = $partes[0];
		$dominio = $partes[1];

		if($usuario === '')
			return false;

		$posicao_ponto = strpos($dominio, '.');
		if(
			$posicao_ponto === false ||
			$posicao_ponto === 0 ||
			$posicao_ponto === (mb_strlen($dominio)-1)
		)
			return false;
		
		return true;
	}
}
