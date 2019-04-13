<?php

namespace artsoft\widgets;

use Yii;
use asinfotrack\yii2\flagicons\Flag;
use cetver\LanguageSelector\items\DropDownLanguageItem;
use artsoft\widgets\assets\LanguageSelectorAsset;
use yii\bootstrap\Nav;
use yii\helpers\Html;


class LanguageSelector extends \yii\base\Widget
{
    /**
     *
     * @var string  code | label
     */
    public $display = 'code';

    /**
     * Allows viewing flag icon
     * 
     * @var boolean 
     */
    public $flag_visible = true;
    
    /**
     *
     * @var type array
     */
    public $code_redirect = ['en-US' => 'us'];
    
    /**
     *
     * @var type array
     */
    public $options = ['class' => 'navbar-nav navbar-right'];
    
    /**
     * Returns language shortcode from its redirect.
     * 
     * @param string $language
     * @return string
     */
    private function getCountryCode($language) {
        
        if (!isset($this->code_redirect)) {
            return $language;
        }

        return (isset($this->code_redirect[$language])) ? $this->code_redirect[$language] : $language;
    }

    public function run()
    {
        if (!Yii::$app->art->isMultilingual) {
            return;
        }
       
        LanguageSelectorAsset::register($this->view);
        
        foreach (Yii::$app->art->languages as $key => $label) :

            $item[$key] = $this->flag_visible ? Flag::icon($this->getCountryCode($key)) : NULL;
            $item[$key] .= Html::tag('span', ($this->display == 'code') ? $key : $label);

        endforeach;

        $languageItem = new DropDownLanguageItem([
             'languages' => $item,
             'options' => ['encode' => false],
         ]);

        echo Nav::widget([
             'options' => $this->options,
             'items' => [         
                 $languageItem->toArray()
             ]
        ]);
    }
}