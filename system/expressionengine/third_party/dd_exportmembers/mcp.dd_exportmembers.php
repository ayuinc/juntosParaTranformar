<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Copyright (C) 2012 - Drez Design, LLC.

Platform: 	Expression Engine 2.x 
Module:		DD Export Members
Developer:	Matt Johnson
Company:	Drez Design, LLC.
Web:		www.drez-design.com
Date:		July 15, 2013

This module exports member registration data, including custom fields,
to a Microsoft Excel spreadsheet.  All third-party libraries used in this
module are covered under the GNU Lesser GPL which allows for repackaging
in proprietary software.
*/

class Dd_exportmembers_mcp {

	var $title = "Export Members";
	var $version = "v1.4";
	var $perpage = 100;
	var $base_path = "";

	//*************************************************************
	//	CONSTRUCTOR
	//*************************************************************
    
    function __construct() 
	{ 
        $this->EE =& get_instance(); 
		$this->db = $this->EE->db;

		$this->base_path = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=dd_exportmembers';

		$this->EE->cp->set_right_nav(array(
			'Export Members' => $this->base_path,
			'Saved Exports' => $this->base_path.AMP.'method=saved_exports'
		));

		//DISABLE THE SCRIPT EXECUTION TIME LIMIT
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
    	{
        	@set_time_limit(0);
    	} 
    } 

	//*************************************************************
	//	CONTROL PANEL
	//*************************************************************

	function index()
	{		
		$errors = 0;
		$save = FALSE;
		$save_export = "";
		$site_id = $this->EE->config->item("site_id");

		$data["errmsg"] = "";
		$data["errmsg2"] = "";

		$data["format"] = "excel";
		$data["groups"] = "";
		$data["fields"] = array();
		$data["cfields"] = array();
		$data["exports"] = array();

		$data["limit_post"] = 0;
		$data["offset_post"] = 0;
		$data["groups_post"] = array();
		$data["fields_post"] = array();
		$data["cfields_post"] = array();

		//Get member groups
		$this->db->select('group_id,group_title');
		$this->db->from('member_groups');
		$this->db->where("site_id",$site_id);
		$query = $this->db->get();
		$data["groups"] = $query->result_array();
		
		//Get member fields
		$m_skip = array("password","salt","unique_id","crypt_key","authcode");
		$m_fields = $this->db->list_fields("members");
		
		//Parse out system fields
		foreach($m_fields as $field)
		{
			if( !in_array($field,$m_skip) )
			{
				array_push($data["fields"],$field);
			}
		}
		
		//Get any custom fields
		$this->db->select('m_field_id, m_field_label');
		$this->db->from('member_fields');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$data["cfields"] = $query->result_array();
		}

		if( isset($_POST["save_submit"]) )
		{
			$save = TRUE;
			$save_export = $this->EE->input->post("save_export",TRUE);
			if(empty($save_export))
			{
				$save = FALSE;
				$errors++;
				$data["errmsg3"] = "Sorry, you must enter an export name!";
			}
		}

		if( isset($_POST["submit"]) || isset($_POST["save_submit"]) )
		{
			$data["format"]			= $this->EE->input->post("format",TRUE);
			$data["limit_post"] 	= $this->EE->input->post("dd_limit",TRUE);
			$data["offset_post"] 	= $this->EE->input->post("dd_offset",TRUE);
			$data["groups_post"] 	= $this->EE->input->post("members",TRUE);
			$data["fields_post"] 	= $this->EE->input->post("fields",TRUE);
			$data["cfields_post"] 	= $this->EE->input->post("customs",TRUE);
			
			if(empty($data["groups_post"]))
			{
				$errors++;
				$data["errmsg"] = "Sorry, you must select at least one member group!";
				$data["groups_post"] = array();
			}

			if($data["limit_post"] < 0 || $data["offset_post"] < 0)
			{
				$errors++;
				$data["errmsg1"] = "Sorry, positive values only!";
			}

			if(!is_numeric($data["limit_post"]) || !is_numeric($data["offset_post"]))
			{
				$errors++;
				$data["errmsg1"] = "Sorry, numeric values only!";
			}

			if(empty($data["fields_post"]) && empty($data["cfields_post"]))
			{
				$errors++;
				$data["errmsg2"] = "Sorry, you must select at least one standard or custom field!";
			}

			if(empty($data["fields_post"]))
			{
				$data["fields_post"] = array();
			}

			if(empty($data["cfields_post"]))
			{
				$data["cfields_post"] = array();
			}
			
			if($errors == 0)
			{
				//Build a list of the spreadsheet columns
				$columns = array();
				
				//Build the list of standard fields
				$member_fields = array();
				for($i=0; $i<count($data["fields_post"]); $i++)
				{
					array_push($member_fields,"members.".$data["fields_post"][$i]);
					array_push($columns,ucwords(str_replace("_"," ",$data["fields_post"][$i])));
				}
				
				//Build the list of custom fields
				if( !empty($data["cfields_post"]) )
				{
					for($i=0; $i<count($data["cfields_post"]); $i++)
					{
						array_push($member_fields,"member_data.m_field_id_".$data["cfields_post"][$i]);
					
						foreach($data["cfields"] as $cfield)
						{
							if($cfield["m_field_id"] == $data["cfields_post"][$i])
							{
								array_push($columns,$cfield["m_field_label"]);
							}
						}
					}
				}
				
				//Add commas to query statement
				$fields = implode(",",$member_fields);
				
				//Build the list of members groups ids
				$groups = "";
				for($i=0; $i<count($data["groups_post"]); $i++)
				{
					$groups .= "group_id = " . $data["groups_post"][$i];
					if( $i < count($data["groups_post"]) - 1) $groups .= " OR ";
				}

				//Save this export query?
				if($save)
				{
					$limit_list = $data["limit_post"] . "|" . $data["offset_post"];
					$member_list = implode("|",$data["groups_post"]);
					$field_list = $fields;
					$column_list = implode("|",$columns);

					$insert = array("export_name"=>$save_export,
									"export_members"=>$member_list,
									"export_limit"=>$limit_list,
									"export_fields"=>$field_list,
									"export_columns"=>$column_list,
									"export_type"=>$data["format"],
									"export_date"=>time());
									
					$sql = $this->db->insert("dd_exportmembers_saved",$insert);
				}

				//Get results using Active Record
				$this->db->select($fields);
				$this->db->from("members");
 				$this->db->join("member_data","members.member_id = member_data.member_id");
				$this->db->where($groups);

				//Set limit and offset if needed
				if($data["limit_post"] > 0 && $data["offset_post"] == 0)
				{
					$this->db->limit($data["limit_post"]);
				}
				if($data["limit_post"] > 0 && $data["offset_post"] > 0)
				{
					$this->db->limit($data["limit_post"],$data["offset_post"]);
				}

				$query = $this->db->get();

				$members = $query->result_array();
				if($query->num_rows() > 0)
				{
					if($data["format"] == "excel") $this->download_excel($columns,$members);
					else $this->download_csv($columns,$members);
				}
				else
				{
					$data["errmsg"] = "Sorry, this selection does not contain any registrations.";
				}
			}
		}

