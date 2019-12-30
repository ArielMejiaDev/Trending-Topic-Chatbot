# 💬 Trending Topic Chatbot

Is a facebook chatboot to get the top 10 topics in all cities around the world.

## Getting Started 🎬

```
git clone https://github.com/ArielMejiaDev/Trending-Topic-Chatbot.git chatbot
```

### Prerequisites 🔍

    - PHP 7.2 
    - Server ready for Laravel environment recommended: [Valet](https://medium.com/ariel-mejia-dev/install-laravel-valet-on-mac-6e5229cba1e)

### Installing ⚙️

```
cd chatbot
composer install 
cp .env.example .env 
php artisan key:generate
nano .env //edit your file as you want
```

## Running the tests 🧪

The project goes with test to twitter api and facebook api for the three endpoints.

```
vendor/bin/phpunit
```

### And coding style 💻

It is written using PSR-2 and PSR-4 standard.

*the default greeting string is very long, it exceeds the 120 characters for any line limit.

## Deployment 🚀

Add additional notes about how to deploy this on a live system

## Built With 🛠️

* [Laravel](https://github.com/laravel/laravel) - The web framework used
* [Composer](https://getcomposer.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds
* [pimax/fb-messenger] (https://github.com/pimax/fb-messenger-php)
* [thujohn/twitter] (https://github.com/atymic/twitter)

## Versioning 🔢

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors 🧔

* **Ariel Mejia Dev** - [ArielMejiaDev](https://github.com/ArielMejiaDev)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Guide to use Services 📘

### TwitterService.php 

This class is located in the namespace App\Services, it is used to avoid add all twitter api call into a single file,
it has three methods, two focued on non authenticated methods of twitter API: getAllTrends and getAllEventsByCity
```
$trends = (new TwitterApiService)->getAllTrends();

$trendsByCity = (new TwitterApiService)->getTrendsByCity($locationWoeid);
```
*the location woeid is provided by twitter api in trends array returned by getAllTrends() method.

This are two wrappers for the api call methods

Maybe you will need to have in a most convinient way a map of cities and woeid so this is the third method

```
$locations = (new TwitterApiService)->getCitiesMap();
```

It returns an associative array with all cities and their respective codes.

### FacebookChatbotService 

```
//start a new instance
$bot = new FacebookChatbotService();

// set the default fallback message when received a text that does not match with any rule
// It can received an string with another message
$bot->setFallbackText();

// set the default greeting message when received a text that does not match with any rule
// It can received an string with another message
$bot->setGreetings();

// It can received a string or array of strings as the words to catch in the rule
// and a callback as a second param to execute whatever you need to add when the text received contains the word searched

$bot->responseTo('help', function() use($bot){
    $bot->text = 'Hi, How can I help you';
});

// There could be a situation when the first param is an array of strings 
// you could need to catch the exactly word that contains the text received
// in this case you only need to make an array an iterate this
$cities = ['new york', 'los angeles', 'mexico'];

foreach ($cities as $city) {
    $bot->responseTo($city, function() use($bot, $city){
        $bot->text = 'You need data from: ' . ucwords($city);
    });
}

//finally to send the response you just need to add the method send
$bot->send();
```

This api service was added to handle only the text messages situation, but the pixma fb-messenger API provides more UI posibilities (the natively from facebook), so you can extend the send(), to your situation.
