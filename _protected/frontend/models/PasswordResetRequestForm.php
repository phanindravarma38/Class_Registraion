<?php
namespace frontend\models;

use common\models\Students;
use yii\base\Model;
use Yii;

/**
 * Password reset request form.
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\Students',
                'filter' => ['status' => Students::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool Whether the email was send.
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = Students::findOne([
            'status' => Students::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) 
        {
            $user->generatePasswordResetToken();

            if ($user->save()) 
            {
                return Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }
}