<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Copyright (C) 2012 - Drez Design, LLC.

Platform: 	Expression Engine 2.x 
Module:		DD Export Members
Developer:	Matt Johnson
Company:		Drez Design, LLC.
Web:			www.drez-design.com
Date:		July 15, 2013

This module exports member registration data, including custom fields,
to a Microsoft Excel spreadsheet.  All third-party libraries used in this
module are covered under the GNU Lesser GPL which allows for repackaging
in proprietary software.
*/

class Dd_exportmembers_upd {

	var $version = '1.4';
	
	function Dd_exportmembers_upd()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
	}

	// --------------------------------------------------------------------

	function install() { 
        
        $this->EE->load->dbforge(); 

        $data = array( 'module_name' => 'Dd_exportmembers' , 'module_version' => $this->version, 'has_cp_backend' => 'y' ); 
        $this->EE->db->insert('modules', $data); 

        $dd_exportmembers_fields = array(
            'export_id' => array(
                'type' => 'int',
                'constraint' => '10',
                'unsigned' => TRUE,
                'auto_increment' => TRUE),
            'export_name' => array(
				'type' => 'varchar',
                'constraint' => '255',
                'null' => FALSE),
            'export_members' => array(
                'type' => 'text',
                'null' => FALSE),
			'export_limit' => array(
				'type' => 'varchar',
                'constraint' => '255',
                'null' => FALSE),
            'export_fields' => array(
                'type' => 'text',
                'null' => FALSE),
            'export_columns' => array(
                'type' => 'text',
                'null' => FALSE),
            'export_type' => array(
                'type' => 'text',
                'null' => FALSE),
			'export_date' => array(
                'type' => 'varchar',
                'constraint' => '255',
                'null' => FALSE)
        );

        $this->EE->dbforge->add_field($dd_exportmembers_fields);
        $this->EE->dbforge->add_key('export_id', TRUE);
        $this->EE->dbforge->create_table('dd_exportmembers_saved');
        
        return TRUE; 
    } 
    
    function uninstall() { 
        
        $this->EE->load->dbforge(); 
        
        $this->EE->db->select('module_id'); 
        $query = $this->EE->db->get_where('modules', array('module_name' => 'Dd_exportmembers')); 
        
        $this->EE->db->where('module_id', $query->row('module_id')); 
        $this->EE->db->delete('module_member_groups'); 
        
        $this->EE->db->where('module_name', 'Dd_exportmembers'); 
        $this->EE->db->delete('modules'); 
        
        $this->EE->db->where('class', 'Dd_exportmembers'); 
        $this->EE->db->delete('actions'); 

		$this->EE->dbforge->drop_table('dd_exportmembers_saved');
        
        return TRUE; 
    }

	function update($current='')
	{
		return TRUE;
	}	
}