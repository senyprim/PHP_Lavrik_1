<?php
header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);
$content=renderTwig('errors/403');