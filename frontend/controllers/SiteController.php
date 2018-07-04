<?php
namespace frontend\controllers;

use Facebook\Facebook;
use frontend\models\ContactForm;
use frontend\models\form\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Hybridauth\Hybridauth;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public $config = [
        // "base_url" => "http: //localhost/advanced/frontend/web/facebook",
        'callback' => 'https://frontend.dev.co/social',
        "providers" => [
            "Google" => [
                "enabled" => true,
                "keys" => ["id" => "378525595244-5vuajuqkbk8ovr2g6mlnq3nlq1ruc3dn.apps.googleusercontent.com", "secret" => "SmLABblYDxKYshatm4Qo4_qy"],
            ],
            "Facebook" => [
                "enabled" => true,
                "keys" => ["id" => "933705853503500", "secret" => "66f34ea795142a0f11f0d019d3ec444e"],
                'scope' => 'email',
                "trustForwarded" => false,
            ],
            "Twitter" => [
                "enabled" => true,
                "keys" => ["key" => "KlbUFJNlJYVqzzZi5hqiyyNSO", "secret" => "p5iOTfqEsDmwlO1TXVOpmF1yAVTACbEgYHg446ESVY11d26lD0"],
            ],
        ],
        "debug_mode" => true,
        "debug_file" => "/bug.txt",
    ];

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        // session_destroy();
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionFacebook()
    {

        $facebook = [
            'callback' => 'https://frontend.dev.co/facebook',
            "providers" => [
                "Facebook" => [
                    "enabled" => true,
                    "keys" => ["id" => "933705853503500", "secret" => "66f34ea795142a0f11f0d019d3ec444e"],
                    'scope' => 'email',
                    "trustForwarded" => false,
                ],
            ],
        ];
        
        try {
            
            $hybridauth = new Hybridauth($facebook);
            $adapter = $hybridauth->authenticate('Facebook');
            $isConnected = $adapter->isConnected();
            $userProfile = $adapter->getUserProfile();
            var_dump($userProfile);
            $adapter->disconnect();

        } catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }

    }

    public function actionTwitter()
    {

        $facebook = [
            'callback' => 'https://frontend.dev.co/twitter',
            "providers" => [
                "Twitter" => [
                    "enabled" => true,
                    "keys" => ["key" => "KlbUFJNlJYVqzzZi5hqiyyNSO", "secret" => "p5iOTfqEsDmwlO1TXVOpmF1yAVTACbEgYHg446ESVY11d26lD0"],
                ],
            ],
        ];
        
        try {
            
            $hybridauth = new Hybridauth($facebook);
            $adapter = $hybridauth->authenticate('Twitter');
            $isConnected = $adapter->isConnected();
            $userProfile = $adapter->getUserProfile();
            var_dump($userProfile);
            $adapter->disconnect();

        } catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }

    }

    public function actionGoogle()
    {

        $facebook = [
            'callback' => 'https://frontend.dev.co/google',
            "providers" => [
                "Google" => [
                    "enabled" => true,
                    "keys" => ["id" => "378525595244-5vuajuqkbk8ovr2g6mlnq3nlq1ruc3dn.apps.googleusercontent.com", "secret" => "SmLABblYDxKYshatm4Qo4_qy"],
                ],
            ],
        ];
        
        try {
            
            $hybridauth = new Hybridauth($facebook);
            $adapter = $hybridauth->authenticate('Google');
            $isConnected = $adapter->isConnected();
            $userProfile = $adapter->getUserProfile();
            var_dump($userProfile);
            $adapter->disconnect();

        } catch (\Exception $e) {
            echo 'Oops, we ran into an issue! ' . $e->getMessage();
        }

    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * {@inheritdoc}
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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    

    public function actionCallback()
    {
        return 'test';
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
