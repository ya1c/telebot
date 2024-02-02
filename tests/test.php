<?php

include_once('../src/Telebot.php');

use Ya\Telebot as Telebot;

if (class_exists('Ya\Telebot')) {
    print('exist.' . PHP_EOL);
} else {
    print('not exist.' . PHP_EOL);
}

$connect = new Telebot();
echo '<pre>';
print_r($connect);
echo '</pre>';