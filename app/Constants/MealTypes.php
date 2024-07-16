<?php

namespace App\Constants;


class MealTypes{
    const BREAKFAST='Breakfast';
    const DINNER='Dinner';
    const SALAD='Salad';
    const DESSERT='Dessert';
    const SNACK = 'Snack';
    const MAIN_COURSE = 'Main course';


    public static function all(){


        return [
            self::BREAKFAST,
            self::DINNER,
            self::SALAD,
            self::DESSERT,
            self::SNACK,
            self::MAIN_COURSE
        ];
    }

}