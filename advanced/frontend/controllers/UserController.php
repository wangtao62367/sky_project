<?php
namespace frontend\controllers;



use common\models\User;
use Yii;
use common\publics\Xcrypt;
use frontend\models\EditPwdForm;
use common\models\GradeClass;
use common\models\Student;
/**
* 用户
* @date: 2018年2月6日 下午9:15:27
* @author: wangtao
*/
class UserController extends CommonController
{
    /**
    * 注册
    * @date: 2018年2月6日 下午10:34:34
    * @author: wangtao
    * @param: variable
    * @return:
    */
    public function actionReg()
    {
        $this->layout = 'layout';
        $model = new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $model->reg($post);   
            if($result && Yii::$app->user->login($model,Yii::$app->params['user.passwordResetTokenExpire'])){
                return $this->redirect(['user/center']);
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        return $this->render('reg',['model'=>$model]);
    }
    
    /**
    * 登陆
    * @date: 2018年2月6日 下午10:34:23
    * @author: wangtao
    * @param: variable
    * @return:
    */
    public function actionLogin()
    {
        $this->layout = 'layout';
        $model = new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->login($post)){
            	return $this->redirect(['user/center']);
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        
        return $this->render('login',['model'=>$model]);
    }
    /**
    * 退出登陆
    * @date: 2018年2月6日 下午10:34:07
    * @author: wangtao
    * @param: variable
    * @return:
    */
    public function actionLogout()
    {
        if(Yii::$app->user->logout(false)){
            return $this->redirect(['user/login']);
        }
        return $this->goBack();
    }
    /**
    * 修改密码
    * @date: 2018年2月8日 下午2:45:32
    * @author: wangtao
    * @return:
    */
    public function actionEditPwd()
    {
        $model = new EditPwdForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->editPwd($post)){
                return $this->redirect(['user/login']);
            }else{
                Yii::$app->session->setFlash('error','修改失败');
            }
        }
        return $this->render('editpwd',['model'=>$model]);
    }
    
    
    
    
    /**
    * 邮箱激活账号
    * @date: 2018年2月6日 下午10:33:24
    * @author: wangtao
    * @param: variable
    * @return:
    */
    public function actionActiveEmail()
    {
        $param = Yii::$app->request->get('k','');
        if(empty($param)){
            
        }
        $key = Yii::$app->params['user.xcryptKey'];
        //设置模式和IV
        $xcrypt= new Xcrypt($key, 'cbc', 'auto');
        //加密
        //$b = $xcrypt->encrypt('19|1364832245', 'base64');
        //解密
        $result = $xcrypt->decrypt($param, 'base64');
        $params = explode('|', $result);
        //判断时间是否失效
        $expireTime = Yii::$app->params['user.emailHandleExpire'];
        if((time() - $params[1])>$expireTime){
            //已失效
            
        }
        //激活用户
        $user = User::findOne($param[0]);
        $user->isFronzen = 0;
        if($user->save(false)){
            //todo...
            
        }
    }
    /**
    * 发送邮件找回密码
    * @date: 2018年2月23日 上午10:39:29
    * @author: wangtao
    * @param: userEmail 用户邮箱
    * @return:
    */
    public function actionFindpwdbymail()
    {
        $this->layout = 'layout';
        $model = new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = $model->findpwdByMail($post);
            if($result){
                Yii::$app->session->setFlash('success','邮件已发送，请注意查收');
            }else {
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        
        return  $this->render('findpwdbymail',['model'=>$model]);
    }
    
    /**
    * 邮箱找回密码，设置新密码
    * @date: 2018年2月23日 下午4:38:51
    * @author: wangtao
    * @param: $kSkYpd
    * @return:
    */
    public function actionResetpwdbymail()
    {
        $this->layout = 'layout';
        $param = Yii::$app->request->get('kSkYpd','');
        if(empty($param)){
            return $this->render('linkexprise');
        }
        $key = Yii::$app->params['user.xcryptKey'];
        //解密
        $result = Xcrypt::crypt($param, 'D',$key);
        
        $params = explode('|', $result);
        //判断时间是否失效
        $expireTime = Yii::$app->params['user.emailHandleExpire'];
        if((time() - $params[1])>$expireTime){
            //已失效
            return $this->render('linkexprise');
        }
        $model = User::find()->where(['id'=>$params[0]])->one();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $result = User::resetpwdByMail($post,$model);
            if($result){
                return $this->redirect(['user/login']);
            }else{
                Yii::$app->session->setFlash('error',$model->getErrorDesc());
            }
        }
        $model->userPwd = '';
        $model->repass = '';
        return  $this->render('resetpwdbymail',['model'=>$model]);
    }
    /**
    * 用户中心
    * @date: 2018年2月23日 下午4:39:49
    * @author: wangtao
    * @return:
    */
    public function actionCenter()
    {
        $student = new Student();
        $data = Yii::$app->request->get();
        $data['Student']['search'] = ['userId'=>Yii::$app->user->id];
        $result = $student->pageList($data);

        return $this->render('center',['list'=>$result]);
    }
    
/*     public function actions()
    {
        return  [
//             'captcha' =>[
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//             ],  //默认的写法
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'TEST' : null,
                'backColor'=>0x000000,//背景颜色
                'maxLength' => 6, //最大显示个数
                'minLength' => 5,//最少显示个数
                'padding' => 5,//间距
                'height'=>40,//高度
                'width' => 130,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4,        //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
            ],
        ];
    } */
}