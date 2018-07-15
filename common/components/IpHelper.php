<?php
/**
 * Created by PhpStorm.
 * User: strahinja
 * Date: 7/10/18
 * Time: 9:14 PM
 */

namespace common\components;


use common\models\Post;
use common\models\UserIp;

class IpHelper
{
    /**
     * Static function that checks if ip address is blacklisted.
     *
     * @param $ipAddress
     *
     * @return bool Returns true if ip is blacklisted, and false if it is not blacklisted.
     */
    public static function checkBlacklist($ipAddress)
    {
        $result = UserIp::find()->where(['ip' => $ipAddress])->andWhere(['is_banned' => 1])->one();
        if ($result) {
            return true;
        }
        return false;
    }

    /**
     * Static function that checks if ip address already posted three confesses that day.
     *
     * @param $ipAddress
     *
     * @return bool
     */
    public static function checkConfessesForDay($ipAddress)
    {
        $currentDate = date('Y-m-d');

        $result = Post::find()->where(['author_ip' => $ipAddress])->andWhere(['date' => $currentDate])->count();
        if ($result >= 3) {
            return true;
        }
        return false;

    }
}