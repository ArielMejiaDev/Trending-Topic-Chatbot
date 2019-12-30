<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FacebookChatbotService;
use App\Services\TwitterApiService;

class ChatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bot = new FacebookChatbotService();

        $locations = (new TwitterApiService)->getCitiesMap();

        $bot->setFallbackText()->setGreetings();
        
        $bot->responseTo('help', function() use($bot){
            $bot->text = 'Hi, How can I help you';
        });

        foreach ($locations as $locationKey => $locationValue) {

            $bot->responseTo($locationKey, function() use($bot, $locationKey, $locationValue){
                $bot->text = 'This is the top ten Trendings of ' . ucwords($locationKey);
                $trendsByCity = (new TwitterApiService)->getTrendsByCity($locationValue);
                for ($i=0; $i < 10; $i++) { 
                    $bot->text .= "\n". ($i+1) . ' - ' . $trendsByCity[$i]->name;
                }
            });

        }

        $bot->send();
    }
}
