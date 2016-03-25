<?php

namespace app\controllers;

use app\models\Link;
use app\models\LinkForm;
use app\models\VisitorFactory;
use GuzzleHttp\Client;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param null|string $shortLink
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($shortLink = null)
    {
        if ($shortLink !== null) {
            /* @var $link Link */
            $link = Link::findOne(['short_link' => $shortLink]);
            if ($link !== null) {
                $visitor = (new VisitorFactory())->createVisitor(
                    Yii::$app->request->getUserIP(),
                    new Browser(Yii::$app->request->getUserAgent()),
                    new Os(Yii::$app->request->getUserAgent()),
                    new Client(),
                    $link
                );
                if ($visitor->save()) {
                    $this->redirect($link->link);
                } else {
                    Yii::$app->session->setFlash('error', 'Произошла ошибка. Попробуйте позже');
                    Yii::error('Ошибка создания посетителя');
                }
            } else {
                throw new NotFoundHttpException('Страница не найдена');
            }
        }

        $linkForm = new LinkForm();
        if ($linkForm->load(Yii::$app->request->post())) {
            $linkForm->setLinks();
        }

        return $this->render('index', [
            'model' => $linkForm,
        ]);
    }

    /**
     * @param string $statLink
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionStat($statLink)
    {
        /* @var $link Link */
        $link = Link::findOne(['stat_link' => $statLink]);
        if ($link !== null) {
            $dataProvider = new ActiveDataProvider([
                'query' => $link->getVisitors()
            ]);
        } else {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('stat', [
            'model' => $link,
            'dataProvider' => $dataProvider
        ]);
    }

}
