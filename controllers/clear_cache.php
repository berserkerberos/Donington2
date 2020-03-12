<?php

require_once('../header.inc.php');

try {
	$cacheAPC = CacheAPCService::getInstance();
	$cacheAPC->clearCache();
} catch (Exception $e) {
	die($e->getMessage());
}
?>
