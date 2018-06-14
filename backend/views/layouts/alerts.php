<?php
/**
 * Created by PhpStorm.
 * User: Zivorad Antonijevic
 * Date: 8.12.14.
 * Time: 10.27
 */

$flashes = Yii::$app->session->getAllFlashes();

if (!($flashes)) {
    return;
}

$alertIcons = [
    'success' => 'check',
    'danger'  => 'ban',
    'info'    => 'info',
    'warning' => 'warning',
    'error'   => 'ban'
];
$alertClasses = [
    'success' => 'success',
    'danger'  => 'danger',
    'info'    => 'info',
    'warning' => 'warning',
    'error'   => 'danger'
];
?>
<div class="flashes">
    <?php foreach ($flashes as $key => $message) :
        $icon = '';
        $class = '';
        foreach ($alertIcons as $key1 => $value) {
            if (strpos($key, $key1) !== false) {
                $icon = $value;
                break;
            }
        }
        if (!$icon) {
            $icon = 'info';
        }
        foreach ($alertClasses as $key1 => $value) {
            if (strpos($key, $key1) !== false) {
                $class = $value;
                break;
            }
        }
        if (!$class) {
            $class = 'info';
        }
        ?>
        <div class="alert alert-<?= $class ?>">
            <i class="fa fa-<?= $icon ?>"></i> <?= is_array($message) ? implode("<br/>",$message) : $message ?>
        </div>
    <?php endforeach; ?>
</div>