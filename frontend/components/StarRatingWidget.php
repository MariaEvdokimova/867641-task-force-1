<?php
namespace frontend\components;


use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class StarRatingWidget
 * @package frontend\components
 * @property float $rating
 * @property string $stars
 */
class StarRatingWidget extends Widget
{
    public $rating;
    public $stars;

    public function init()
    {
        $rating = round($this->rating,0);
        $starDisabled = 5- $rating;

        for ($i=1; $i <= $rating; $i++)
        {
            $this->stars .= '<span></span>';
        }

        for ($i=1; $i <= $starDisabled; $i++)
        {
            $this->stars .= '<span class="star-disabled"></span>';
        }
    }

    public function run()
    {
        return $this->stars;
    }
}