<?php
error_reporting(0);
session_start();
function sanitizeit() {

    # ***** BEGIN LICENSE BLOCK *****
    # This file is part of HTML Sanitizer.
    # Copyright (c) 2005-2009 Frederic Minne <zefredz@gmail.com>.
    # All rights reserved.
    #

    # HTML Sanitizer is free software; you can redistribute it and/or modify
    # it under the terms of the GNU Lesser General Public License as published by
    # the Free Software Foundation; either version 3 of the License, or
    # (at your option) any later version.
    #

    # HTML Sanitizer is distributed in the hope that it will be useful,
    # but WITHOUT ANY WARRANTY; without even the implied warranty of
    # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    # GNU General Public License for more details.
    #

    # You should have received a copy of the GNU Lesser General Public License
    # along with HTML Sanitizer; if not, see <http://www.gnu.org/licenses/>.
    #
    # ***** END LICENSE BLOCK *****
    /**

     * @author  Frederic Minne <zefredz@claroline.net>
     * @copyright Copyright &copy; 2006-2007, Frederic Minne
     * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License version 3 or later
     * @version 1.0
     * @package HTML
     */

	include('includes/config.php');
    require_once dirname(__FILE__) . '/sanitizer.class.php';
    $san = new HTML_Sanitizer;
    $san->allowScript();
    $san->allowDOMEvents();

	if ($_GET) {
		foreach ($_GET as $k => $v)
		{
			$val = htmlspecialchars($san->sanitize( $v));
			$val = strip_javascript($val);
			$val = htmlentities($val);
			$val = is_valid_string($val);
			$_GET[$k] = $val;
		}
	}

	if ($_POST) {
		foreach ($_POST as $k => $v){		
			if ($v != '') {		
				//$val = htmlspecialchars($san->sanitize( $v));
				if (get_magic_quotes_gpc()){
				$v = stripslashes($v);
				}

				$val = mysqli_real_escape_string($conn,$v);
				$val = strip_javascript($v);
				$_POST[$k] = $val;
			}
		}
	}


	if ($_COOKIE) {
		foreach ($_COOKIE as $k => $v){
			$val = htmlspecialchars($san->sanitize( $v));
			$val = strip_javascript($val);
			$val = htmlentities($val);
			$val = is_valid_string($val);
			$_COOKIE[$k] = $val;
		}
	}	


	if ($_FILES) {
		foreach ($_FILES as $k => $v){
			$val = $v;
//			$val = htmlspecialchars($san->sanitize( $val));
			$val = strip_javascript($val);
			//$val = htmlentities($val);
			//$val = is_valid_string($val);
			//$val = mysql_real_escape_string($val);
			//$_FILES[$k] = htmlentities($val);
			$_FILES[$k] = $val;
		}
	}	

	if ($_REQUEST) {
		foreach ($_REQUEST as $k => $v)	{
			$val = htmlspecialchars($san->sanitize( $v));
			$val = strip_javascript($val);
			$val = htmlentities($val);
			$val = is_valid_string($val);
			$_REQUEST[$k] = $val;
		}
	}	

	if ($_ENV) {
		foreach ($_ENV as $k => $v)	{
			$val = htmlspecialchars($san->sanitize( $v));
			$val = strip_javascript($val);
			$val = htmlentities($val);
			$val = is_valid_string($val);
			$_ENV[$k] = $val;
		}
	}	
	//isitvalidauthentication();
}


function safe($str){
	$str = htmlspecialchars_decode($str);
	$str = nl2br($str);
	return $str;
}

function removequote($str){
	return str_replace("'", "&rsquo;", $str);
}

function dateformat($dat){
	if ($dat){
		$e1=explode(" ",$dat);
		$e=explode("-",$e1[0]);
		$e2=explode(":",$e1[1]);
		return $e[2]."-".$e[1]."-".$e[0];
	}
}

function changeimage($path){
	$ret=str_replace ("../images/","images/",$path);
	return $ret;
}

function removep($str){
	$str = str_replace("<p>","<span>",$str);
	$str = str_replace("</p>","</span><br/><br/>",$str);
	return $str;
}

function checkrecordexist($tbl, $fld, $val)	{
	$sql = "SELECT * FROM ".$tbl;
	if ($fld != '') {$sql .= " WHERE ".$fld." = '".$val."'"; }
	$resCX = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($resCX) > 0) { $res = 'true'; } else {$res = 'false'; }
	return $res;
}

function strip_javascript($filter){ 
    // realign javascript href to onclick 
    $filter = preg_replace("/href=(['\"]).*?javascript:(.*)? 
\\1/i", "onclick=' $2 '", $filter); 

	//remove javascript from tags 
    while( preg_match("/<(.*)?javascript.*?\(.*?((?>[^()]+) 
|(?R)).*?\)?\)(.*)?>/i", $filter)) 
        $filter = preg_replace("/<(.*)?javascript.*?\(.*?((?> 
[^()]+)|(?R)).*?\)?\)(.*)?>/i", "<$1$3$4$5>", $filter); 

    // dump expressions from contibuted content 
    if(0) $filter = preg_replace("/:expression\(.*?((?>[^ 
(.*?)]+)|(?R)).*?\)\)/i", "", $filter); 

    while( preg_match("/<(.*)?:expr.*?\(.*?((?>[^()]+)|(? 
R)).*?\)?\)(.*)?>/i", $filter)) 

        $filter = preg_replace("/<(.*)?:expr.*?\(.*?((?>[^()] 
+)|(?R)).*?\)?\)(.*)?>/i", "<$1$3$4$5>", $filter); 
        
    // remove all on* events    
    while( preg_match("/<(.*)?\s?on.+?=?\s?.+?(['\"]).*?\\2 
\s?(.*)?>/i", $filter) ) 

       $filter = preg_replace("/<(.*)?\s?on.+?=?\s?.+? 
(['\"]).*?\\2\s?(.*)?>/i", "<$1$3>", $filter); 

    return $filter; 
} 

function is_valid_string($string){
	$allowed_symbols = array(':','.','-','_'); // Add more as needed.
	if ( ctype_alnum(str_replace($allowed_symbols, '', $string))) {return $string; } else {return ''; }
}

function isitvalidauthentication(){
	$currentFile = $_SERVER["SCRIPT_NAME"]; 
	$parts = Explode('/', $currentFile); 
	$currentFile = $parts[count($parts) - 1];
	
	if ($currentFile != 'login.php')
	{
		if ($_SESSION['isauthenticatedsession'] == '' || !isset($_SESSION['isauthenticatedsession'])) 
		{
			echo '<script language="JavaScript">self.location.href="/siteman/login.php";</script>';
		}
	}
}
?>