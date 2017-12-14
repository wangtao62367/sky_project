<?php
namespace common\models;



use Yii;


class Admin extends BaseModel implements \yii\web\IdentityInterface
{
    //冻结
    const ADMIN_FROZEN = 1;
    //激活
    const ADMIN_ACTIVE = 0;
    
    public $repass;
    
    public $_admin;
    
    public static function tableName()
    {
        return '{{%Admin}}';
    }
    
    public function rules()
    {
        return [
            ['account','required','message'=>'账号不能为空','on'=>['add','login']],
            ['adminPwd','required','message'=>'密码不能为空','on'=>['add','login']],
            ['adminPwd','validAdminPwd','on'=>'login'],
            ['repass','required','message'=>'重复密码不能为空','on'=>'add'],
            ['repass', 'compare', 'compareAttribute' => 'adminPwd', 'message' => '两次密码输入不一致', 'on' => ['add']],
            ['adminEmail','required','message'=>'邮箱不能为空','on'=>'add'],
            ['search','safe']
            
        ];
    }
    
    public function validAdminPwd()
    {
        if(!$this->hasErrors()){
            $this->_admin = self::find()->where('account = :account and isFrozen = :isFrozen',[':account'=>$this->account,':isFrozen'=>self::ADMIN_ACTIVE])->one();
            if(empty($this->_admin)){
                $this->addError('account','用户名或密码错误');
                return false;
            }
            if( !Yii::$app->getSecurity()->validatePassword($this->adminPwd, $this->_admin->adminPwd) ){
                $this->addError('account','用户名或密码错误');
                return false;
            }
        }
    }
    
    public function login(array $data)
    {
        $this->scenario = 'login';
        if($this->load($data) && $this->validate()){
            $this->_admin->loginCount = $this->_admin->loginCount + 1;
            $this->_admin->lastLoginIp= $this->_admin->loginIp;
            $this->_admin->loginIp    = ip2long(Yii::$app->request->userIP);
            
            return $this->_admin->save(false) && Yii::$app->user->login($this->_admin,Yii::$app->params['admin.passwordResetTokenExpire']);
        }
        return false;
    }
    
    public function add(array $data)
    {
        $this->scenario = 'add';
        if($this->load($data) && $this->validate($data)){
            $this->adminPwd = Yii::$app->getSecurity()->generatePasswordHash($this->adminPwd);
            return $this->save(false);
        }
        return false;
    }
    
    public function admins(array $data,array $search)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find();
        if(!empty($search) && $this->load($search)){
            if(!empty($this->search['account'])){
                $query = $query->andWhere(['like','account',$this->search['account']]);
            }
            if(!empty($this->search['adminEmail'])){
                $query = $query->andWhere(['like','adminEmail',$this->search['adminEmail']]);
            }
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function attributeLabels()
    {
        return [
            'account' => '管理员账号',
            'adminPwd'=> '管理员密码',
            'repass'  => '重复密码',
            'adminEmail' => '管理员邮箱',
            'loginCount' => '登陆次数',
            'loginIp' => '登陆IP',
            'lastLoginIp' => '上次登陆IP',
            'createTime' => '创建时间',
            'modifyTime' => '更新时间'
        ];
    }
    
#################################################################################################################################
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // 如果token无效的话，
        return null;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey()
    {
        return '';
    }
    
    public function validateAuthKey($authKey)
    {
        return true;
    }
}