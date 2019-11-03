<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'funcionarios_paytour');

// Project repository
set('repository', 'https://github.com/MatheusAlvesA/Funcionarios_Paytour.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('149.28.225.22')
    ->set('deploy_path', '/var/www/html');    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && composer install');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

