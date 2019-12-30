<?php namespace App\Services;

use Illuminate\Support\Str;
use pimax\FbBotApp;
use pimax\Messages\Message;

class FacebookChatbotService 
{

    protected $bot;
    protected $sender;
    protected $receivedText;
    protected $greetingText = "Hi I am a Twitter Trending Chatbot\nYou can text me any city and I will give you the trending topics\nExample: 'Berlin trends', 'trends of London' or 'From Mexico' \nI support a variety of ways to ask for a trend";
    protected $greetingsNeedles = ['hi', 'hello', 'good morning', 'good evening', 'good afternoon'];
    protected $fallbackText = 'I´m sorry I didn´t understand the request';
    public $text;


    public function __construct()
    {
        $this->sender = request()->all()['entry'][0]['messaging'][0]['sender']['id'];
        $this->receivedText = strtolower(request()->all()['entry'][0]['messaging'][0]['message']['text']);
        $this->bot = new FbBotApp(config('app.pageAccessToken'));
        return $this;
    }

    public function setFallbackText(string $fallbackText = null) 
    {
        if ($fallbackText) {
            $this->fallbackText = $fallbackText;
        }
        $this->text = $this->fallbackText;
        
    }

    public function setGreetings(string $greetingText = null, $needles = [])
    {
        if ($needles) $this->greetingsNeedles = $needles;
        if ($greetingText) $this->greetingText = $greetingText;

        if (Str::contains($this->receivedText, $this->greetingsNeedles)) {
            $this->text = $this->greetingText;
        }
        return $this;
    }

    public function responseTo($needle, $callback)
    {
        if (Str::contains(strtolower($this->receivedText), $needle)) {
            $callback();
        }
    }

    public function send()
    {
        $message = new Message($this->sender, $this->text);
        return $this->bot->send($message);
    }

}