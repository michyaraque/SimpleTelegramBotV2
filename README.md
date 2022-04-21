![PHP](https://img.shields.io/badge/PHP-%3E%3D%208.0-8892bf.svg)
![CURL](https://img.shields.io/badge/cURL-required-green.svg)

## SimpleTelegramBot Version 2 (now it's really simple I swear)

👷‍♀️ Work in progress ...

## Introduction
Creating telegram bots has always been my passion, this is the second time I create a library for telegram but the previous library was not very successful because of its complexity of use, that's why I decided to create this framework that is robust, compact, easy to use and available to everyone.

## Create a new Instance

```php
use Telegram\{Client as Bot, Updates};

Bot::create("API_KEY");
```

## Chaining method [ command ]

Shorthand methods

```php
Bot::command('start', function($context) {
    $context::sendMessage(Updates::chatId(), "Hi this is a start command");
});

// Commands also can handle user parameters
Bot::command('rate', function($context, $parameters) {
    $rate = $parameters[1] * 0.40;
    $context::sendMessage(Updates::chatId(), "The rate is {$rate}");
});
// Output: The rate is 12
```

## Chaining method [ on ]
This chaining method allows you to handle a specific type of update, for example, to handle only updates that are of type "Sticker"

```php
Bot::on(UpdateType::STICKER, function($context) {
    $context::sendMessage(Updates::chatId(), "This is a update of type Sticker");
});

// Can use array to declare multiple update types
Bot::on([UpdateType::STICKER, UpdateType::Reply], function($context) {
    $context::sendMessage(Updates::chatId(), "This update is Sticker or a message Reply");
});
```

## Chaining method [ hears ]
The hears method allow to listen a specific word/phrase in the input of the user

```php
Bot::hears('hello', function($context, $word) {
    $context->sendMessage(Updates::chatId(), "I hear the word {$word}");
});
```

## Update types already created 

| Update Type |       Enum     |
|-------------|----------------|
|             | INLINE_QUERY   |
|             | CALLBACK_QUERY |
|             | MESSAGE        |
|             | EDITED_MESSAGE |
|             | REPLY          |
|             | PHOTO          |
|             | VIDEO          |
|             | AUDIO          |
|             | VOICE          |
|             | STICKER        |
|             | DOCUMENT       |
|             | LOCATION       |
|             | CONTACT        |
|             | CHANNEL_POST   |

Contact me
------------

You can contact me [via Telegram](https://telegram.me/michyaraque) 
For issues:  [open](https://github.com/michyaraque/SimpleTelegramBotV2/issues) one.