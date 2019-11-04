# Funcionários Paytour

Este projeto constitui uma API Restful que fornece o serviço de gerenciamento de informações de funcionários. São armazenados: `nome`, `email`, `cpf`, `telefone`, `foto` e `observações`, sendo este último opcional. Todas as informações são validadas ao serem inseridas ou atualizadas.   
A segurança da API é feita através do padrão mais comum de proteção de APIs RestFul, o padrão [Json Web Token]( https://jwt.io/).

## Instalação

Como um projeto desenvolvido em Laravel 5.8 é necessário que o ambiente de testes atenda aos requisitos do framework. Feito isso, configure o arquivo `.env` na raiz do projeto com as informações a respeito da conexão com o seu banco de dados.
O banco de dados desse sistema também possui requisitos para que o sistema possa operar. Certifique-se de criar o banco funcionarios_paytour, para que o sistema possa armazenas as tabelas. Se você está usando MySQL, use o comando `php artisan mysql:criarBanco` para criar o banco automaticamente.
Execute o comando `php artisan migrate` para criar as tabelas necessárias para o funcionamento do sistema, em seguida, use o comando `php artisan db:seed` para criar o usuário default do sistema.

## API

Para usar a API desse sistema envie um `POST` para `http://localhost/api/login` passando o email e senha default: matheuseejam@gmail.com e p4yt0ur respectivamente em um Json no formato:
```Json
{
	"email": "matheuseejam@gmail.com",
	"password": "p4yt0ur"
}
```

Você receberá uma resposta contendo o token e o tempo de vida do mesmo. Para renovar o token envie um `GET` para `http://localhost/api/refresh`. Todas as requisições para a API de funcionários requerem o token obtido em seus no headers, no formato: `Authorization: Bearer <TOKEN OBTIDO>`.  
Para listar os funcionários envie um `GET` para `http://localhost/api/funcionario`, passando o id, da forma: `http://localhost/api/funcionario/<id>` você receberá apenas o funcionário solicitado. Use `POST` em `funcionario/` para cadastrar um novo funcionário e `PUT` em `funcionario/<id>` para atualizar um existente, ou, `DELETE` nessa rota para deleta-lo. O formato do JSON deve ser:

```Json
{
    "nome": "Matheus Alves",
    "email": "matheuseejam@gmail.com",
    "cpf": "11111111111",
    "telefone": "988888888",
    "observacoes": "",
    "imagem":"<IMAGEM CODIFICADA EM BASE64>"
}
```
Entretanto, ao obter o funcionário da api o json não tem o campo `imagem`, mas sim o campo `foto` que é composto de uma string que representa o nome da foto no servidor. Para obter a foto use `http://localhost/imagens/<NOME FOTO>`. 


## Testes

O Laravel possue uma configuração nativa para o uso do [phpunit](https://phpunit.de/). Alguns testes para este sistema foram desenvolvidos e estão presentes das subpastas do diretório `tests`.  
`tests/Feature/JWTTest.php` guarda os testes responsáveis por checar se a API do sistema está gerando os tokens corretamente.  
`tests/Feature/DBTest.php` guarda o teste unitário para checar se o banco contém o usuário default. Este teste falha se o banco não estiver preenchido.

## Autor

Este sistema foi desenvolvido por Matheus Alves de Andrade.
contatos: https://matheusalves.com.br
