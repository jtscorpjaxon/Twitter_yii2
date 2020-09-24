<?php
namespace frontend\controllers;

use app\models\Likes;
use app\models\Posts;
use app\models\Subcsribe;
use common\models\PasswordChangeForm;
use common\models\User;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;

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
    public function actionFeed()
    {
        if (Yii::$app->user->isGuest) {
        return $this->redirect('/site/login');
    }
        $feeds=Subcsribe::findOne(['user_id'=>Yii::$app->user->id]);
        if(!empty($feeds)){
            $feeds=json_decode($feeds->subscribe,true);
            $feeds=Posts::find()->where(['user_id'=>$feeds])->all();
        }
        $list=$feeds;
        if (empty($feeds))$list=[];
        return $this->render('/site/post',compact('list'));
    }
    public function actionPosts()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }
        $list=Posts::find()->all();
        return  $this->render('post',compact('list'));
    }
    public function actionSearch()
    {
        $q=trim(Yii::$app->request->get('q'));
        if(!$q)
            return  $this->render('search');
        $user=User::find()->where(['like','username',$q])->one();

        if (empty($user))
            return  $this->render('search');
        $list=Posts::findAll(['user_id'=>$user->id]);
        return  $this->render('search',compact('user','list'));
    }
    public function actionSubscribe()
    {
        if(isset($_POST['is'])){
$id=intval($_POST['id']);
            $subscribe=Subcsribe::findOne(['user_id'=>Yii::$app->user->id]);

            if($_POST['is']==='true')
            {

                if(empty($subscribe)){
                   $subscribe=new Subcsribe();
                   $subscribe->user_id=Yii::$app->user->id;
                   $subscribe->subscribe=json_encode([$id]);

                }
                else{

                    $arr=json_decode($subscribe->subscribe,true);
                    if (!in_array($id,$arr))
                    $arr []=$id;
                    $subscribe->subscribe=json_encode($arr);

                }


                $subscribe->save();
return true;
            }else{
                if(empty($subscribe)){
                    $subscribe=new Subcsribe();
                    $subscribe->user_id=Yii::$app->user->id;
                    $subscribe->subscribe='[]';

                }
                else{
                    $arr=json_decode($subscribe->subscribe,true);

                    if(in_array($id,$arr))
                    array_splice($arr,array_search($id,$arr),1);

                    $subscribe->subscribe=json_encode($arr);

                }

                $subscribe->save();

            }
            return false;
        }
        return false;
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
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }



    public function actionProfile()
    {
        if(Yii::$app->user->isGuest) return $this->redirect('/site/login');
        $user = $this->findModel();
        $model = new PasswordChangeForm($user);


        if ($model->load(Yii::$app->request->post())&& $model->changePassword()) {
            return $this->redirect(['index']);
        }

        return $this->render('profile', [
            'model' => $model,

        ]);
    }
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }


    public function actionLikes(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(isset($_POST['is_like'])){

            $likes=Likes::findOne(['user_id'=>Yii::$app->user->id,'post_id'=>$_POST['id']]);

            if(intval($_POST['is_like'])===1)
            {

              if(empty($likes)){
                  $likes=new  Likes();
                  $likes->user_id=Yii::$app->user->id;
                  $likes->post_id=intval($_POST['id']);

              }
              $likes->is_like= 1;
                $likes->is_dislike= 0;

              $likes->save();

            }else{
                if(empty($likes)){
                    $likes=new  Likes();
                    $likes->user_id=Yii::$app->user->id;
                    $likes->post_id=$_POST['id'];
                }
                $likes->is_dislike= 1;
                $likes->is_like= 0;
                $likes->save();

            }
        }
        $a=Likes::find()->where(['post_id'=>intval($_POST['id']),'is_like'=>true])->count();
        $b=Likes::find()->where(['post_id'=>intval($_POST['id']),'is_dislike'=>true])->count();
        return ['like'=>$a,'dislike'=>$b];
    }

}
