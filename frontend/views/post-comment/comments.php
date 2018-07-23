<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */
use frontend\widgets\PostComment;
/* @var $post common\models\Post */
/* @var $comment common\models\PostComment */

?>
<div id="comment-view">

    <?php if ($post->comment_count): ?>

        <?= PostComment::widget(['model' => $post, 'id' => 'comments']) ?>

    <?php endif ?>

    <?= $this->render('_form', ['model' => $comment, 'post' => $post]) ?>

</div>

<div class="comm-wrap-6535354" id="isp-2441517"><div class="comm-topbar"><span title="Prijavi komentar" class="report-comm tooltip" id="rep_6535354" data-commid="6535354" style="opacity: 0;"></span><span class="commTime" id="commtime_6535354" style="opacity: 0;">9h</span></div><div class="comm-text">Izbijaju kompleksi iz tvoje ispovesti. Nemoguce da se bas sva trojica duvaju. A i takve stvari su vise stvar iakustva nego stuke.</div><div class="comm-bottom"><div class="comm-autor">Anonimus</div><div class="comm-likes-6535354">458</div><div class="comm-disapp-6535354" data-id="6535354"></div><div class="comm-app-6535354" data-id="6535354"></div><div class="comm-reply-6535354">&nbsp;Odgovori <img src="/images/reply2.png">&nbsp;&nbsp;·</div><div class="comm-sub-6535354"><img src="/images/reply.png"> 4 &nbsp;·</div></div><div class="sub-comms"><div class="subc-wrap-6535744" id="isp-2441517"><div class="comm-topbar"><span title="Prijavi komentar" class="report-comm tooltip" id="rep_6535744" data-commid="6535744"></span><span class="commTime" id="commtime_6535744">7h</span></div><div class="comm-text">Momci verovatno nece da rade osim onoga sto im je u opisu posla. A i vecini starijih ljudi izuzetno smeta ako im dodje neko koje obrazovaniji pa je samim tim i sef. Verovatno ih zato pucaju kompleksi</div><div class="comm-bottom"><div class="comm-autor">Anonimus</div><div class="comm-likes-6535744">46</div><div class="comm-disapp-6535744" data-id="6535744"></div><div class="comm-app-6535744" data-id="6535744"></div><div class="comm-reply-6535354">&nbsp;Odgovori <img src="/images/reply2.png">&nbsp;&nbsp;·</div></div></div><div class="subc-wrap-6535936" id="isp-2441517"><div class="comm-topbar"><span title="Prijavi komentar" class="report-comm tooltip" id="rep_6535936" data-commid="6535936"></span><span class="commTime" id="commtime_6535936">6h</span></div><div class="comm-text">Uuu, ja sam onda iskusni elektroinzenjer... Inače sam arhitekta po profesiji, ali često menjam osigurače, ili podižem one ručice... Treba da ih je sramota.</div><div class="comm-bottom"><div class="comm-autor">Anonimus</div><div class="comm-likes-6535936">9</div><div class="comm-disapp-6535936" data-id="6535936"></div><div class="comm-app-6535936" data-id="6535936"></div><div class="comm-reply-6535354">&nbsp;Odgovori <img src="/images/reply2.png">&nbsp;&nbsp;·</div></div></div><div class="subc-wrap-6536644" id="isp-2441517"><div class="comm-topbar"><span title="Prijavi komentar" class="report-comm tooltip" id="rep_6536644" data-commid="6536644"></span><span class="commTime" id="commtime_6536644">3h</span></div><div class="comm-text">Koga briga sto ti letiš da menjaš osigurače? Hahaha, evo baš treba da ih bude sramota, ma kako mogu dopustiti da dve dame odu da pogledaju osigurače.</div><div class="comm-bottom"><div class="comm-autor">Anonimus</div><div class="comm-likes-6536644">0</div><div class="comm-disapp-6536644" data-id="6536644"></div><div class="comm-app-6536644" data-id="6536644"></div><div class="comm-reply-6535354">&nbsp;Odgovori <img src="/images/reply2.png">&nbsp;&nbsp;·</div></div></div><div class="subc-wrap-6537301" id="isp-2441517"><div class="comm-topbar"><span title="Prijavi komentar" class="report-comm tooltip" id="rep_6537301" data-commid="6537301"></span><span class="commTime" id="commtime_6537301">57m</span></div><div class="comm-text">Electrotehnika ili ti elektro inženjeri uglavnom nemaju veze sa elektrikom!  To je srednja škola i fakultet sa bezbroj smjerova koji većina nema veze sa strujom 😦😧 znači smjer računarstvo, telematika, elektronika i elektroenergetika...nisi faca ni malo 😬</div><div class="comm-bottom"><div class="comm-autor">😨😨😨</div><div class="comm-likes-6537301">2</div><div class="comm-disapp-6537301" data-id="6537301"></div><div class="comm-app-6537301" data-id="6537301"></div><div class="comm-reply-6535354">&nbsp;Odgovori <img src="/images/reply2.png">&nbsp;&nbsp;·</div></div></div></div></div>