<?php
namespace common\models;


use Yii;
use yii\web\IdentityInterface;

class User extends BaseModel implements IdentityInterface
{
    
    const USER_DELETE = 1;
    const USER_UNDELETE = 0;
    
    public $repass;
    
    public static function tableName()
    {
        return '{{%User}}';
    }
    
    public function rules()
    {
        return [
            ['account','required','message'=>'用户账号不能为空','on'=>['reg','edit']],
            ['account','unique','message'=>'该用户账号已经存在','on'=>['reg','edit']],
            ['account', 'string' ,'length'=>[3,20],'tooLong'=>'用户账号长度为6-40个字符', 'tooShort'=>'用户账号长度为3-20个字','on'=>['reg','edit']],
            ['userPwd','required','message'=>'密码不能为空','on'=>['reg']],
            ['userPwd','match','pattern'=>'/^(?![a-zA-z]+$)(?!\d+$)(?![!@#$%^&*]+$)(?![a-zA-z\d]+$)(?![a-zA-z!@#$%^&*]+$)(?![\d!@#$%^&*]+$)[a-zA-Z\d!@#$%^&*]+$/','message'=>'密码必须由字母+数字+特殊字符组成','on'=>['reg']],
            ['repass','required','message'=>'重复密码不能为空','on'=>['reg']],
            ['repass','compare','compareAttribute'=>'userPwd','message'=>'两次输入密码不一致','on'=>['reg']],
            ['email','required','message'=>'邮箱不能为空','on'=>['reg','edit']],
            ['email','email','message'=>'邮箱格式不正确','on'=>['reg','edit']],
            ['email','unique','message'=>'该邮箱已被注册','on'=>['reg','edit']],
            ['roleId','default','value'=>1],//暂时不涉及角色
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
            $this->userPwd = Yii::$app->getSecurity()->generatePasswordHash($this->userPwd);
            return $this->save(false);
        }
        return false;
    }
    
    public static function edit(array $data,User $user)
    {
        $user->scenario = 'edit';
        if($user->load($data) && $user->validate() && $user->save(false)){
            return true;
        }
        return false;
    }
    
    public static function del(User $user)
    {
        $user->isDelete = self::USER_DELETE;
        return $user->save(false);
    }
    
    public static function frozen(User $user)
    {
        $user->isFrozen = 1;
        return $user->save(false);
    }
    
    public static function active(User $user)
    {
        $user->isFrozen = 0;
        return $user->save(false);
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
            ])
            //->joinWith('roles')
            ->orderBy('createTime desc,modifyTime desc')
            ->where(['isDelete'=>self::USER_UNDELETE]);
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        if(!empty($search) && $this->load($search)){
            if(!empty($this->search['keywords'])){
                $query = $query->andWhere(['or',
                    ['like','account',$this->search['keywords']],
                    ['like','email',$this->search['keywords']],
                    ['like','phone',$this->search['keywords']]
                ] );
            }
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    
    public static function resetPwd(User $user)
    {
        $user->userPwd = Yii::$app->getSecurity()->generatePasswordHash('111111');
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