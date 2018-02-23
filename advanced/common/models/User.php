<?php
namespace common\models;


use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use common\publics\Xcrypt;
use yii\web\UrlManager;

class User extends BaseModel implements IdentityInterface
{
    
    const USER_DELETE = 1;
    const USER_UNDELETE = 0;
    
    public $repass;
    
    public $userName;
    //验证码
    public $verifyCode;
    
    public $_user;
    
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
            ['userPwd','required','message'=>'密码不能为空','on'=>['reg','login','resetpwdByMail']],
            ['userPwd','match','pattern'=>'/(?!^\d+$)(?!^[a-zA-Z]+$)[0-9a-zA-Z]{6,16}/','message'=>'密码必须由6至16位的字母+数字组成','on'=>['reg','resetpwdByMail']],
            ['repass','required','message'=>'重复密码不能为空','on'=>['reg','resetpwdByMail']],
            ['repass','compare','compareAttribute'=>'userPwd','message'=>'两次输入密码不一致','on'=>['reg','resetpwdByMail']],
            ['email','required','message'=>'邮箱不能为空','on'=>['reg','edit','findpwdByMail']],
            ['email','email','message'=>'邮箱格式不正确','on'=>['reg','edit','findpwdByMail']],
            ['email','unique','message'=>'该邮箱已被注册','on'=>['reg','edit']],
            ['email','validEmail','on'=>['findpwdByMail']],
            
            ['userName','required','message'=>'账号/邮箱/手机不能为空','on'=>['login']],
            ['userName','validUserName','on'=>['login']],
            /* ['verifyCode', 'required','message'=>'验证码不能为空','on'=>['login']],
            ['verifyCode', 'captcha','captchaAction'=>'user/captcha','message'=>'验证码不正确','on'=>'login'], */
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
    
    public function validUserName()
    {
        if(!$this->hasErrors()){
            $this->_user = self::find()->where(['or',['account'=>$this->userName],['email'=>$this->userName],['phone'=>$this->userName]])->one();
            if(empty($this->_user)){
                $this->addError('userName','用户名或密码错误');
                return false;
            }
            if(!Yii::$app->getSecurity()->validatePassword($this->userPwd, $this->_user->userPwd)){
                $this->addError('userName','用户名或密码错误');
                return false;
            }
        }
    }
    
    public function validEmail()
    {
        if(!$this->hasErrors()){
            $this->_user = self::find()->where(['email'=>$this->email])->one();
            if(empty($this->_user)){
                $this->addError('email','该邮箱未注册');
                return false;
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
    
    public function login(array $data)
    {
        $this->scenario = 'login';
        if($this->load($data) && $this->validate()){
            $this->lastLoginIp = $this->_user->loginIp;
            $this->loginIp     = ip2long(Yii::$app->request->userIP);
            $this->loginCount  = $this->_user->loginCount + 1;
            $this->modifyTime  = TIMESTAMP;
            if($this->save(false) && Yii::$app->user->login($this->_user,Yii::$app->params['user.passwordResetTokenExpire'])){
                return true;
            }
        }
        return false;
    }
    
    public function findpwdByMail(array $data)
    {
       
        $this->scenario = 'findpwdByMail';
        if($this->load($data) && $this->validate()){
            $kSkYpd = $this->_user->id . '|' . time();
            $key = Yii::$app->params['user.xcryptKey'];
            //加密
            $kSkYpd = Xcrypt::crypt($kSkYpd,'E',$key);
            
            $url = Yii::$app->urlManager->createAbsoluteUrl(['user/resetpwdbymail','kSkYpd'=>$kSkYpd]);
            
            $mailer = Yii::$app->mailer->compose('seekpass', ['url' => $url]);
            $mailer->setTo($this->email);
            $mailer->setSubject('四川省社会主义学院-找回密码');
            if ($mailer->send()) {
                return true;;
            }
        }
        return false;
    }
    
    public static function resetpwdByMail(array $data,User $user)
    {
        $user->scenario = 'resetpwdByMail';
        if($user->load($data) && $user->validate()){
            $user->userPwd = Yii::$app->getSecurity()->generatePasswordHash($user->userPwd);
            return $user->save(false);
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
    
    public function editPwd(array $data)
    {
        $this->scenario = 'editPwd';
        if($this->load($data) && $this->validate()){
            
        }
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
    
    
    public function users(array $data)
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
        if(!empty($data) && $this->load($data) && !empty($this->search)){
           $query = $this->filterSearch($this->search, $query);
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function filterSearch(array $search,ActiveQuery $query)
    {
        if(!empty($search['keywords'])){
            $query = $query->andWhere(['or',
                ['like','account',$search['keywords']],
                ['like','email',$search['keywords']],
                ['like','phone',$search['keywords']]
            ] );
        }
        
        if(isset($search['startTime']) && !empty($search['startTime'])){
            $query = $query->andWhere('createTime >= :startTime',[':startTime'=>strtotime($search['startTime'])]);
        }
        
        if(isset($search['startTime']) && !empty($search['startTime'])){
            $query = $query->andWhere('createTime <= :endTime',[':endTime'=>strtotime($search['endTime'])]);
        }
        return $query;
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