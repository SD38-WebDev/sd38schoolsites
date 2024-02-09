<?php

$settings['config_sync_directory'] = '../config/sync/default';

$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

$settings['file_private_path'] = $app_root . '/../private';

if (file_exists($app_root . '/sites/default/settings.base.php')) {
  include $app_root . '/sites/default/settings.base.php';
}

$databases['default']['default']['database'] = 'schooldev';
