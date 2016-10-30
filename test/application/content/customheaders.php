<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']))
{
  echo $_SERVER['HTTP_X_REQUESTED_WITH'];
}
