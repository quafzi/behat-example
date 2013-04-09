<?php
set_include_path(dirname(__FILE__).'/../src/'.PATH_SEPARATOR.get_include_path());

spl_autoload_extensions('.php');
spl_autoload_register('spl_autoload');
//echo __FILE__ . ' on line ' . __LINE__ . ':<pre>';var_dump(str_replace(':', PHP_EOL, get_include_path())); echo '</pre>';die();
