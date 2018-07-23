<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'FAQ';
Yii::$app->params['bodyClass'] = 'confess-page';

?>
<div id="info-content">
    <h2 style="color=#eee">FAQ - Frequently asked questions</h2>
    <div class="post-wrap">
        <br>

        <h3>1. "Is my privacy secure? Can anyone identify me from my confession?" </h3>
        <p>You privacy is well secured on our site. The only data you are leaving on our site, beside your confession, is only your IP address which is used only to determine the countries our users come from. Apart from, no other information is stored, so there is nothing to worry about. </p>

        <h3>2. "Why was my confession/comment deleted?" </h3>
        <p>Our main goal is giving the most interesting experience for our site visitors. Sometimes, there are confessions/comments that do not help in improving that, but, quite the opposite, they reduce it with inappropriate text, comment or something else.  If your confession was deleted, and you consider it to be a mistake, please write to us and we will publish it.</p>

        <h3>3. "How can I find my confession?" </h3>
        <p>Like we already said, the main goal of our site is remaining anonymous, without allowing either us or someone else to track the “confessor”. The only way to try is either remembering the confession number or searching for it in section “New”.</p>

        <h3>4. "When is the IOS/Android app going to come out?" </h3>
        <p>We have received a huge amount of requests like these, and we are really committed to creating mobile app for our site.</p>

    </div>
</div>

<style>
    #info-content {
        width: 700px;
        margin: 0 auto;
        padding: 30px 25px 80px 25px;
        color: white;
        background: none;
    }
    .post-wrap {
        padding: 20px;
        margin: 20px;
        background: rgba(50,50,50,0.8);
    }
</style>