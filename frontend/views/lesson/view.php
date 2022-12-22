<?php
/** @var common\models\Lesson $model */

use yii\helpers\Url;

?>
<article id="lesson" data-pass-url="<?= Url::toRoute(['lesson/mark-as-passed', 'id' => $model->id]) ?>">
    <h2>Урок: <?= $model->title ?></h2>

    <p><?= $model->description ?></p>

    <?= $model->video ?>
</article>

<p>
    <button id="lesson-finished" type="button" class="btn btn-primary">Урок просмотрен</button>
</p>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('lesson-finished').addEventListener('click', function () {
            fetch(document.getElementById('lesson').dataset.passUrl)
                .then(response => response.text())
                .then(response => {
                    if(response) {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(response, 'text/html');
                        let html = doc.getElementById('lesson');
                        document.getElementById('lesson').replaceWith(html);
                    } else {
                        window.location.href = '<?= Url::toRoute(['lesson/index']) ?>';
                    }
                });
        });
    });
</script>