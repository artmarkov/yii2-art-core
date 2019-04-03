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
                'artsoft\user\widgets\dashboard\UsersVisitMap',
                [
                    'class' => 'artsoft\widgets\dashboard\Info',
                    'position' => 'right',
                ],
                'artsoft\comment\widgets\dashboard\Comments',
                [
                    'class' => 'artsoft\user\widgets\dashboard\Users',
                    'position' => 'right',
                ], 
                'artsoft\post\widgets\dashboard\Posts',
                [
                    'class' => 'artsoft\media\widgets\dashboard\Media',
                    'position' => 'right',
                ],
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