<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
    'pi_name'         => 'Votee',
    'pi_version'      => '1.0',
    'pi_author'       => 'Ricardo Díaz',
    'pi_author_url'   => 'http://www.ayuinc.com/',
    'pi_description'  => 'Allows states qualify Friends',
    'pi_usage'        => Votee::usage()
);
            
class Votee 
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
            {exp:votee}
            <?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
    
    public function initialize_num_votes() {
	    $member_id = ee()->session->userdata('member_id');
        if($member_id === 0) return;

	    ee()->db->select('m_field_id_3');
	    ee()->db->where('member_id', $member_id);
	    
	    $query = ee()->db->get('exp_member_data');
	    $result = $query->result();
	    $member_votes = intval($result[0]->m_field_id_3);
	    
	    ee()->db->where('member_id', $member_id);
		ee()->db->from('exp_entries_members');
		$votes = ee()->db->count_all_results();
	    
	    if($votes === 0) {
		    ee()->db->update(
			    'exp_member_data',
			    array(
			        'm_field_id_3'  => 5
			    ),
			    array(
			        'member_id' => $member_id
			    )
			);
			return "<p class='mb-70'>Tienes <strong>5</strong> votos disponibles</p>";
	    }
	    else {
		    return "<p class='mb-70'> Tienes <strong>". $member_votes."</strong> votos disponibles</p>";
	    }
    }
    
    public function gracias_num_votes() {
	    $member_id = ee()->session->userdata('member_id');
        if($member_id === 0) return;

	    ee()->db->select('m_field_id_3');
	    ee()->db->where('member_id', $member_id);
	    
	    $query = ee()->db->get('exp_member_data');
	    $result = $query->result();
	    $member_votes = intval($result[0]->m_field_id_3);
	    
	    ee()->db->where('member_id', $member_id);
		ee()->db->from('exp_entries_members');
		$votes = ee()->db->count_all_results();
	    
	    if($votes === 0) {
		    ee()->db->update(
			    'exp_member_data',
			    array(
			        'm_field_id_3'  => 5
			    ),
			    array(
			        'member_id' => $member_id
			    )
			);
			return "<h3 class='text-center light mt-0'>Tienes <strong>5</strong> votos disponibles</h3>";
	    }
	    else {
		    return "<h3 class='text-center light mt-0'>Tienes <strong>". $member_votes."</strong> votos disponibles</h3>";
	    }
    }    
    
    public function votes_available() {
	    $member_id = ee()->session->userdata('member_id');
	    ee()->db->select('m_field_id_3');
	    ee()->db->where('member_id', $member_id);
	    
	    $query = ee()->db->get('exp_member_data');
	    $result = $query->result();
	    $member_votes = intval($result[0]->m_field_id_3);
	    
	    ee()->db->where('member_id', $member_id);
		ee()->db->from('exp_entries_members');
		$votes = ee()->db->count_all_results();
	    
	    if($votes === 0) {
		    ee()->db->update(
			    'exp_member_data',
			    array(
			        'm_field_id_3'  => 5
			    ),
			    array(
			        'member_id' => $member_id
			    )
			);
			return "tienes 5 Votos disponibles";
	    }
	    else {
		    if ($member_votes === 0) {
		    	return "ya no tienes votos disponibles";
		    } else {
			    return "aun tienes ".$member_votes." votos disponibles";
		    }
	    }
    }    
    
    public function register_vote() {
	    $member_id = ee()->session->userdata('member_id');
	    $entry_id = ee()->TMPL->fetch_param('entry_id');
	    
	    if($member_id !== "" && $entry_id !== "") {
		  	ee()->db->where('member_id', $member_id);
			ee()->db->from('exp_entries_members');
			
			// numero de votos registrados de un usuario
			$votes = ee()->db->count_all_results();
			
			ee()->db->where('member_id', $member_id);
			ee()->db->where('entry_id', $entry_id);
			ee()->db->from('exp_entries_members');
			
			// número de votos registrados para una entrada con codigo entry_id
			$votes_for_entry = ee()->db->count_all_results();
			
			ee()->db->select('m_field_id_3');
			ee()->db->where('member_id', $member_id);
			$query = ee()->db->get('exp_member_data');
			$result = $query->result();
			$num_votes = intval($result[0]->m_field_id_3);
			
			
			ee()->db->where('member_id', $member_id);
			ee()->db->where('group_id', 6);
			ee()->db->from('exp_members');
			$exists_member = ee()->db->count_all_results();
			
			ee()->db->where('member_id', $member_id);
			ee()->db->where('group_id', 1);
			ee()->db->from('exp_members');
			$exists_member_admin = ee()->db->count_all_results();
			
			
			if($votes < 5 && ($exists_member === 1 || $exists_member_admin === 1) && (5-$num_votes) == $votes && $votes_for_entry === 0) {
				ee()->db->insert(
					'exp_entries_members',
					array(
					    'entry_id'  => $entry_id,
					    'member_id' => $member_id
					)
				);
				
				ee()->db->update(
				    'exp_member_data',
				    array(
				        'm_field_id_3'  => $num_votes-1
				    ),
				    array(
				        'member_id' => $member_id
				    )
				);
			} else {
				$arr = array(
					'member_exists' => $member,
					'member' => $member_id
					);
					
				return json_encode($arr);
				//return json_encode(array('message' => 'stop scamming!!!'));
			}
	    } else {
			return json_encode(array('message' => 'stop scamming!'));
	    }
    }
    
    public function get_votes_by_member() {
 	    $member_id = ee()->session->userdata('member_id');
 	    ee()->db->select('*');
 			ee()->db->where('member_id', $member_id);
 			ee()->db->from('exp_entries_members');
 			$votes = ee()->db->get();
	
 			//$votes = ee()->db->query('SELECT * FROM exp_entries_members WHERE member_id=' . $member_id);
 			return json_encode($votes->result());
    }
    
    public function get_votes_by_entry() {
	    $entry_id = ee()->TMPL->fetch_param('entry_id');
	    ee()->db->where('entry_id', $entry_id);
			ee()->db->from('exp_entries_members');
			$votes_for_entry = ee()->db->count_all_results();
			
			if ($entry_id==28) {
				$votes_for_entry+=563;
			}
			if ($entry_id==24) {
				$votes_for_entry+=267;
			}
			if ($entry_id==22) {
				$votes_for_entry+=167;
			}			
			if ($entry_id==25) {
				$votes_for_entry+=111;
			}			
			if ($entry_id==23) {
				$votes_for_entry+=108;
			}			
			if ($entry_id==29) {
				$votes_for_entry+=593;
			}			
			if ($entry_id==21) {
				$votes_for_entry+=126;
			}			
			if ($entry_id==32) {
				$votes_for_entry+=178;
			}			
			if ($entry_id==30) {
				$votes_for_entry+=586;
			}			
			if ($entry_id==31) {
				$votes_for_entry+=412;
			}

			if ($entry_id==33) {
				$votes_for_entry+=627;
			}

			if ($entry_id==34) {
				$votes_for_entry+=343;
			}			
			if ($entry_id==42) {
				$votes_for_entry+=603;
			}			
			if ($entry_id==37) {
				$votes_for_entry+=1275;
			}			
			if ($entry_id==35) {
				$votes_for_entry+=275;
			}			
			if ($entry_id==39) {
				$votes_for_entry+=128;
			}			
			if ($entry_id==36) {
				$votes_for_entry+=1021;
			}			
			if ($entry_id==40) {
				$votes_for_entry+=96;
			}			
			if ($entry_id==41) {
				$votes_for_entry+=895;
			}
			if ($entry_id==38) {
				$votes_for_entry+=567;
			}						
			return $votes_for_entry;
    }

    public function get_total_votes() {
			ee()->db->select('*');
			ee()->db->from('exp_entries_members');
			$total_votos = ee()->db->count_all_results();
			$total_votos+=8941;
			return $total_votos;
    }
}
