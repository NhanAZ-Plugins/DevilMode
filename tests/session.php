<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/NhanAZ/DevilMode/Session.php';

use NhanAZ\DevilMode\Session;

$session = new Session(false);
if ($session->isDevilMode()) {
	throw new RuntimeException('A new session must start with Devil Mode disabled');
}
$session->setDevilMode(true);
if (!$session->isDevilMode()) {
	throw new RuntimeException('Devil Mode did not enable');
}
$session->setDevilMode(false);
if ($session->isDevilMode()) {
	throw new RuntimeException('Devil Mode did not disable');
}
echo "PASS: Devil Mode session transitions\n";
