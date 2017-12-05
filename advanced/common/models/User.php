<?php
namespace common\models;


use Yii;
use yii\web\IdentityInterface;

class User extends BaseModel implements IdentityInterface
{
    
    public $repass;
    
    public static function tableName()
    {
        return '{{%User}}';
    }
    
    public function rules()
    {
        return [
            ['account','required','message'=>'账号不能为空','on'=>['reg']],
            ['userPwd','required','message'=>'密码不能为空','on'=>['reg']],
            ['repass','required','message'=>'重复密码不能为空','on'=>['reg']],
            ['repass','compare','compareAttribute'=>'userpwd','message'=>'两次输入密码不一致','on'=>['reg']],
            ['email','required','message'=>'邮箱不能为空','on'=>['reg']],
            ['email','email','message'=>'邮箱格式不正确','on'=>['reg']],
            ['roleId','validRoleId','on'=>['reg']],
            [['phone','search'],'safe']
        ];
    }
    
    public function validRoleId()
    {
        if(!$this->hasErrors()){
            $roles = Role::getRoles();
            if(!in_array($this->roleId, array_column($roles, 'id'))){
                $this->addError('role','请选择角色');
            }
        }    
    }
    
    public function getRoles()
    {
        return $this->hasOne(Role::className(), ['id'=>'roleId']);
    }
    
    
    public function reg(array $data,string $scenario = 'reg')
    {
        $this->scenario = $scenario;
        if($this->load($data) && $this->validate()){
            $this->userPwd= Yii::$app->getSecurity()->generatePasswordHash($this->userPwd);
            return $this->save(false);
        }
        return false;
    }
    
    
    public function users(array $data,array $search)
    {
        $query = self::find()
            ->select([
                self::tableName().'.id',
                'account',
                'email',
                'phone',
                'roleId',
                'createTime',
                'modifyTime',
                'isDelete',
                'isFrozen',
                'loginCount',
                'loginIp',
                'lastLoginIp',
                'roleName',
                Role::tableName().'.id'
            ])
            ->joinWith('roles')
            ->orderBy('createTime desc,modifyTime desc')
            ->where(['isDelete'=>0]);
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        if(!empty($search) && $this->load($search)){
            if(!empty($this->search['account'])){
                $query = $query->andWhere(['like','account',$this->search['account']]);
            }
            if(!empty($this->search['email'])){
                $query = $query->andWhere(['like','email',$this->search['email']]);
            }
            if(!empty($this->search['phone'])){
                $query = $query->andWhere(['like','phone',$this->search['phone']]);
            }
            if(!empty($this->search['roleId']) && $this->search['roleId'] != 0){
                $query = $query->andWhere('roleId = :roleId',[':roleId'=>$this->search['roleId']]);
            }
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    
    public static function ajaxResetpwd(int $id)
    {
        $user = self::findIdentity($id);
        if(empty($user)){
            return false;
        }
        $user->userPwd = Yii::$app->getSecurity()->generatePasswordHash('111111');
        return $user->save(false);
    }
    
    public static function ajaxDel(int $id)
    {
        $user = self::findIdentity($id);
        if(empty($user)){
            return false;
        }
        $user->isDelete = 1;
        return $user->save(false);
    }
    
#########################################################################################################
    
    public static function findIdentity($id) 
    {
        return static::findOne($id); 
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey()
    {
        return '';
    }
    
    public static function findIdentityByAccessToken($token,$type = '')
    {
        return null;
    }
    
    public function validateAuthKey($authKey) 
    {
        return false; 
    } 
}