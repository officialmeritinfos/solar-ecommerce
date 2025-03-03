<?php

namespace App;

use Illuminate\Support\Facades\DB;

trait GeneratesUniqueId
{
    /**
     * Generate a unique numeric ID for a given model's column.
     *
     * @param string $table The database table where uniqueness should be checked.
     * @param string $column The column where uniqueness should be enforced.
     * @param int $length The length of the numeric ID to generate.
     * @return string The unique numeric ID.
     */
    public function generateUniqueId(string $table, string $column, int $length = 10): string
    {
        do {
            // Generate a numeric random ID of the specified length
            $uniqueId = $this->generateRandomNumber($length);

            // Check if it already exists in the database
            $exists = DB::table($table)->where($column, $uniqueId)->exists();

        } while ($exists); // Retry if the ID already exists

        return $uniqueId;
    }

    /**
     * Generate a random numeric string of a given length.
     *
     * @param int $length The desired length of the number.
     * @return string The generated number.
     */
    private function generateRandomNumber(int $length): string
    {
        return (string) rand(pow(10, $length - 1), pow(10, $length) - 1);
    }
}
