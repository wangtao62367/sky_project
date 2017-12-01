<?php
namespace common\models;



use Yii;


class Admin extends BaseModel implements \yii\web\IdentityInterface
{
    public $repass;
    
    public static function tableName()
    {
        return '{{%Admin}}';
    }
    
    public function rules()
    {
        return [
            ['account','required','message'=>'账号不能为空','on'=>'add'],
            ['adminPwd','required','message'=>'密码不能为空','on'=>'add'],
            ['repass','required','message'=>'重复密码不能为空','on'=>'add'],
            ['repass', 'compare', 'compareAttribute' => 'adminPwd', 'message' => '两次密码输入不一致', 'on' => ['add']],
            ['adminEmail','required','message'=>'邮箱不能为空','on'=>'add'],
            ['search','safe']
            
        ];
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