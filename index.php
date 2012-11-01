<?php
$debut = microtime(true); 

define('WEBROOT',dirname(__FILE__)); 
define('ROOT',dirname(WEBROOT)); 
define('DS',DIRECTORY_SEPARATOR);
define('CORE',WEBROOT.DS.'core'); 
define('BASE_URL',dirname($_SERVER['SCRIPT_NAME'])); 

require CORE.DS.'includes'.DS.'includes.php'; 

?>
