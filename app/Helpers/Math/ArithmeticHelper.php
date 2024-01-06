<?php 

namespace App\Helpers\Math;

class ArithmeticHelper
{
    public static function add(...$nums) // Note! Splat Operator ...
    {
        if (sizeof($nums) < 1) {
            throw new \InvalidArgumentException("Must have at least 1 argument");
        }

        $sum = 0;
        foreach ($nums as $num) {
            if (! self::isNumeric($num)) {
                throw new \InvalidArgumentException("Argument can only be numeric.");
            }
            $sum += $num;
        }
        return $sum;
    }

    private static function isNumeric($number) {
        return (is_float($number) || is_int($number));
    }

    public static function subtract(...$nums)
    {
        if (sizeof($nums) < 1) {
            throw new \InvalidArgumentException("Must have at least 1 argument.");
        }

        // Initialize value with first element
        $difference = $nums[0];

        throw_if(! self::isNumeric($difference), new \InvalidArgumentException("Argument can only be numeric."));

        // Slice array starting at second element (index 1)
        foreach(array_slice($nums, 1) as $num) {
            if ( !self::isNumeric($num) ){
                throw new \InvalidArgumentException("Argument can only be numeric.");
            }
            $difference -= $num;
        }

        return $difference;
    }
}

?>