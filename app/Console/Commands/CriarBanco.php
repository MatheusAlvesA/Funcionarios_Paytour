<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class CriarBanco extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:criarBanco';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$dbName = env('DB_DATABASE', null);
        if ($dbName === null) {
            $this->error('Erro, DB_DATABASE está vazio, verifique o arquivo .env');
            return;
        }
        try {
			$pdo = new PDO(
							sprintf(
										'mysql:host=%s;port=%d;',
										env('DB_HOST', '127.0.0.1'),
										env('DB_PORT', '3306')
									),
							env('DB_USERNAME', 'root'),
							env('DB_PASSWORD', '')
						);
            $pdo->exec(
						sprintf(
                				'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET UTF8;',
                				$dbName
						)
					);
            $this->info(sprintf('Banco de dados(%s) criado', $dbName));
        } catch (PDOException $exception) {
            $this->error(sprintf('Falha ao criar o banco %s. %s', $dbName, $exception->getMessage()));
        }
    }
}
