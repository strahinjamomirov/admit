<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_ip".
 *
 * @property int $id
 * @property string $ip
 * @property int $is_banned
 */
class UserIp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_ip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['ip'], 'string', 'max' => 100],
            [['is_banned'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'is_banned' => 'Is Banned',
        ];
    }
}
