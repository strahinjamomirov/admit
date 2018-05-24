<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace common\models;

use common\components\Json;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%option}}".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $value
 * @property string  $label
 * @property string  $group
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
class Option extends ActiveRecord
{

    public static $cached = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%option}}';
    }

    /**
     * Add new option, required name and value.
     * If value is array or object, it will be converted to json with Json::encode.
     *
     * @param string       $name
     * @param string       $value
     * @param string|array $label
     * @param string       $group
     *
     * @return bool
     * @throws \Throwable
     */
    public static function set($name, $value, $label = null, $group = null)
    {
        if (is_array($value) || is_object($value)) {
            $value = Json::encode($value);
        }

        if (static::get($name) !== null) {
            return static::up($name, $value);
        }

        $model = new Option([
            'name'  => $name,
            'value' => $value,
            'label' => $label,
            'group' => $group,
        ]);

        return $model->save();
    }

    /**
     * Get option value.
     * The return value array|boolean|string depends on value.
     * If value is string then the return value is a string.
     * If value is array|object then return value is array.
     * If name not found in table then it will return false.
     *
     * @param string $name
     *
     * @return string|array|boolean
     * @throws \Throwable
     */
    public static function get($name)
    {
        if (!static::$cached) {
            static::$cached = Yii::$app->db->cache(function () {
                return Option::find()->select(['name', 'value'])->indexBy('name')->all();
            });
        }
        if (!isset(static::$cached[$name])) {
            return null;
        }
        /* @var $model \common\models\Option */
        $model = static::$cached[$name];

        if (Json::isJson($model->value)) {
            return Json::decode($model->value);
        }

        return $model->value;

    }

    /**
     * Update option with name as key.
     *
     * @param string       $name
     * @param string|array $value
     *
     * @return bool
     */
    public static function up($name, $value)
    {
        /* @var $model \common\models\Option */
        $model = static::findOne(['name' => $name]);

        if (is_array($value) || is_object($value)) {
            $model->value = Json::encode($value);
        } else {
            $model->value = $value;
        }

        return $model->save();
    }

    /**
     * Get menu item to render in admin sidebar left.
     *
     * @param int $position
     *
     * @return array
     */
    public static function getMenus($position = 30)
    {
        $items[$position] = ['label' => Yii::t('cms', 'Settings'), 'icon' => 'fa fa-cogs'];
        $items[$position]['items'] = static::getSubmenus();

        return $items;
    }

    /**
     * The option will be grouped into group to create new submenu item.
     *
     * @return array|null
     */
    protected static function getSubmenus()
    {
        /* @var $model \common\models\Option */
        $models = static::find()
            ->select('group')
            ->groupBy('group')
            ->andWhere(['<>', 'group', ''])
            ->andWhere(['<>', 'group', 'theme'])
            //          ->orderBy(['id' => SORT_ASC])
            ->all();
        $items = null;

        foreach ($models as $model) {
            $items[] = [
                'icon'    => 'fa fa-circle-o',
                'label'   => Yii::t('cms', ucwords($model->group)),
                'url'     => ['/setting/group/', 'id' => strtolower($model->group)],
                'visible' => Yii::$app->user->can('administrator'),
            ];
        }

        return $items;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['value', 'string'],
            [['name', 'label', 'group'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => Yii::t('cms', 'ID'),
            'name'  => Yii::t('cms', 'Name'),
            'value' => Yii::t('cms', 'Value'),
            'label' => Yii::t('cms', 'Label'),
            'group' => Yii::t('cms', 'Group'),
        ];
    }
}
