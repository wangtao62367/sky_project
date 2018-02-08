<?php
namespace frontend\models;


use Yii;
use yii\base\Model;
use common\models\User;

class EditPwdForm extends Model
{
    public $oldPwd;
    
    public $newPwd;
    
    public $repass;
    
    private $_user;
    
    public function rules()
    {
        return [
            ['oldPwd','required','message'=>'原密码不能为空'],
            ['oldPwd','validOldPwd'],
            ['newPwd','required','message'=>'新密码不能为空'],
            ['repass','required','message'=>'重复密码不能为空'],
            ['repass','compare','compareAttribute'=>'newPwd','message'=>'两次输入密码不一致'],
        ];
    }
    
    public function validOldPwd()
    {
        if(!$this->hasErrors()){
            $this->_user =  User::findOne(Yii::$app->user->id);
            if(!Yii::$app->getSecurity()->validatePassword($this->oldPwd, $this->_user->userPwd)){
                $this->addError('error','原密码不正确，请重新输入');
            }
        }
    }
    
    public function editPwd(array $data)
    {
        if($this->load($data) && $this->validate()){
            $this->_user->userPwd = Yii::$app->getSecurity()->generatePasswordHash($this->newPwd);
            return $this->_user->save(false) && Yii::$app->user->logout(false);
        }
        return false;
    }
}