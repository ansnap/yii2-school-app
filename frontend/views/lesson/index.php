<?php
/** @var array $lessons */
/** @var array $lessons_viewed */

use yii\helpers\Url;

?>
<h2>Список уроков</h2>

<?php if ($lessons_viewed && count($lessons) == count($lessons_viewed)) : ?>
    <div class="alert alert-success" role="alert">
        Поздравляем. Вы успешно прошли курс!
    </div>
<?php endif; ?>

<table class="table table-hover lesson-list">
    <thead>
    <tr>
        <th scope="col">Название</th>
        <th scope="col">Пройден</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($lessons as $lesson) : ?>
        <tr>
            <td onclick="window.location='<?= Url::toRoute(['lesson/view', 'id' => $lesson->id]) ?>'">
                <?= $lesson->title ?>
            </td>
            <td>
                <?php if ($lessons_viewed && in_array($lesson->id, $lessons_viewed)) : ?>
                    <img class="green-tick" src="<?= Yii::$app->request->getBaseUrl(true); ?>/img/green-tick.svg">
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>