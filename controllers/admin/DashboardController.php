<?php

namespace artsoft\controllers\admin;

use yii\helpers\ArrayHelper;

class DashboardController extends BaseController
{
    /**
     * @inheritdoc
     */
    public $enableOnlyActions = ['index'];
    public $widgets = NULL;

    public function actions()
    {

        if ($this->widgets === NULL) {
            $this->widgets = [
                'artsoft\comment\widgets\dashboard\Comments',
                [
                    'class' => 'artsoft\widgets\dashboard\Info',
                    'position' => 'right',
                ],

                [
                    'class' => 'artsoft\media\widgets\dashboard\Media',
                    'position' => 'right',
                ],
                'artsoft\post\widgets\dashboard\Posts',
                'artsoft\user\widgets\dashboard\Users',
            ];
        }

        return ArrayHelper::merge(parent::actions(), [
            'index' => [
                'class' => 'artsoft\web\DashboardAction',
                'widgets' => $this->widgets,
            ]
        ]);
    }
}