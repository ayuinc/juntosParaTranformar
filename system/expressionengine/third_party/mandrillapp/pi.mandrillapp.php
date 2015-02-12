<?php 

$plugin_info = array(
						'pi_name'			=> 'Mandrillapp',
						'pi_version'		=> '1.0',
						'pi_author'			=> 'Gianfranco Montoya',
						'pi_author_url'		=> 'http://ayuinc.com',
						'pi_description'	=> 'Envia mensajes usando el API de Mandrillapp - https://mandrillapp.com',
						'pi_usage'			=> Mandrillapp::usage()
					);

/**
 * Send_email class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			Gianfranco Montoya
 * @copyright		Copyright (c) 2014 Engaging.net
 * @link			--
 */

class Mandrillapp {

	function usage()
	{
		ob_start(); 
		?>
			See the documentation at http://www.engaging.net/docs/send-email
		<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}

	function send_email_final_postulacion(){
		global $TMPL;
		$this->EE =& get_instance(); // EEv2 syntax
		$TMPL = $this->EE->TMPL;

		require_once 'mailchimp-mandrill-api-php/src/Mandrill.php'; 
		$mandrill = new Mandrill('41EG-8dzZN-rtJ8GBngAFA');
		$email_postulante= $TMPL->fetch_param('email_postulante');
		$id_postulante= $TMPL->fetch_param('id_postulante');

		$result = '';
	    ee()->db->select('form_field_42');
	    ee()->db->where('author_id',$id_postulante);
	    $query = ee()->db->get('exp_freeform_form_entries_2');
	    foreach($query->result() as $row){
	        $result = $row->form_field_42;
	    }
		
		if($result != "si"){
			$to= $email_postulante;
			$name= "Administrador TiNi";
			$subject= "Postulación al Premio TiNi 2014";
			$from= "info@aniaorg.pe";
			//$text = $TMPL->tagdata;
			$text = '';
			$text .= '<p>Hola</p>';
			$text .= '<p>Hemos recibido la postulación de tu TiNi y nos agrada confirmarte que ya está inscrita en el concurso.';
			$text .= 'A partir del 27 de noviembre, el Jurado estudiará todas las TiNis que hayan postulado y elegirá las que participen finalmente en la votación pública que comenzará el día 4 de diciembre.';
			$text .= 'Para más información, puedes consultar los detalles del Premio TiNi aquí: http://tini.com.pe/detalles-premio</p>';
			
			$text .= '<p>¡Muchas gracias y mucha suerte!<br>';
			$text .= 'El equipo de TiNi<br>';
			$text .= 'www.tini.com.pe</p>';
			
			/*'html' => '<p>FELICIDADES!!!</p><p>Ganaste el tema'.$topic.' ve a nuestro menú de temas y sigue participando</p>',*/
			$message = array(
			    'subject' => $subject,
			    'from_email' => $from,
			    'html' => $text,
			    'to' => array(array('email' => $to, 'name' => $name)),
			    'merge_vars' => array(array(
				        'rcpt' => 'recipient1@domain.com',
				        'vars' =>
				        array(
				            array(
				                'name' => 'FIRSTNAME',
				                'content' => 'Recipient 1 first name'),
				            array(
				                'name' => 'LASTNAME',
				                'content' => 'Last name')
				    ))));

			$template_name = 'test';

			$template_content = array(
			    array(
			        'name' => 'main',
			        'content' => 'Hola *|FIRSTNAME|* *|LASTNAME|*, Gracias por postular.'),
			    array(
			        'name' => 'footer',
			        'content' => 'Copyright 2012.')

			);
			//$mandrill->messages->sendTemplate($template_name, $template_content, $message);
			$data = array(
	    	               'form_field_42' => 'si'
	    	            );

	    	ee()->db->where('author_id',$id_postulante);
	    	ee()->db->update('exp_freeform_form_entries_2',$data);
			//return $email_postulante;
			return '';
		}
	}

	function send_email_registro(){
		global $TMPL;
		$this->EE =& get_instance(); // EEv2 syntax
		$TMPL = $this->EE->TMPL;

		require_once 'mailchimp-mandrill-api-php/src/Mandrill.php'; 
		$mandrill = new Mandrill('41EG-8dzZN-rtJ8GBngAFA');
		$email_postulante= $TMPL->fetch_param('email_postulante');
		$id_postulante= $TMPL->fetch_param('id_postulante');
	    $result = '';
	    ee()->db->select('m_field_id_2');
	    ee()->db->where('member_id',$id_postulante);
	    $query = ee()->db->get('exp_member_data');
	    foreach($query->result() as $row){
	        $result = $row->m_field_id_2;
	    }
	    if($result == ""){
	    	$to= $email_postulante;
	    	$name= "Administrador TiNi";
	    	$subject= "Confirmación de registro en el Premio TiNi 2014";
	    	$from= "info@aniaorg.pe";
	    	//$text = $TMPL->tagdata;
	    	
	    	$text = '';
	    	
				$text .= '<p>¡Bienvenido al Premio TiNi 2014!<br>';
				$text .= 'Hemos registrado correctamente tus datos y ya formas parte de la familia TiNi.<br>';
				$text .= 'Recuerda que para que tu TiNi participe en el concurso es necesario que completes el formulario de inscripción hasta el 24 de noviembre.<br> Accede al formulario aquí: <a href="http://tini.com.pe/index.php/postula">http://tini.com.pe/index.php/postula</a><br>';
				$text .= 'Ten en cuenta que para que todo el mundo pueda ver lo bonita que es tu TiNi, te pediremos que incluyas fotos y un video,'; 				$text .= 'así que, si aún no los tienes, usa tu cámara o móvil ¡y haz que tu TiNi luzca su mejor cara!<br>';
				$text .= 'Muchas gracias por participar en TiNi y por poner tu parte para hacer de este un mundo más sostenible.</p>';
				
				$text .= '<p>';
				$text .= 'Un abrazo,';
				$text .= 'El equipo de TiNi';
				$text .= '<a href="http://www.tini.com.pe">www.tini.com.pe</a>';
				$text .= '</p>';		
	    	
	    	$message = array(
	    	    'subject' => $subject,
	    	    'from_email' => $from,
	    	    'html' => $text,
	    	    'to' => array(array('email' => $to, 'name' => $name)),
	    	    'merge_vars' => array(array(
	    		        'rcpt' => 'recipient1@domain.com',
	    		        'vars' =>
	    		        array(
	    		            array(
	    		                'name' => 'FIRSTNAME',
	    		                'content' => 'Recipient 1 first name'),
	    		            array(
	    		                'name' => 'LASTNAME',
	    		                'content' => 'Last name')
	    		    ))));

	    	$template_name = 'test';

	    	$template_content = array(
	    	    array(
	    	        'name' => 'main',
	    	        'content' => 'Hola *|FIRSTNAME|* *|LASTNAME|*, Gracias por registrarte.'),
	    	    array(
	    	        'name' => 'footer',
	    	        'content' => 'Copyright 2012.')

	    	);
	    	$mandrill->messages->sendTemplate($template_name, $template_content, $message);
	    	$data = array(
	    	               'm_field_id_2' => 'si'
	    	            );

	    	ee()->db->where('member_id',$id_postulante);
	    	ee()->db->update('exp_member_data',$data);

	    	return '';
	    }
	}
}
// END CLASS