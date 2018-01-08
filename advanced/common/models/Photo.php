<?php
namespace common\models;



class Photo extends BaseModel
{
	
	public static function tableName()
	{
		
		return '{{%photo}}';
	}
	
	public function rules()
	{
		return [
				
		];
	}
}