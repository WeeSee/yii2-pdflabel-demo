<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use weesee\pdflabel\PdfLabel;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    
    public function actionPdfLabelDownload($label)
    {
        // Make some test data ...
        $addresses = [
            ['Cecilia Chapman','711-2880 Nulla St.',"Mankato Mississippi 96522"],
            ['Iris Watson','P.O. Box 283 8562 Fusce Rd.','Frederick Nebraska 20620'],
            ['Celeste Slater','606-3727 Ullamcorper. Street','Roseville NH 11523'],
            ['Theodore Lowe','Ap #867-859 Sit Rd.','Azusa New York 39531']
        ];
        // ... as DataProvider
        $AddressData = [];
        foreach($addresses as $key => $v)
            $AddressData[] = ['id'=>$key,'name'=>$v[0],'street'=>$v[1],'town'=>$v[2]];
        $labelDataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $AddressData,
            'pagination' => false,
        ]);
        // generate labels
        $pdfLabel = new PdfLabel([
            'labelName' => $label,
            'dataProvider' => $labelDataProvider,
            'renderLabel' => function($model, $key, $index) {
                return $model["name"]."\n".$model["town"];
            },
            'offsetEmptyLabels' => 4,
            'author' => 'WeeSee',
            'subject' => 'Label  test',
            'title' => 'Little useful labels',
            'asHtml' => true,
            'border' => false,
        ]);
        $pdfLabel->addLabel("hello<hr>world");
        return $pdfLabel->render();
    }
}
