<?php

$this->beginContent('@app/views/layouts/main.php'); ?>
    <section class="mainContent full-width clearfix article">
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
    </section>
<?php $this->endContent();