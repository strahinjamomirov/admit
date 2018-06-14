<?php
/**
 * Created by PhpStorm.
 * User: ubekwenisha
 * Date: 1.9.15.
 * Time: 09.44
 */

namespace common\components;

use yii\base\Event;
use yii\base\ViewEvent;
use yii\debug\Panel;
use yii\web\View;


class ViewsPanel extends Panel
{
    private $_viewFiles = [];

    public function init()
    {

        parent::init();
        Event::on(get_class(\Yii::$app->view), View::EVENT_BEFORE_RENDER, function (ViewEvent $event) {
            $this->_viewFiles[] = $event->sender->getViewFile();
        });
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Views';
    }


    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        $url = $this->getUrl();
        $count = count($this->data);
        return "<div class=\"yii-debug-toolbar__block\"><a href=\"$url\">Views <span class=\"yii-debug-toolbar__label yii-debug-toolbar__label_info\">$count</span></a></div>";
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return '<ol><li>' . implode('<li>', $this->data) . '</ol>';
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        return $this->_viewFiles;
    }

}