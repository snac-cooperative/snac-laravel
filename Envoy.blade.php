@servers(['local' => '127.0.0.1', 'dev' => 'snac-dev.iath.virginia.edu', 'production' => ''])

@setup
    $repo = 'git@github.com:snac-cooperative/snac-laravel.git';
    $branch = 'jnm/laravel-deploy';
    date_default_timezone_set('America/New_York');
    $date = date('YmdHis');
    $appDir = '/lv2/snac-laravel';
    $buildsDir = $appDir . '/releases';
    $deploymentDir = $buildsDir . '/' . $date;
    $wwwDir = '/var/www';
    $env = $appDir . '/.env';
    $storage = $appDir . '/storage';
    $scpPort = 22;
@endsetup

@before
  if ($task === 'deploy') {
    $scpHost = 'snac-dev.iath.virginia.edu';
  } else if ($task === 'deploy_prod') {
    $scpHost = 'user@host.com';
  }
@endbefore

@task('build', ['on' => 'local'])
  yarn prod
@endtask

@task('git', ['on' => 'dev'])
  git clone --depth 1 -b {{ $branch }} "{{ $repo }}" {{ $deploymentDir }}
@endtask

@task('git_prod', ['on' => 'production'])
  git clone --depth 1 -b {{ $branch }} "{{ $repo }}" {{ $deploymentDir }}
@endtask

@task('install', ['on' => 'dev'])
  cd {{ $deploymentDir }}
  rm -rf {{ $deploymentDir }}/storage
  ln -nfs {{ $env }} {{ $deploymentDir }}/.env
  ln -nfs {{ $storage }} {{ $deploymentDir }}/storage
  /usr/bin/php83 /usr/bin/composer clearcache
  /usr/bin/php83 /usr/bin/composer selfupdate
  /usr/bin/php83 /usr/bin/composer update
  /usr/bin/php83 /usr/bin/composer install --prefer-dist --no-dev
  /usr/bin/php83 ./artisan migrate --force
  /usr/bin/php83 ./artisan storage:link
@endtask

@task('install_prod', ['on' => 'production'])
  cd {{ $deploymentDir }}
  rm -rf {{ $deploymentDir }}/storage
  ln -nfs {{ $env }} {{ $deploymentDir }}/.env
  ln -nfs {{ $storage }} {{ $deploymentDir }}/storage
  /usr/bin/php83 /usr/bin/composer clearcache
  /usr/bin/php83 /usr/bin/composer selfupdate
  /usr/bin/php83 /usr/bin/composer update
  /usr/bin/php83 /usr/bin/composer install --prefer-dist --no-dev
  /usr/bin/php83 ./artisan migrate --force
  /usr/bin/php83 ./artisan storage:link
@endtask

@task('assets', ['on' => 'local'])
  scp -P{{ $scpPort }} -rq ./public/js/ {{ $scpHost }}:/opt/vendor/project/public
  scp -P{{ $scpPort }} -rq ./public/css/ {{ $scpHost }}:/opt/vendor/project/public
  scp -P{{ $scpPort }} -q ./public/mix-manifest.json {{ $scpHost }}:/opt/vendor/project/public
@endtask

@task('live', ['on' => 'dev'])
  sudo /usr/local/bin/snac_laravel_live.sh {{ $date }}
@endtask

@task('live_prod', ['on' => 'production'])
  ln -nfs {{ $deploymentDir }}/public {{ $wwwDir }}/snac-laravel-standalone
@endtask

@story('deploy')
  git
  install
  live
@endstory

@story('deploy_prod')
  git_prod
  install_prod
  live_prod
@endstory
