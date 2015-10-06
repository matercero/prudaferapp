<?php

/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array(/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
function redondear_dos_decimal($valor) {
    $float_redondeado = round($valor * 100) / 100;
    return $float_redondeado;
}
function str_fecha_mysql($string, $format = 'Y-m-d'){
    return date($format,strtotime(str_replace('/', '-', $string)));
}

function zerofill ($num, $zerofill = 6){
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}


function str_rsplit($str, $sz){
    // splits a string "starting" at the end, so any left over (small chunk) is at the beginning of the array.    
    if ( !$sz ) { return false; }
    if ( $sz > 0 ) { return str_split($str,$sz); }    // normal split
    
    $l = strlen($str);
    $sz = min(-$sz,$l);
    $mod = $l % $sz;
    
    if ( !$mod ) { return str_split($str,$sz); }    // even/max-length split

    // split
    return array_merge(array(substr($str,0,$mod)), str_split(substr($str,$mod),$sz));
}
function str_time_mysql($string){
    $time =  str_rsplit($string,-2);
    return date('H:i:s',strtotime($time[0].':'.$time[1].':00'));
}
function number_to_comma($number,$decimals = 2){
    return number_format($number,$decimals, ',','.');
}
setlocale(LC_ALL, 'en_US.utf8');
date_default_timezone_set('Europe/Madrid');
?>
