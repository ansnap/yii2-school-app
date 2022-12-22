<?php

namespace frontend\controllers;

use common\models\Lesson;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class LessonController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $lessons = Lesson::find()->all();

        return $this->render('index', [
            'lessons' => $lessons,
            'lessons_viewed' => \Yii::$app->user->identity->lessons_viewed,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionMarkAsPassed($id)
    {
        $model = $this->findModel($id);

        $user = \Yii::$app->user->identity;
        $user->lessons_viewed = array_unique(array_merge($user->lessons_viewed ?? [], [$model->id]));
        $user->save();

        if (($next_model = Lesson::find()->where(['>', 'id', $id])->one()) !== null) {
            return $this->render('view', [
                'model' => $next_model,
            ]);
        }

        return false;
    }

    protected function findModel($id)
    {
        if (($model = Lesson::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
