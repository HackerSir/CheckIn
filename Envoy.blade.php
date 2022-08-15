@servers(['web' => 'deployer@' . $server])

@setup
$repository = 'https://github.com/HackerSir/CheckIn.git';
$checkoutBranch = '2022';
$websiteName = 'CheckIn';
$releases_dir = '/var/www/' . $websiteName . '/releases';
$app_dir = '/var/www/' . $websiteName;
$release = date('YmdHis');
$new_release_dir = $releases_dir .'/'. $release;
@endsetup

@story('deploy')
clone_repository
update_symlink_env
    run_composer
    stop_horizon
    yarn_install
    artisan_migrate
    update_symlinks_other
    cache_config_and_route
    restart_php_service
    start_horizon
    restart_echo_server
    keep_newest_3_releases
@endstory

@task('clone_repository')
    echo '===== Cloning repository ====='
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 --branch {{ $checkoutBranch }} --single-branch {{ $repository }} {{ $new_release_dir }}
@endtask

@task('run_composer')
    echo "===== Starting deployment ({{ $release }}) ====="
    echo "===== Composer install ====="
    cd {{ $new_release_dir }}
    composer install --no-dev --prefer-dist --no-progress -o
@endtask

@task('yarn_install')
    echo "===== Yarn install ====="
    cd {{ $new_release_dir }}
    yarn install --no-progress
    yarn run prod --no-progress
@endtask

@task('update_symlink_env')
    echo '===== Linking .env file ====='
    ln -nfs {{ $app_dir }}/shared/.env {{ $new_release_dir }}/.env
@endtask

@task('artisan_migrate')
    echo "===== Starting migrate ====="
    cd {{ $new_release_dir }}
    php artisan migrate --force --no-interaction
@endtask

@task('update_symlinks_other')
    echo "===== Linking storage directory ====="
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/shared/storage {{ $new_release_dir }}/storage

    echo "===== Linking laravel-echo-server.json ====="
    ln -nfs {{ $app_dir }}/shared/laravel-echo-server.json {{ $new_release_dir }}/laravel-echo-server.json

    echo '===== Linking current release ====='
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('cache_config_and_route')
    cd {{ $new_release_dir }}
    php artisan cache:clear
    php artisan route:cache
    php artisan view:clear
    php artisan config:cache
@endtask

@task('restart_php_service')
    sudo systemctl reload php7.4-fpm.service
@endtask

@task('stop_horizon')
    sudo supervisorctl stop checkIn_horizon
@endtask

@task('start_horizon')
    sudo supervisorctl start checkIn_horizon
@endtask

@task('restart_echo_server')
    sudo supervisorctl restart checkIn_laravel_echo_server
@endtask

@task('keep_newest_3_releases')
    cd {{ $releases_dir }}
    ls -1tr | head -n -3 | xargs -d '\n' rm -rf --
@endtask
