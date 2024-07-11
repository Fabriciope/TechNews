<?php

error_reporting(E_ALL);

require_once __DIR__ . "./../routes/web.php";
require_once __DIR__ . "/AppLauncher.php";

AppLauncher::bootstrap($router);
