<?php

namespace App\Constants;


class MealTypes{
    const BREAKFAST='Breakfast';
    const DINNER='Dinner';
    const DESSERT='Dessert';
    const SNACK = 'Snack';
    const LUNCH = 'Lunch';


    public static function all(){


        return [
            self::BREAKFAST,
            self::DINNER,
            self::DESSERT,
            self::SNACK,
            self::LUNCH
        ];
    }

}