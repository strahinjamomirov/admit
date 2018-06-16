<?php

namespace common\components;


use Yii;
use yii\base\ViewEvent;

/**
 * Class View
 *
 * @package frontend\components
 */
class View extends \yii\web\View
{
	static $scriptIds = 0;

	public $pageClass = 'home-page';

	/**
	 * This method is invoked right after [[renderFile()]] renders a view file.
	 * The default implementation will trigger the [[EVENT_AFTER_RENDER]] event.
	 * If you override this method, make sure you call the parent implementation first.
	 *
	 * @param string $viewFile the view file being rendered.
	 * @param array  $params   the parameter array passed to the [[render()]] method.
	 * @param string $output   the rendering result of the view file. Updates to this parameter
	 *                         will be passed back and returned by [[renderFile()]].
	 */
	public function afterRender($viewFile, $params, &$output)
	{
		if ($this->hasEventHandlers(self::EVENT_AFTER_RENDER)) {
			$event = new ViewEvent(
				[
					'viewFile' => $viewFile,
					'params' => $params,
					'output' => $output,
				]
			);
			$this->trigger(self::EVENT_AFTER_RENDER, $event);
			$output = $this->processContent($event->output);
		}
		$output = $this->processContent($output);
	}

	/**
	 * @param $content
	 *
	 * @return mixed
	 */
	public function processContent($content)
	{
		$regex = '%<script rel="inline-ready">(.+)</script>%imsU';
		$content = preg_replace_callback($regex, [$this, 'addScript'], $content);
		return $content;
	}

	/**
	 * @param $matches
	 *
	 * @return string
	 */
	protected function addScript($matches)
	{
		$script = trim($matches[1]);
		$id = 'inline-' . (self::$scriptIds++);
		if (Yii::$app->request->isAjax) {
			$this->registerJs($script, View::POS_END, $id);
		} else {
			$this->registerJs($script, View::POS_READY, $id);
		}
		return '';
	}
}