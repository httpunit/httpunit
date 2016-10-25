<?php

/**
 * A simple application
 * 
 * Gets and sends expected response code
 */
session_name ("temp");
session_start();

if (isset($_GET['code']))
{
  $sapi_type = php_sapi_name();

  if (substr($sapi_type, 0, 3) == 'cgi')
  {
    header("Status: {$_GET['code']} PHP-CGI");
  }
  else
  {
    header("HTTP/1.1 {$_GET['code']} PHP");
  }
}
