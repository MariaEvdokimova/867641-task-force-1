<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class StarRatingWidget
 * @package frontend\components
 * @property float $rating
 */
class StarRatingWidget extends Widget
{
    public $rating;

    const MAX_RATING = 5;

    public function run()
    {
        return $this->render('starRating', ['filled' => $this->rating, 'disabled' => self::MAX_RATING - $this->rating]);
    }
}
