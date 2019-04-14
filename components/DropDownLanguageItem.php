<?php

namespace artsoft\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use cetver\LanguageSelector\items\AbstractLanguageItem;

class DropDownLanguageItem extends AbstractLanguageItem
{
    /**
     * replace original class cetver\LanguageSelector\items\DropDownLanguageItem
     * use in artsoft\widgets\LanguageSelector
     * @inheritdoc
     */
    public function toArray()
    {
        $languages = $this->languages;
        $topItemLabel = ArrayHelper::remove($languages, Yii::$app->language);
        if ($topItemLabel === null) {
            throw new InvalidConfigException(sprintf(
                'The "%s" language does not exists in "%s::$languages"',
                Yii::$app->language,
                self::className()
            ));
        }
        $item = ArrayHelper::merge($this->options, [
            'label' => $topItemLabel,
            'url' => ['#'],
        ]);
        $queryParams = Yii::$app->getRequest()->getQueryParams();
        foreach ($languages as $code => $name) {
            $queryParams[$this->queryParam] = Yii::$app->art->getDisplayLanguageShortcode($code);
            $route = array_merge([''], $queryParams);
            $item['items'][] = ArrayHelper::merge($this->options, [
                'label' => $name,
                'url' => Url::toRoute($route),
            ]);
        }

        return $item;
    }
}
