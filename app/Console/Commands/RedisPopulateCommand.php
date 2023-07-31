<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use App\Models\Game;
use App\Models\Casino;

class RedisPopulateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:redis:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =
    'Populate Redis with game and casino cards data and precalculated card order for markets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->populateGameAndCasinoCards();
        $this->precalculateCardOrderForMarkets();
    }

    private function populateGameAndCasinoCards()
    {
        // Clear previous card data in Redis (optional, depending on your requirements)
        Redis::flushdb();

        // Retrieve game and casino cards from MySQL database
        $gameCards = Game::all();
        $casinoCards = Casino::all();

        // Store game cards in Redis
        foreach ($gameCards as $gameCard) {
            $this->storeCardInRedis('game', $gameCard->id, $gameCard);
        }

        // Store casino cards in Redis
        foreach ($casinoCards as $casinoCard) {
            $this->storeCardInRedis('casino', $casinoCard->id, $casinoCard);
        }

        $this->info('Game and casino cards data populated to Redis.');
    }

    private function storeCardInRedis($type, $id, $data)
    {
        // Generate unique key for each card type
        $key = "{$type}_card:{$id}";

        // Store the card data as JSON in Redis
        Redis::set($key, json_encode($data));
    }

    private function precalculateCardOrderForMarkets()
    {
        // Retrieve unique market values for games and casinos
        $gameMarkets = Game::distinct('market')->pluck('market')->toArray();
        $casinoMarkets = Casino::distinct('market')->pluck('market')->toArray();

        // Precalculate card order for each market for games
        foreach ($gameMarkets as $gameMarket) {
            $sortedGameCards = Game::where('market', $gameMarket)->orderBy('numberOfPlays', 'desc')->get();

            // Store the sorted game card IDs in Redis under a key specific to the market
            Redis::set("market:{$gameMarket}:game_cards", json_encode($sortedGameCards->pluck('id')->toArray()));
        }

        // Precalculate card order for each market for casinos
        foreach ($casinoMarkets as $casinoMarket) {
            $sortedCasinoCards = Casino::where('market', $casinoMarket)->orderBy('rank', 'desc')->get();

            // Store the sorted casino card IDs in Redis under a key specific to the market
            Redis::set("market:{$casinoMarket}:casino_cards", json_encode($sortedCasinoCards->pluck('id')->toArray()));
        }

        // Precalculate global card order (ignoring market filtering) for games and casinos
        $globalSortedGameCards = Game::orderBy('numberOfPlays', 'desc')->get();
        $globalSortedCasinoCards = Casino::orderBy('rank', 'desc')->get();

        // Store the global sorted card IDs for games and casinos in Redis
        Redis::set('global:game_cards', json_encode($globalSortedGameCards->pluck('id')->toArray()));
        Redis::set('global:casino_cards', json_encode($globalSortedCasinoCards->pluck('id')->toArray()));

        $this->info('Card order precalculated for markets and globally, and stored in Redis.');
    }
}
