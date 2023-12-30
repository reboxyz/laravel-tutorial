<?php 

namespace Database\Factories\Helpers;

class FactoryHelpers 
{
    /**
     * This function will get a random model id from the database
     * @param string | HasFactory $model
     */
    public static function getRandomModelId(string $model) 
    {
        // Approach to initialize the user_id and post_id to a realistic data:
        // Get model count and generate random number between 1 and model count
        // If model count is 0 then we should create a new record and retrieve the record id

        $count = $model::query()->count();

        if ($count === 0) {
            return $model::factory()->create()->id;
        } else {
            return rand(1, $count);
        }
    }
}