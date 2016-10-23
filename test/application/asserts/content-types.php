<?php

/**
 * A simple application
 * 
 * Gets and sends expected content type
 */
session_name ("temp");
session_start();

if (isset($_GET['mime']))
{
  header('Content-Type: ' . $_GET['mime']);
}
