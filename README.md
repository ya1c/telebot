# Telebot

Telebot - simple class for send messages to a chat or to bot on PHP.

## PHP Version Support

The currently required PHP version is PHP __8.0__.

See the `composer.json` for other requirements.

## Installation

Use [composer](https://getcomposer.org) to install Telebot into your project:

```sh
composer require ya1c/telebot
```
#### Example

```php
require __DIR__.'/vendor/autoload.php';

use Ya\Telebot as Telebot;

$connect = new Telebot();
$connect->setBotToken("");//e.g.: 123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
$connect->setChatId("");//Unique identifier for the target chat or username of the target channel e.g.: -10012345678 or 1234567 or @channelusername

$sendOnlyText = $connect->sendMessage(["text"=>'Send only <b>text</b>']);

$inline_button = ["text"=>"link", "url"=>"https://www.rct.uk/"];
$inline_keyboard = [[$inline_button]];
$keyboard=array("inline_keyboard"=>$inline_keyboard);
$replyMarkup = json_encode($keyboard);
$sendTextWhitReplyMarkup = $connect->sendMessage(["text"=>'Send <b>text</b> with reply markup'], 'message', $replyMarkup);

$sendLocation = $connect->sendMessage(["latitude"=>51.5014, "longitude"=>0.1419], "location");

$sendContact = $connect->sendMessage(["phone_number"=>"+443031237300", "first_name"=>"Name", "last_name"=>"Lastname"], "contact");

$sendPhoto = $connect->sendMessage(["fileType"=>"photo", "photo"=>"https://www.rct.uk/sites/default/files/styles/rctr-scale-crop-1600-625/public/bp%20hero%20winter%201600%20x%20625.jpg?itok=bSBdwrwO", "caption"=>"This is photo"], "file");
```
