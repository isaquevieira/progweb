<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Curso;
use yii\log\Logger;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $id_curso;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['id_curso', 'required'],
            [['id_curso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['id_curso' => 'id']]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $curso = Curso::findOne($this->id_curso);
        log($curso->id);
        $user->username = $this->username;
        $user->email = $this->email;
        $user->id_curso = $curso->id;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save(false) ? $user : null;
    }
}
