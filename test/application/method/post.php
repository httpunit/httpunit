<?php

/**
 * Tests POST simple scenario
 */
session_name ("temp");
session_start();

if (!isset($_POST['user']))
{
  http_response_code(301);
  exit(0);
}

http_response_code(200);
