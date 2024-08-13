<?php

namespace Deployer;

require 'vendor/deployer/recipes/recipe/laravel.php';
require 'vendor/deployer/recipes/recipe/rsync.php';

set('application', 'SNAC-Laravel');
set('ssh_multiplexing', true);

set('rsync_src', function () {
    return __DIR__;
});


add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});

host('snaccooperative.org')
  ->hostname('snaccooperative.org')
  ->stage('production')
  ->user('snacworker')
  ->set('deploy_path', '/lv2/snac-laravel');

host('snac-dev.iath.virginia.edu')
  ->hostname('snac-dev.iath.virginia.edu')
  ->stage('staging')
  ->user('snacworker')
  ->set('deploy_path', '/lv2/snac-laravel');

after('deploy:failed', 'deploy:unlock');

desc('Deploy the application');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:secrets',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'artisan:queue:restart',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
