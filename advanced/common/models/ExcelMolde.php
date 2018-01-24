<?php
namespace common\models;




class ExcelMolde
{
	
	private $version = 'Excel2007';
	
	public function __construct(array $config)
	{
		$this->version = isset($config['version']) && !empty($config['version']) ? $config['version'] : 'Excel2007';
	}
	
	
	public function export()
	{
		$phpExcel = new \PHPExcel();
		
		$objSheet = $phpExcel->getActiveSheet();
		$objSheet->setTitle('demo');
		$objSheet->setCellValue('A1','姓名')->setCellValue('B1','分数');
		$objSheet->setCellValue('A2','张三')->setCellValue('B2','89');
		
		$objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
		
		$this->exportBrowser('demo.xlsx');
		$objWriter->save('php://output');
	}
	
	
	public static function exportBrowser(string $fileName,$version = 'Excel5')
	{
		if($version == 'Excel5'){
			header('Content-Type: application/vnd.ms-excel');
		}else {
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		}
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		header('Cache-Control: max-age=0');
		
	}
}