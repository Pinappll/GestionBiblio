<?php

require_once 'vendor/autoload.php';

use GestionBiblio\Commands\Menu;

$menu = new Menu();
$menu->showMenu();