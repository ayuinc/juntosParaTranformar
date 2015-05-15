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

class Members2CSV
{
	private $version = "v1.0";
	private $creator = "Members2CSV";
	private $output  = "ee_member_registrations";
	private $save	 = FALSE;
	private $db		 = FALSE;
	
	public function Members2CSV($db = NULL)
	{
		$this->db = $db;
	}
	
	public function export($columns,$members,$filename)
	{
		if($this->db)
		{
			if( !empty($filename) ) $this->output = $filename;
			
			ob_start();
			$df = fopen("php://output",'w');
			
			//**********************************************************
			// Set columns as headers
			//**********************************************************
			
			fputcsv($df,$columns);
			
			//**********************************************************
			// Write member data to rows
			//**********************************************************
			
			foreach($members as $member)
			{
				fputcsv($df,$member);
			}
			
			fclose($df);

			//**********************************************************
			// Write member data to rows
			//**********************************************************
			
			header("Cache-Control: max-age=0");
			
			header("Content-Type: application/force-download");
    		header("Content-Type: application/octet-stream");
    		header("Content-Type: application/download");
    		
			header("Content-Disposition: attachment;filename=".$this->output.".csv");
			header("Content-Transfer-Encoding: binary");
			
			echo ob_get_clean();
			die();
    	}
    	else
    	{
    		die( "You must establish a database connection first!" );
    	}
	}
}