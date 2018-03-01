<?php
namespace common\models;




class ExcelMolde
{
	
	private $version = 'Excel2007';
	
	public function __construct(array $config)
	{
		$this->version = isset($config['version']) && !empty($config['version']) ? $config['version'] : 'Excel2007';
	}
	
	
	public static function exportBrowser(string $fileName,$version = 'Excel5')
	{
	    ob_end_clean();
		if($version == 'Excel5'){
			header('Content-Type: application/vnd.ms-excel');
		}else {
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		}
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');
		
	}
}