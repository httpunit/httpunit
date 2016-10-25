<?php

/**
 * A POST simple scenario
 */
session_name ("temp");
session_start();

if (!isset($_POST['user']))
{
  $sapi_type = php_sapi_name();

  if (substr($sapi_type, 0, 3) == 'cgi')
  {
    header("Status: 301 PHP-CGI");
  }
  else
  {
    header("HTTP/1.1 301 OK");
  }

  exit;
}
