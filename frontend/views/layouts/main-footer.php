<?php
/**
 * @link      http://www.beamusup.com/
 * @author    Zivorad Antonijevic <zivorad.antonijevic@gmail.com>
 * @copyright Copyright (c) 2018 BeamUsUp
 * @license   http://www.beamusup.com/license/
 */


/* @var $this yii\web\View */
?>
<footer style="position:relative">
    <div id="footer-wrap">
        <div class="foot-sub-div">
            <ul>

                <li><a href="#conf-of-day" onclick="$( '#conf-of-day' ).trigger( 'click' );"><div class="foot-icon" id="foot-star-icon"></div>Ispovest dana</a></li>
                <li><a href="#conf-of-week" onclick="$( '#conf-of-week' ).trigger( 'click' );"><div class="foot-icon" id="foot-medal-icon"></div>Ispovest nedelje</a></li>
                <li><a href="#conf-of-month" onclick="$( '#conf-of-month' ).trigger( 'click' );"><div class="foot-icon" id="foot-crown-icon"></div>Ispovest meseca</a></li>

            </ul>
        </div>
        <div class="foot-sub-div">
            <ul>
                <li><a href="/sort/sud">Novo</a></li>
                <li><a href="/sort/popularno">Popularno</a></li>
                <li><a href="/sort/top">Najbolje</a></li>

                <li>
                    <a class="soc-foot-link" href="http://facebook.com/ispovest" id="soc-foot-link-fb"></a>
                    <a class="soc-foot-link" href="http://twitter.com/ispovesti" id="soc-foot-link-tw"></a>
                    <a class="soc-foot-link" href="https://plus.google.com/u/0/102258784641513431046/posts" id="soc-foot-link-gp"></a>
                    <a class="soc-foot-link" href="http://instagram.com/ispovesti" id="soc-foot-link-in"></a>
                </li>
            </ul>
        </div>
        <div class="foot-sub-div-logo">
            <ul id="foot-logo">
                <li><div id="foot-img"></div></li>
                <li id="caption">Ispovesti.com<br>Anonimne lične ispovesti</li>
            </ul>
        </div>

    </div>
    <div id="foot-bottom-div">
        <div id="copyright">&nbsp;&nbsp;&nbsp; COPYRIGHT © 2017 - SVA PRAVA ZADRŽANA &nbsp; · &nbsp;  <a href="/terms-of-use">Uslovi korišćenja</a> &nbsp; · &nbsp; <a href="/faq">FAQ</a>  &nbsp; · &nbsp; <a href="/contact">Kontakt</a> &nbsp; · &nbsp; <a href="/about">O nama</a>  &nbsp; · &nbsp; <a href="/marketing">Marketing</a>   </div>
    </div>
</footer>
<style rel="inline-ready">
    footer {
        width: 100%;
        bottom: 0;
        height: 250px;
        position: relative;
        background: rgb(20, 20, 20);
    }
</style>