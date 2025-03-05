<?php

namespace App;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Crypt;

trait GenerateRecoveryCode
{

    /**
     * Generate a recovery code with a mix of English words and numbers.
     *
     * @param int $wordCount The total number of elements (words + numbers)
     * @return string
     */
    public function generateRecoveryCode(int $wordCount = 15): string
    {
        $faker = Faker::create();

        // Expanded list of real English words
        $words = [
            'apple', 'banana', 'car', 'dog', 'elephant', 'forest', 'guitar', 'house', 'island', 'jungle',
            'kangaroo', 'lemon', 'mountain', 'notebook', 'ocean', 'pencil', 'queen', 'river', 'sunset', 'tiger',
            'umbrella', 'volcano', 'window', 'xylophone', 'yellow', 'zebra', 'sun', 'moon', 'star', 'cloud',
            'rocket', 'planet', 'galaxy', 'comet', 'universe', 'castle', 'bridge', 'garden', 'library', 'museum',
            'pyramid', 'tunnel', 'valley', 'canyon', 'waterfall', 'desert', 'prairie', 'rainbow', 'orchid', 'butterfly',
            'dragonfly', 'whale', 'dolphin', 'penguin', 'seagull', 'flamingo', 'octopus', 'coral', 'shell', 'wave',
            'sailboat', 'lighthouse', 'anchor', 'harbor', 'compass', 'lantern', 'clock', 'mirror', 'candle', 'windowpane',
            'backpack', 'journal', 'quill', 'scroll', 'telescope', 'binoculars', 'sundial', 'horseshoe', 'treasure', 'key',
            'puzzle', 'marble', 'riddle', 'amulet', 'charm', 'totem', 'crystal', 'emerald', 'sapphire', 'topaz',
            'ruby', 'onyx', 'silver', 'bronze', 'gold', 'copper', 'iron', 'brass', 'steel', 'quartz',
            'sandstone', 'granite', 'obsidian', 'volcano', 'eruption', 'earthquake', 'storm', 'blizzard', 'cyclone', 'hurricane',
            'lightning', 'thunder', 'mist', 'fog', 'cloudburst', 'twilight', 'dawn', 'dusk', 'midnight', 'sunrise',
            'sunset', 'eclipse', 'constellation', 'meteor', 'orbit', 'satellite', 'spaceship', 'moonlight', 'starlight', 'nebula'
        ];

        $recoveryCode = [];

        // Determine the number of words (uneven count)
        $numWords = ceil($wordCount * 0.6); // 60% words
        $numNumbers = $wordCount - $numWords; // Remaining are numbers

        // Shuffle words and pick unique ones
        shuffle($words);
        for ($i = 0; $i < $numWords; $i++) {
            $recoveryCode[] = $words[$i];
        }

        // Generate random numbers
        for ($i = 0; $i < $numNumbers; $i++) {
            $recoveryCode[] = $faker->numberBetween(100, 999); // 3-digit numbers
        }

        // Shuffle again to mix words and numbers randomly
        shuffle($recoveryCode);

        return implode(' ', $recoveryCode);
    }

    /**
     * Encrypt the generated recovery code.
     *
     * @param int $wordCount
     * @return string
     */
    public function generateEncryptedRecoveryCode(int $wordCount = 15): string
    {
        return Crypt::encryptString($this->generateRecoveryCode($wordCount));
    }
}
