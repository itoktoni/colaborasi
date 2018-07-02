<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\form\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use common\models\base\Member;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        $appId = '933705853503500'; //Facebook App ID
        $appSecret = '66f34ea795142a0f11f0d019d3ec444e'; //Facebook App Secret
        $redirectURL = 'http://localhost:8080/facebook/index.php'; //Callback URL
        $fbPermissions = array('email');  //Optional permissions
        
        $fb = new Facebook(array(
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.10',
                ));
        
        $helper = $fb->getRedirectLoginHelper();
        
        $permissions = []; // Optional information that your app can access, such as 'email'

        return $this->render('signup', [
            'model' => $model,
            'facebook_url' => $helper->getLoginUrl('http://localhost:8080/facebook', $permissions), 
        ]);
    }

     public function actionFacebook($code)
    {
        $appId = '933705853503500'; //Facebook App ID
        $appSecret = '66f34ea795142a0f11f0d019d3ec444e'; //Facebook App Secret
        $redirectURL = 'http://localhost:8080/facebook/index.php'; //Callback URL
        $fbPermissions = array('email');  //Optional permissions
        
        $fb = new Facebook(array(
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.10',
                ));
        
        $helper = $fb->getRedirectLoginHelper();
        // Get redirect login helper
        $helper = $fb->getRedirectLoginHelper();
        
        // Try to get access token
        try {
            // Already login
            if (isset($_SESSION['facebook_access_token'])) {
                $accessToken = $_SESSION['facebook_access_token'];
            } else {
                $accessToken = $helper->getAccessToken();
            }
        
            if (isset($accessToken)) {
                if (isset($_SESSION['facebook_access_token'])) {
                    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
                } else {
                    // Put short-lived access token in session
                    $_SESSION['facebook_access_token'] = (string) $accessToken;
                    //10216583809495501
                    // OAuth 2.0 client handler helps to manage access tokens
                    $oAuth2Client = $fb->getOAuth2Client();
        
                    // Exchanges a short-lived access token for a long-lived one
                    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                    $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
                    // Set default access token to be used in script
                    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
                }
        
                // Redirect the user back to the same page if url has "code" parameter in query string
                if (isset($_GET['code'])) {
                    
                    // Getting user facebook profile info
                    try {
                        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
                        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
                        // Here you can redirect to your Home Page.

                        $getUser = Member::find()->where(['email' => $fbUserProfile['email']])->one();
                        if(count($getUser) > 0){
                            
                             echo "<pre/>";
                            print_r($fbUserProfile);
                            // Yii::$app->response()->redirect
                        }
                        else
                        {
                            $user = new Member();
                            $user->email = $fbUserProfile['email'];
                            $user->name = $fbUserProfile['first_name'].' '.$fbUserProfile['last_name'];
                            $user->password = md5($fbUserProfile['password']);
                            $user->save();
                             return $this->redirect(['/']);
                           
                        }
                        
                        
                    } catch (FacebookResponseException $e) {
                        echo 'Graph returned an error: ' . $e->getMessage();
                        session_destroy();
                        // Redirect user back to app login page
                        header("Location: ./");
                        exit;
                    } catch (FacebookSDKException $e) {
                        echo 'Facebook SDK returned an error: ' . $e->getMessage();
                        exit;
                    }
                }
            } else {
                // Get login url
        
                $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
                header("Location: " . $loginURL);
                
            }
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
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
