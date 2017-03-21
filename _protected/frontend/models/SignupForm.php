<?php
namespace frontend\models;

use common\models\Students;
use common\rbac\helpers\RbacHelper;
use nenad\passwordStrength\StrengthValidator;
use yii\base\Model;
use Yii;

/**
 * Model representing  Signup Form.
 */
class SignupForm extends Model
{
	public $name;
	public $mobile;
	public $username;
    public $email;
    public $password;
    public $status;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['username','name','mobile'], 'filter', 'filter' => 'trim'],
            [['username','name','mobile'], 'required'],
        	['name', 'string', 'min' => 2, 'max' => 50],
        	['mobile', 'string', 'min' => 10, 'max' => 10],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique', 'targetClass' => '\common\models\Students', 
                'message' => 'This username has already been taken.'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Students', 
                'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            // use passwordStrengthRule() method to determine password strength
            $this->passwordStrengthRule(),

            // on default scenario, user status is set to active
            ['status', 'default', 'value' => Students::STATUS_ACTIVE, 'on' => 'default'],
            // status is set to not active on rna (registration needs activation) scenario
            ['status', 'default', 'value' => Students::STATUS_NOT_ACTIVE, 'on' => 'rna'],
            // status has to be integer value in the given range. Check User model.
            ['status', 'in', 'range' => [Students::STATUS_NOT_ACTIVE, Students::STATUS_ACTIVE]]
        ];
    }

    /**
     * Set password rule based on our setting value (Force Strong Password).
     *
     * @return array Password strength rule
     */
    private function passwordStrengthRule()
    {
        // get setting value for 'Force Strong Password'
        $fsp = Yii::$app->params['fsp'];

        // password strength rule is determined by StrengthValidator 
        // presets are located in: vendor/nenad/yii2-password-strength/presets.php
        $strong = [['password'], StrengthValidator::className(), 'preset'=>'normal'];

        // use normal yii rule
        $normal = ['password', 'string', 'min' => 6];

        // if 'Force Strong Password' is set to 'true' use $strong rule, else use $normal rule
        return ($fsp) ? $strong : $normal;
    }    

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
        	'name'=>Yii::t('app', 'Name'),
        	'mobile'=>Yii::t('app', 'Mobile'),
        ];
    }

    /**
     * Signs up the user.
     * If scenario is set to "rna" (registration needs activation), this means
     * that user need to activate his account using email confirmation method.
     *
     * @return User|null The saved model or null if saving fails.
     */
    public function signup()
    {
        $user = new Students();

        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->mobile = $this->mobile;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = $this->status;

        // if scenario is "rna" we will generate account activation token
        if ($this->scenario === 'rna')
        {
            $user->generateAccountActivationToken();
        }

        // if user is saved and role is assigned return user object
        return $user->save() ? $user : null;
    }

    /**
     * Sends email to registered user with account activation link.
     *
     * @param  object $user Registered user.
     * @return bool         Whether the message has been sent successfully.
     */
    public function sendAccountActivationEmail($user)
    {
        return Yii::$app->mailer->compose('accountActivationToken', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account activation for ' . Yii::$app->name)
            ->send();
    }
}
