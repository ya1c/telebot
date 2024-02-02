<?php
require __DIR__.'/vendor/autoload.php';

use Ya\Telebot as Telebot;

$connect = new Telebot();
//$connect->setBotToken("123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11");//e.g.: 123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
//$connect->setChatId("");//Unique identifier for the target chat or username of the target channel e.g.: -10012345678 or 1234567 or @channelusername

$inline_button = ["text"=>"link", "url"=>"https://www.rct.uk/"];
$inline_keyboard = [[$inline_button]];
$keyboard=array("inline_keyboard"=>$inline_keyboard);
$replyMarkup = json_encode($keyboard);
print_r($connect);

//$connect = new Telebot();
//$connect->setBotToken("2019476825:AAF_8OY3_kldjU59DFwkBLU5gwvIy_3j94s");
//$connect->setChatId("38981451");

//$sendOnlyText = $connect->sendMessage(["text"=>'Send only <b>text</b>']);
//$sendTextWhitReplyMarkup = $connect->sendMessage(["text"=>'Send <b>text</b> with reply markup'], 'message', $replyMarkup);
//$sendLocation = $connect->sendMessage(["latitude"=>51.5014, "longitude"=>0.1419], "location");
//$sendContact = $connect->sendMessage(["phone_number"=>"+443031237300", "first_name"=>"Name", "last_name"=>"Lastname"], "contact");
//$sendPhoto = $connect->sendMessage(["fileType"=>"photo", "photo"=>"https://www.rct.uk/sites/default/files/styles/rctr-scale-crop-1600-625/public/bp%20hero%20winter%201600%20x%20625.jpg?itok=bSBdwrwO", "caption"=>"This is photo"], "file");


//webhookinfo
//$connect = new Telebot();
/*

{
    "name": "ya1c/telebot",
  "description": "Telebot - simple script for your send messages",
  "keywords": [
    "PHP",
    "telegram",
    "bot"
],
  "type": "library",
  "license": "MIT",
  "authors": [
    {
        "name": "ya1c"
    }
  ],
  "require": {
    "ya1c/telebot": "^1.0"
  },
  "config": {
    "platform": {
        "php": "8.0"
    }
  },
  "autoload": {
    "psr-4": {
        "Telebot\\": "src/Telebot"
    }
  }
}
*/