<?php
/**
 * Created by PhpStorm.
 * User: strahinja
 * Date: 21.6.17.
 * Time: 15.34
 */

$this->beginContent( '@app/views/layouts/main.php' ); ?>
    <section class="mainContent full-width clearfix article">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <?= $content; ?>
                </div>
                <div class="col-sm-3">

                    <aside>
                        <div class="rightSidebar">
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
<?php $this->endContent();