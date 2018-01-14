<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    // yii rbac/init
    // category/* category/add category/delete

    public function actionInit()
    {
        $trans = Yii::$app->db->beginTransaction();
        try {
        	$dir = dirname(dirname(dirname(__FILE__))). '/backend/controllers';
            $controllers = glob($dir. '/*');
            //var_dump($controllers);exit();
            $permissions = [];
            foreach ($controllers as $controller) {
                $content = file_get_contents($controller);
                preg_match('/class ([a-zA-Z]+)Controller/', $content, $match);
                preg_match('/@name ([\x{4e00}-\x{9fa5}]+)/u', $content,$name);
                $cName = $match[1];
                $cNameDesc = $name[1];
                $permissions[] = [
                		'name' => strtolower($cName.'/*'),
                		'desc' => $cNameDesc
                ];
                preg_match_all('/@desc ([\x{4e00}-\x{9fa5}]+)/u', $content, $matchesD);
                preg_match_all('/public function action([a-zA-Z_]+)/', $content, $matches);
                //var_dump($matchesD,$matches);exit();
                foreach ($matchesD[1] as $k => $aNameD) {
                	if( !empty($aNameD) && isset($matches[1][$k]) && !empty($matches[1][$k])){
                		$permissions[] = [
                				'name' => strtolower($cName. '/'. $matches[1][$k]),
                				'desc' => $aNameD
                		];
                	}
                }
                //var_dump($permissions);exit();
            }
           // var_dump($permissions);exit();
            $auth = Yii::$app->authManager;
            foreach ($permissions as $permission) {
            	if($auth->getPermission($permission['name'])){
            		//exit(12);
            	}
            	if (!$auth->getPermission($permission['name'])) {
                	//exit(11);
            		$obj = $auth->createPermission($permission['name']);
            		$obj->description = $permission['desc'];
                    $auth->add($obj);
                }
            }
            $trans->commit();
            echo "import success \n";
        } catch(\Exception $e) {
            $trans->rollback();
            echo "import failed \n".$e->getMessage();
        }
    }

}