		$data['cp_page_title'] = $this->title;
		$data['base_path'] = $this->base_path;
		$this->EE->cp->load_package_js("dd_exportmembers");
		return $this->EE->load->view('view', $data, TRUE);
	}

	//*************************************************************
	//	VIEW SAVED EXPORTS
	//*************************************************************

	function saved_exports()
	{
		//Get all saved exports
		$query = $this->db->get('dd_exportmembers_saved');
		$data["exports"] = $query->result_array();

		$data['cp_page_title'] = $data['cp_page_title'] = $this->title." - Saved Exports";
		$data['base_path'] = $this->base_path;
		return $this->EE->load->view('saved', $data, TRUE);
	}

	//*************************************************************
	//	EXECUTE SAVED EXPORT
	//*************************************************************

	function load_export()
	{
		$success = FALSE;

		$export_id = $this->EE->input->get("export_id");
		if( !empty($export_id) AND is_numeric($export_id) )
		{
			$query = $this->db->get_where('dd_exportmembers_saved', array('export_id' => $export_id), 1, 0);
			if($query->num_rows() == 1)
			{
				$export = $query->row_array();

				$limit_in		= explode("|",$export["export_limit"]);
				$members_in 	= explode("|",$export["export_members"]);
				$fields_in 		= $export["export_fields"];
				$columns_in 	= explode("|",$export["export_columns"]);
				$type_in		= $export["export_type"];
				
				//Build the list of members groups ids
				$groups = "";
				for($i=0; $i<count($members_in); $i++)
				{
					$groups .= "group_id = " . $members_in[$i];
					if( $i < count($members_in) - 1) $groups .= " OR ";
				}

				//Get results using Active Record
				$this->db->select($fields_in);
				$this->db->from("members");
 				$this->db->join("member_data","members.member_id = member_data.member_id");
				$this->db->where($groups);

				//Set limit and offset if needed
				if($limit_in[0] > 0 && $limit_in[1] == 0)
				{
					$this->db->limit($limit_in[0]);
				}
				if($limit_in[0] > 0 && $limit_in[1] > 0)
				{
					$this->db->limit($limit_in[0],$limit_in[1]);
				}

				$query = $this->db->get();

				$members = $query->result_array();
				if($query->num_rows() > 0)
				{
					$success = TRUE;
					if($type_in == "excel") $this->download_excel($columns_in,$members);
					else $this->download_csv($columns_in,$members);
				}
				else
				{
					$success = TRUE;
					$this->EE->session->set_flashdata('message_failure',"Sorry, this selection does not contain any registrations!");
					$this->EE->functions->redirect($this->base_path.AMP.'method=saved_exports');
				}
			}
		}
		
		if(!$success)
		{
			$this->EE->session->set_flashdata('message_failure',"Sorry, the requested export could not be found!");
			$this->EE->functions->redirect($this->base_path.AMP.'method=saved_exports');
		}
	}

	//*************************************************************
	//	DELETE SAVED EXPORT
	//*************************************************************

	function delete_export()
	{
		$export_id = $this->EE->input->get("export_id");
		if( !empty($export_id) AND is_numeric($export_id) )
		{
			$this->db->delete('dd_exportmembers_saved', array('export_id' => $export_id)); 
			if($this->db->affected_rows() == 1)
			{
				$this->EE->session->set_flashdata('message_success','Your saved export has been deleted!');
			}
			else
			{
				$this->EE->session->set_flashdata('message_failure','Your saved export could not be deleted!');
			}
		}

		$this->EE->functions->redirect($this->base_path.AMP.'method=saved_exports');
	}

	//*************************************************************
	//	DOWNLOAD EXCEL
	//*************************************************************

	function download_excel($columns,$members)
	{
		$this->EE->load->library("Members2Excel");
		$excel = new Members2Excel($this->db);
		$excel->export($columns,$members,"ee_member_registrations");
	}
	
	function download_csv($columns,$members)
	{
		$this->EE->load->library("Members2CSV");
		$csv = new Members2CSV($this->db);
		$csv->export($columns,$members,"ee_member_registrations");
	}
}