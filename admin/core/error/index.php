<?php
$objPage = new Page($this->objLanguage);
$page = $objPage->getError();

require_once('header.php');

echo $page['content'];

require_once('footer.php');