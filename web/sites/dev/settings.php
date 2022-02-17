<?php

$settings['config_sync_directory'] = '../config/sync/default';

if (file_exists($app_root . '/sites/default/settings.base.php')) {
  include $app_root . '/sites/default/settings.base.php';
}

$databases['default']['default']['database'] = 'dev';
