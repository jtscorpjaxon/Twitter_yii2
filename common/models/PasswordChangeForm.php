<?php
namespace common\models;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class PasswordChangeForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;
    public $last_name;
    public $first_name;
    public $birthday;
    public $google_client_id;

    /**
     * @var User
     */
    private $_user;

    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        $this->first_name=$user->first_name;
$this->last_name =$user->last_name ;
 $this->birthday =$user->birthday ;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            ['currentPassword', 'currentPassword'],
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
            [['first_name','last_name'], 'string'],
            [['birthday'], 'date','format'=>'dd/MM/yyyy'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите новый пароль',
            'currentPassword' => 'Текущий пароль',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'birthday' => 'День рождения',
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function currentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, Yii::t('app', 'ERROR_WRONG_CURRENT_PASSWORD'));
            }
        }
    }

    /**
     * @return boolean
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->setPassword($this->newPassword);
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->birthday =  $this->birthday;
            return $user->save();
        } else {
            return false;
        }
    }
}