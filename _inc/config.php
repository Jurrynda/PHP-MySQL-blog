<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

if (!session_id()) @session_start();

define("BASE_URL", "http://localhost/todo");
define("APP_PATH", realpath(__DIR__.'/../'));

require_once APP_PATH . '/_inc/vendor/autoload.php';

$config = [
  'db' => [
    'type' => 'mysql',
    'name' => 'blog',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
  ]
];

$db = new PDO("{$config['db']['type']}:host={$config['db']['server']};dbname={$config['db']['name']};charset={$config['db']['charset']}", $config['db']['username'], $config['db']['password']);
$db->setAttribute( PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );
$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );


$config = new \PHPAuth\Config($db);
$auth   = new \PHPAuth\Auth($db, $config);

try {

  $query = $db->query('SELECT * FROM tags' );

} catch( PDOException $err) {
  
  $error_message = date('j M Y, G:i') . PHP_EOL;
  $error_message .= '-------------------------' . PHP_EOL;
  $error_message .= $err->getMessage() . 'in [' . __FILE__ . ':' . __LINE__ . ']' . PHP_EOL;
  
  file_put_contents(APP_PATH . '/_inc/error.log', $error_message, FILE_APPEND);
}

require_once 'func-general.php';
require_once 'func-string.php';
require_once 'func-auth.php';
require_once 'func-post.php';


