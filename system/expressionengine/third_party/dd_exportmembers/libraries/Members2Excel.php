<?php

/*
Copyright (C) 2012 - Drez Design, LLC.

Platform: 	Expression Engine 2.x 
Module:		DD Export Members
Developer:	Matt Johnson
Company:	Drez Design, LLC.
Web:		www.drez-design.com
Date:		September 10, 2012

This module exports member registration data, including custom fields,
to a Microsoft Excel spreadsheet.  All third-party libraries used in this
module are covered under the GNU Lesser GPL which allows for repackaging
in proprietary software.
*/

error_reporting(E_ALL);
require_once 'PHPExcel.php';
require_once 'PHPExcel/Writer/Excel5.php';

class Members2Excel
{
	private $version = "v1.0";
	private $creator = "Members2Excel";
	private $output  = "ee_member_registrations";
	private $save	 = FALSE;
	private $db		 = FALSE;
	
	public function Members2Excel($db = NULL)
	{
		$this->db = $db;
	}
	
	public function export($columns,$members,$filename)
	{
		if($this->db)
		{
			if( !empty($filename) ) $this->output = $filename;
			
			$workbook = new PHPExcel();
			$workbook->getProperties()->setCreator($this->creator.' : '.$this->version);
			$workbook->getProperties()->setLastModifiedBy($this->creator.' : '.$this->version);
			$workbook->getProperties()->setSubject($this->creator.' : '.$this->version);
			
			$rowIndex = 1;
			$workbook->setActiveSheetIndex(0);
			$workbook->getActiveSheet()->setTitle("EE Member Registrations");
			
			//**********************************************************
			// Set columns as headers
			//**********************************************************

			$style = array(
				"font"=>array("bold"=>TRUE),
				"alignment"=>array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
			);
			
			$fieldCount = count($columns);
			$counter = 0;

			foreach($columns as $field)
			{
				$column_letter = PHPExcel_Cell::stringFromColumnIndex($counter);
				$workbook->getActiveSheet()->setCellValueByColumnAndRow($counter,$rowIndex,$field);
				$workbook->getActiveSheet()->getStyle($column_letter.$rowIndex)->applyFromArray($style);
				$counter++;
			}
			$rowIndex++;
			
			//**********************************************************
			// Write member data to rows
			//**********************************************************
			
			$style = array(
				"font"=>array("bold"=>FALSE),
				"alignment"=>array("horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
			);
			
			foreach($members as $member)
			{
				$counter = 0;

				foreach($member as $key => $value)
				{
					$column_letter = PHPExcel_Cell::stringFromColumnIndex($counter);
					$workbook->getActiveSheet()->setCellValueByColumnAndRow($counter,$rowIndex,$member[$key]);
					//$workbook->getActiveSheet()->getStyle($column_letter.$rowIndex)->applyFromArray($style);
					$counter++;
				}
				$rowIndex++;
			}

			//**********************************************************
			// Auto-size all of the columns to their content
			//**********************************************************

			$counter = 0;
			for($i=0; $i<$fieldCount; $i++)
			{
				$column_letter = PHPExcel_Cell::stringFromColumnIndex($counter);
				$workbook->getActiveSheet()->getColumnDimension($column_letter)->setAutoSize(true);
				$counter++;
			}

			//**********************************************************
			// Write member data to rows
			//**********************************************************
			
			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment;filename=".$this->output.".xls");
			header("Cache-Control: max-age=0");
			$workbookWriter = PHPExcel_IOFactory::createWriter($workbook,"Excel5");
			$workbookWriter->save('php://output'); 
    	}
    	else
    	{
    		die( "You must establish a database connection first!" );
    	}
	}
}