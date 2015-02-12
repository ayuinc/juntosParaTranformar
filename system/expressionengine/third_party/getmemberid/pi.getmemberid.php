<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$plugin_info = array(
    'pi_name'         => 'TiNi',
    'pi_version'      => '1.0',
    'pi_author'       => 'Gianfranco Montoya',
    'pi_author_url'   => 'http://www.ayuinc.com/',
    'pi_description'  => 'Allows states qualify Friends',
    'pi_usage'        => Getmemberid::usage()
);
            
class Getmemberid 
{
    var $return_data = "";
    // --------------------------------------------------------------------
        /**
         * Memberlist
         *
         * This function returns a list of members
         *
         * @access  public
         * @return  string
         */
    public function __construct(){
        $this->EE =& get_instance();
        $var = $this->EE->input->post('count');
    }
    // --------------------------------------------------------------------
    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>
            {exp:getmemberid:get_mid}
            <?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
    
    public function get_mid() {
	    $member_id = ee()->session->userdata('member_id');
	}
}