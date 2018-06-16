<?php

namespace common\components;

use Closure;
use Yii;
use yii\db\ActiveRecord;
use yii\grid\DataColumn;
use yii\helpers\Html;
//use yii\web\View;


/**
 * ToggleColumn
 **/
class ToggleColumn extends DataColumn
{
    /**
     * @var string the horizontal alignment of each column. Should be one of 'left', 'right', or 'center'. Defaults to
     *     `center`.
     */
    public $hAlign = 'center';

    /**
     * @var string the width of each column (matches the CSS width property). Defaults to `90px`.
     * @see http://www.w3schools.com/cssref/pr_dim_width.asp
     */
    public $width = '90px';

    /**
     * @var string|array in which format should the value of each data model be displayed. Defaults to `raw`.
     * [[\yii\base\Formatter::format()]] or [[\yii\i18n\Formatter::format()]] is used.
     */
    public $format = 'raw';

    /**
     * @var boolean|string|Closure the page summary that is displayed above the footer. Defaults to false.
     */
    public $pageSummary = false;

    /**
     * @var string label for the true value. Defaults to `Active`.
     */
    public $trueLabel;

    /**
     * @var string label for the false value. Defaults to `Inactive`.
     */
    public $falseLabel;

    /**
     * @var string icon/indicator for the true value. If this is not set, it will use the value from `trueLabel`. If
     *     GridView `bootstrap` property is set to true - it will default to [[GridView::ICON_ACTIVE]] `<span
     *     class="glyphicon glyphicon-ok text-success"></span>`
     */
    public $trueIcon;

    /**
     * @var string icon/indicator for the false value. If this is null, it will use the value from `falseLabel`. If
     *     GridView `bootstrap` property is set to true - it will default to [[GridView::ICON_INACTIVE]] `<span
     *     class="glyphicon glyphicon-remove text-danger"></span>`
     */
    public $falseIcon;

    /**
     * @var bool whether to show null value as a false icon.
     */
    public $showNullAsFalse = false;
    /**
     * Boolean Icons
     */
    const ICON_ACTIVE = '<span class="glyphicon glyphicon-ok text-success"></span>';
    const ICON_INACTIVE = '<span class="glyphicon glyphicon-remove text-danger"></span>';
    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->trueLabel)) {
            $this->trueLabel = Yii::t('app', 'Active');
        }
        if (empty($this->falseLabel)) {
            $this->falseLabel = Yii::t('app', 'Inactive');
        }
        $this->filter = [true => $this->trueLabel, false => $this->falseLabel];

        if (empty($this->trueIcon)) {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->trueIcon =  self::ICON_ACTIVE ;
        }

        if (empty($this->falseIcon)) {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->falseIcon =  self::ICON_INACTIVE ;
        }

        if ($this->enableAjax) {
            $this->registerJs();
        }
    }

    /**
     * @inheritdoc
     */
    public function getDataCellValue($model, $key, $index)
    {
        $value = parent::getDataCellValue($model, $key, $index);
        if ($value !== null) {
            return $value ? $this->trueIcon : $this->falseIcon;
        }
        return $this->showNullAsFalse ? $this->falseIcon : $value;
    }
    /**
     * Toggle action that will be used as the toggle action in your controller
     *
     * @var string
     */
    public $action = 'toggle';

    /**
     * Whether to use ajax or not
     *
     * @var bool
     */
    public $enableAjax = true;
    public $buttonClass = 'toggle-column';


    /**
     * Registers the ajax JS
     */
    public function registerJs()
    {
        $js
            = <<< JS
$("a.toggle-column").on("click", function(e) {
    e.preventDefault();
        var el = $(this).find("span");
        if( el.hasClass("text-success")){
            $.post($(this).attr("href"), function(data) {
el.removeClass("text-success").removeClass("glyphicon-ok").addClass("glyphicon-remove").addClass("text-danger");
    });
}
else{
    $.post($(this).attr("href"), function(data) {
el.addClass("text-success").addClass("glyphicon-ok").removeClass("glyphicon-remove").removeClass("text-danger");
    });
}




    return false;
});
JS;
        $this->grid->view->registerJs($js, View::POS_READY, 'admit-toggle-column');
    }


    /**
     * Returns the data cell value.
     *
     * @param ActiveRecord $model the data model
     * @param mixed        $key   the key associated with the data model
     * @param integer      $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     *
     * @return string the data cell value
     */
    protected function renderDataCellContent($model, $key, $index)
    {

        //print_r( $model);exit;


        $url = [$this->action, 'id' => $model->id];

        $attribute = $this->attribute;
        $value = $model->$attribute;

        if ($value === null || $value == true) {
           // $icon = 'ok';
            $title = Yii::t('yii', 'On');
        } else {
           // $icon = 'remove';
            $title = Yii::t('yii', 'Off');
        }

        return Html::a(
            $this->getDataCellValue($model, $key, $index),
            $url,
            [
                'title' => 'Current state: ' . $title . ' , click to toggle',
                'class' => $this->buttonClass,
                'data-method' => 'post',
                'data-pjax' => '0',
            ]
        );
    }
} 