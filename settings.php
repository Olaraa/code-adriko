<?php

$databases = array (
  'default' => 
  array (
    'default' => 
    array (
      'database' => 'dinterac_adrikodb',
      'username' => 'dinterac_drupal',
      'password' => 'WrX6QzyqFWB2v9d2',
      'host' => 'localhost',
      'port' => '',
      'driver' => 'mysql',
      'prefix' => '',
    ),
  ),
);

$update_free_access = FALSE;
$drupal_hash_salt = '6ILXI9VuUlpmSa2kSk9e61wnJqwFeLaiNE9F7KX890s';
# $base_url = 'http://www.example.com';  // NO trailing slash!

ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 200000);
ini_set('session.cookie_lifetime', 2000000);

# ini_set('pcre.backtrack_limit', 200000);
# ini_set('pcre.recursion_limit', 200000);
# $cookie_domain = 'example.com';

# $conf['site_name'] = 'My Drupal site';
# $conf['theme_default'] = 'garland';
# $conf['anonymous'] = 'Visitor';
$conf['maintenance_theme'] = 'site_theme';

# $conf['reverse_proxy'] = TRUE;
# $conf['reverse_proxy_header'] = 'HTTP_X_CLUSTER_CLIENT_IP';
# $conf['reverse_proxy_addresses'] = array('a.b.c.d', ...);
# $conf['omit_vary_cookie'] = TRUE;

# $conf['css_gzip_compression'] = FALSE;
# $conf['js_gzip_compression'] = FALSE;

# $conf['locale_custom_strings_en'][''] = array(
#   'forum'      => 'Discussion board',
#   '@count min' => '@count minutes',
# );

# $conf['blocked_ips'] = array(
#   'a.b.c.d',
# );

# $conf['allow_authorize_operations'] = FALSE;
