<?php
namespace frontend\controllers;

use common\models\Students;
use common\models\StudentLoginForm;
use frontend\models\AccountActivation;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\CoursesModel;
use backend\models\CoursesSearchModel;
use backend\models\CourseUser;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use common\models\Utils;
use Yii;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, password reset.
 */
class SiteController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','enrollcourse','profile','delistcourse'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','enrollcourse','profile','delistcourse'],
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
     * Declares external actions for the controller.
     *
     * @return array
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

//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {
    	$searchModel = new CoursesSearchModel();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	//$dataProvider->query->where('courses.status=1');
    	return $this->render('index', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    
	public function actionCourses(){
		return $this->redirect('index');
	}
	
    /** 
     * Displays the logged in user profile
     * */
    public function actionProfile(){
    	if (Yii::$app->user->isGuest)
    	{
    		return $this->redirect('/site/login');
    	}
    	return $this->render('profile',['model'=>Yii::$app->user->identity]);
    }

    /**
     * Displays the about static page.
     *
     * @return string
     */
    /*public function actionAbout()
    {
        return $this->render('about');
    }*/

    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->contact(Yii::$app->params['adminEmail'])) 
            {
                Yii::$app->session->setFlash('success', 
                    'Thank you for contacting us. We will respond to you as soon as possible.');
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } 
        
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new StudentLoginForm(['scenario' => 'lwe']) : new StudentLoginForm();
		// now we can try to log in the user
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            //return $this->goBack();
            return $this->goHome();
        }
        // user couldn't be logged in, because he has not activated his account
        elseif($model->notActivated())
        {
            // if his account is not activated, he will have to activate it first
            Yii::$app->session->setFlash('error', 
                'You have to activate your account first. Please check your email.');

            return $this->refresh();
        }    
        // account is activated, but some other errors have happened
        else
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->sendEmail()) 
            {
                Yii::$app->session->setFlash('success', 
                    'Check your email for further instructions.');

                return $this->goHome();
            } 
            else 
            {
                Yii::$app->session->setFlash('error', 
                    'Sorry, we are unable to reset password for email provided.');
            }
        }
        else
        {
            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try 
        {
            $model = new ResetPasswordForm($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) 
            && $model->validate() && $model->resetPassword()) 
        {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }
        else
        {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }       
    }    

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email
     * ( with link containing account activation token ). If activation is not
     * necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary,
     * @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {  
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();

        // collect and validate user data
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            // try to save user data in database
            if ($user = $model->signup()) 
            {
                // if user is active he will be logged in automatically ( this will be first user )
                if ($user->status === Students::STATUS_ACTIVE)
                {
                    if (Yii::$app->getUser()->login($user)) 
                    {
                        return $this->goHome();
                    }
                }
                // activation is needed, use signupWithActivation()
                else 
                {
                    $this->signupWithActivation($model, $user);

                    return $this->refresh();
                }            
            }
            // user could not be saved in database
            else
            {
                // display error message to user
                Yii::$app->session->setFlash('error', 
                    "We couldn't sign you up, please contact us.");

                // log this error, so we can debug possible problem easier.
                Yii::error('Signup failed! 
                    User '.Html::encode($user->username).' could not sign up.
                    Possible causes: something strange happened while saving user in database.');

                return $this->refresh();
            }
        }
                
        return $this->render('signup', [
            'model' => $model,
        ]);     
    }

    /**
     * Sign up user with activation.
     * User will have to activate his account using activation link that we will
     * send him via email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // try to send account activation email
        if ($model->sendAccountActivationEmail($user)) 
        {
            Yii::$app->session->setFlash('success', 
                'Hello '.Html::encode($user->username).'. 
                To be able to log in, you need to confirm your registration. 
                Please check your email, we have sent you a message.');
        }
        // email could not be sent
        else 
        {
            // display error message to user
            Yii::$app->session->setFlash('error', 
                "We couldn't send you account activation email, please contact us.");

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! 
                User '.Html::encode($user->username).' could not sign up.
                Possible causes: verification email could not be sent.');
        }
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try 
        {
            $user = new AccountActivation($token);
        } 
        catch (InvalidParamException $e) 
        {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($user->activateAccount()) 
        {
            Yii::$app->session->setFlash('success', 
                'Success! You can now log in. 
                Thank you '.Html::encode($user->username).' for joining us!');
        }
        else
        {
            Yii::$app->session->setFlash('error', 
                ''.Html::encode($user->username).' your account could not be activated, 
                please contact us!');
        }

        return $this->redirect('login');
    }
    
    public function actionView($id)
    {
    	return $this->render('view', [
    			'model' => $this->findModel($id),
    	]);
    }
    
    protected function findModel($id)
    {
    	if (($model = CoursesModel::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    
    public function actionEnrollcourse(){
    	$userCourseModel = new CourseUser();
    	$courses = Utils::getCoursesList();
    	$userName = Utils::getStudentName(Yii::$app->user->id);
    	try{
    		if(isset($_GET['courseId']) && ($_GET['courseId']!="")){
    			$action = (isset($_GET['action']) && ($_GET['action']!="")) ? $_GET['action'] : "index";
    			$userCourseModel->course_id = $_GET['courseId'];
    			$userCourseModel->user_id = Yii::$app->user->id;
    			$userCourseModel->created_date = Utils::getCurrentDateTime();
    			if(\Yii::$app->request->post()){
    				if($userCourseModel->validate()){
    					if($userCourseModel->save()){
    						\Yii::$app->session->setFlash('success', "Successfully Enrolled.");
    						if($action=='view'){
    							return $this->redirect(['view','id'=>$_GET['courseId']]);
    						} else {
    							return $this->redirect(['index']);
    						}
    					} else {
    						throw new NotFoundHttpException("Something Went Wrong! Please try again");
    					}
    				} else {
    					throw new NotFoundHttpException("Something Went Wrong! Please try again");
    				}
    			} elseif (\Yii::$app->request->isAjax){
    				return $this->renderAjax('_enrollForm', ['enrollForm' => $userCourseModel,'courses'=>$courses,'userName'=>$userName]);
    			}
    		} else {
    			throw new \InvalidArgumentException("Undefined Course Id/User Id");
    		}
    	} catch (\Exception $ex){
    		throw new NotFoundHttpException("Something Went Wrong! Please try again");
    	}
    }
    
    public function actionDelistcourse(){
    	$userCourseModel = new CourseUser();
    	$courses = Utils::getCoursesList();
    	$userName = Utils::getStudentName(Yii::$app->user->id);
    	try{
    		if(isset($_GET['courseId']) && ($_GET['courseId']!="")){
    			$action = (isset($_GET['action']) && ($_GET['action']!="")) ? $_GET['action'] : "index";
    			$userCourseModel->course_id = $_GET['courseId'];
    			$userCourseModel->user_id = Yii::$app->user->id;
    			$userCourseModel->created_date = Utils::getCurrentDateTime();
    			if(\Yii::$app->request->post()){
    				if($userCourseModel->validate()){
    					$userCourse = $userCourseModel->findOne(['course_id'=>$userCourseModel->course_id,'user_id'=>$userCourseModel->user_id]);
    					if($userCourse->delete()){
    						\Yii::$app->session->setFlash('success', "Successfully Delisted.");
    						if($action=='view'){
    							return $this->redirect(['view','id'=>$_GET['courseId']]);
    						} else {
    							return $this->redirect(['index']);
    						}
    					} else {
    						throw new NotFoundHttpException("Something Went Wrong! Please try again");
    					}
    				} else {
    					throw new NotFoundHttpException("Something Went Wrong! Please try again");
    				}
    			} elseif (\Yii::$app->request->isAjax){
    				return $this->renderAjax('_enrollForm', ['enrollForm' => $userCourseModel,'courses'=>$courses,'userName'=>$userName]);
    			}
    		} else {
    			throw new \InvalidArgumentException("Undefined Course Id/User Id");
    		}
    	} catch (\Exception $ex){
    		throw new NotFoundHttpException("Something Went Wrong! Please try again");
    	}
    }
}
