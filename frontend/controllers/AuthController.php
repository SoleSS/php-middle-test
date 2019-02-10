<?php

namespace frontend\controllers;

/**
 * Controller that manages user authentication process.
 *
 * @property Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class AuthController extends \dektrium\user\controllers\SecurityController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['gen-jwt-token', 'login', 'auth', 'password-reset-request', 'register', ], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['gen-jwt-token', 'login', 'auth', 'logout'], 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'logout' => ['post'],
                    'password-reset-request' => ['post'],
                    'gen-jwt-token' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if ($action->id == 'gen-jwt-token') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionGenJwtToken() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = \Yii::$app->getRequest()->post();

        if (!isset($data['login']) || !isset($data['password']))
            throw new \yii\web\BadRequestHttpException();

        $finder = \Yii::createObject(\dektrium\user\Finder::className());
        $loginForm = new \dektrium\user\models\LoginForm($finder, ['login' => $data['login'], 'password' => $data['password']]);
        if ($loginForm->login()) {
            $identity = \Yii::$app->user->identity;
            $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
            $token = \Yii::$app->jwt->getBuilder()
                ->setIssuer(\Yii::$app->params['jwtIssuer']) // Configures the issuer (iss claim)
                ->setAudience(\Yii::$app->params['jwtAudience']) // Configures the audience (aud claim)
                ->setId(\Yii::$app->params['jwtId'], true) // Configures the id (jti claim), replicating as a header item
                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                ->setNotBefore(time() + 0) // Configures the time before which the token cannot be accepted (nbf claim)
                ->setExpiration(time() + 10800) // Configures the expiration time of the token (exp claim)
                ->set('uid', $identity->id) // Configures a new claim, called "uid"
                ->set('uname', $identity->username)
                ->sign($signer, \Yii::$app->jwt->key)
                ->getToken(); // Retrieves the generated token

            return [
                'jti' => $token->getHeader('jti'), // will print "4f1g23a12aa"
                'iss' => $token->getClaim('iss'), // will print "http://example.com"
                'uid' => $token->getClaim('uid'), // will print "1"
                'token' => $token->__toString(), // The string representation of the object is a JWT string (pretty easy, right?)
            ];
        }

        throw new \yii\web\UnauthorizedHttpException();
    }
}