<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Enums\UpdateType;
use Telegram\{Client as Bot, InlineKeyboard, Updates};

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(dirname(__FILE__, 2));
$dotenv->load();

Bot::create(env("TELEGRAM_API_KEY"));

Bot::start(function($context) {
    $context::sendMessage(Updates::chatId(), "Hey");
});

Bot::help(function($context) {
    $context::sendMessage(Updates::chatId(), "Esto es un mensaje de ayuda");
});

Bot::command('frasquito', function($context, $parameters) {
    $keyboard = new InlineKeyboard;
    $keyboard->inlineKeyboardButton('Click me', "callback");
    $keyboard->inlineKeyboardButton('Click me derecha', "callback2")->endRow();
    $keyboard->inlineKeyboardButton('Click me abajo', "callback3")->endRow();

    $name = Updates::username();
    $data = json_encode($parameters, JSON_PRETTY_PRINT);
    $context->sendMessage(Updates::chatId(), "Hello to you {$name} you send parameters {$data} command", [
        'reply_markup' => $keyboard->inlineKeyboardMarkup()
    ]);
});

Bot::on(UpdateType::STICKER, function($context) {
    $context::sendMessage(Updates::chatId(), "Esto es un sticker");
});

Bot::on(UpdateType::PHOTO, function($context) {
    $context::sendMessage(Updates::chatId(), "Esto es una foto");
});

Bot::hears([
        'text' => 'hello',
        'capital' => 'lowercase'
    ], function($context, $word) {
    $keyboard = new InlineKeyboard;
    $keyboard->inlineKeyboardButton('Click me', "callback");
    $keyboard->inlineKeyboardButton('Click me derecha', "callback2")->endRow();
    $keyboard->inlineKeyboardButton('Click me abajo', "callback3")->endRow();

    $context->sendMessage(Updates::chatId(), "He oido que has dicho {$word}", [
        'reply_markup' => $keyboard->inlineKeyboardMarkup()
    ]);
});

Bot::hears('/([\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$)/', function($context, $word) {
    $context->sendMessage(Updates::chatId(), "He oido que has dicho {$word}");
});

//bot::run()::Polling();