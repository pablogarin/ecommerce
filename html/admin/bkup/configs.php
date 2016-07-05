<?php

$cur = $dbh->query("select * from configs;");
$view->set("configs", $cur);

$view->setTemplate("configs.html");
$content = $view->getView();
