<?php

namespace artsoft\models;

use artsoft\helpers\SessionDecoder;
use Yii;

/**
 * This is the model class for table "session".
 *
 * @property string $id
 * @property integer $expire
 * @property resource $data
 */
class Session extends \artsoft\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%session}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['expire'], 'integer'],
            [['data'], 'string'],
            [['id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art', 'ID'),
            'expire' => Yii::t('art', 'Expire'),
            'data' => Yii::t('art', 'Data'),
        ];
    }

    public function getSessionVars()
    {
        return SessionDecoder::unserialize($this->getAttribute('data'));
    }

    public static function getList()
    {
        $result = [
            'total' => 0,
            'active' => 0,
            'list' => []
        ];
        $list = static::find()->orderBy('expire desc')->all();
        foreach ($list as $v) {
            /* @var $v Session */
            $vars = $v->getSessionVars();
           //echo '<pre>' . print_r($v, true) . '</pre>';
            /* @var $user User */
            $user = isset($vars['__id']) ? User::findOne($vars['__id']) : null;
            $runAt = isset($vars['_last_attempt']) ? $vars['_last_attempt'] : 0;
            $expired = time() - $v->expire > 0 || $user === null;
            $current = $v->id == Yii::$app->session->getId();
            $age = Yii::$app->formatter->asRelativeTime($runAt);
            $result['list'][] = [
                'id' => $v->id,
                'user_id' => isset($vars['__id']) ? $vars['__id'] : 0,
                'user_name' => $user ? $user->username : '',
                'run_at' => Yii::$app->formatter->asDateTime($runAt),
                'ip' => isset($vars['__ipaddr']) ? $vars['__ipaddr'] : '',
                'status' => $expired ? 'idle' : ($current ? 'current' : 'active'),
                'statusText' => $expired ? 'В ожидании' . ' (' . $age . ')' : ($current ? 'Текущая' : 'Активная' . ' (' . $age . ')')
            ];
            //var_dump($runAt);var_dump(Yii::$app->formatter->asRelativeTime($runAt));exit;
        }
        $result['total'] = count($result['list']);
        $result['active'] = count(array_filter($result['list'], function ($v) {
            return 'idle' !== $v['status'];
        }));
        return $result;
    }
}
