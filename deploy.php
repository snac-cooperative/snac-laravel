<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/rsync.php';

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
  ->set('hostname', 'snaccooperative.org')
  ->set('labels', ['env' => 'production', 'stage' => 'production'])
  ->set('remote_user', 'snacworker')
  ->set('deploy_path', '/lv2/snac-laravel');

host('snac-dev.iath.virginia.edu')
  ->set('hostname', 'snac-dev.iath.virginia.edu')
  ->set('labels', ['env' => 'development', 'stage' => 'development'])
  ->set('remote_user', 'snacworker')
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
