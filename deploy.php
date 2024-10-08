<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/rsync.php';

set('application', 'SNAC-Laravel');
set('ssh_multiplexing', true);
set('repository', 'git@github.com:snac-cooperative/snac-laravel.git');

set('bin/php', function () {
    return '/usr/bin/php83';
});

set('bin/composer', function () {
    return '/usr/bin/php83 /usr/bin/composer';
});

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
    file_put_contents(__DIR__ . '/.env', base64_decode(getenv('ENV_FILE')));
    upload(__DIR__ . '/.env', get('deploy_path') . '/shared');
});

task('build', function() {
    cd('{{release_or_current_path}}');
    run('nvm use 12.14 && npm install && npm run production');
});

host('snaccooperative.org')
  ->set('hostname', 'snaccooperative.org')
  ->set('labels', ['env' => 'production', 'stage' => 'production'])
  ->set('remote_user', 'snacworker')
  ->set('branch', 'master')
  ->set('deploy_path', '/lv2/snac-laravel');

host('snac-dev.iath.virginia.edu')
  ->set('hostname', 'snac-dev.iath.virginia.edu')
  ->set('labels', ['env' => 'development', 'stage' => 'development'])
  ->set('remote_user', 'snacworker')
  ->set('branch', 'development')
  ->set('deploy_path', '/lv2/snac-laravel');

after('deploy:failed', 'deploy:unlock');

desc('Deploy the application');

task('deploy', [
    'deploy:unlock',
    'deploy:prepare',
    'deploy:secrets',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'artisan:queue:restart',
    'deploy:symlink',
    'deploy:cleanup',
    'build'
]);
