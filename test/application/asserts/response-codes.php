<?php

/**
 * It's a simple scenario:
 * - Gets and sends expected response code
 */
session_name ("temp");
session_start();

if (isset($_GET['code']))
{
  http_response_code($_GET['code']);
}
