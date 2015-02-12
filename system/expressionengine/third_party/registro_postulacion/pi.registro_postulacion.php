<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Memberlist Class
 *
 * @package     ExpressionEngine
 * @category        Plugin
 * @author      Gianfranco Montoya 
 * @copyright       Copyright (c) 2014, Gianfranco Montoya
 * @link        http://www.ayuinc.com/
 */

$plugin_info = array(
    'pi_name'         => 'Registro postulación',
    'pi_version'      => '1.0',
    'pi_author'       => 'Gianfranco Montoya',
    'pi_author_url'   => 'http://www.ayuinc.com/',
    'pi_description'  => 'Registra datos para la postulación del concurso TiNi',
    'pi_usage'        => Registro_postulacion::usage()
);
            
class Registro_postulacion
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
        Este puglin realiza el registro empleando esta tag raiz
            {exp:registro_postulacion}
            <?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
    // END

    public function registrar_cliente(){
        $marca=ee()->TMPL->fetch_param('marca');
        $modelo=ee()->TMPL->fetch_param('modelo');
        $version=ee()->TMPL->fetch_param('version');
        $precio=ee()->TMPL->fetch_param('precio');
        $ano_auto=ee()->TMPL->fetch_param('ano');
        $res_ci=ee()->TMPL->fetch_param('res_ci');
        $perd_robo=ee()->TMPL->fetch_param('perd_robo');
        $perd_choque=ee()->TMPL->fetch_param('perd_choque');
        $da_propios=ee()->TMPL->fetch_param('da_propios');
        $data = array(
            'dni'=>ee()->TMPL->fetch_param('dni') ,
            'name'=>ee()->TMPL->fetch_param('name') ,
            'surname'=>ee()->TMPL->fetch_param('surname') ,
            'email'=>ee()->TMPL->fetch_param('email'),
            'phone'=>ee()->TMPL->fetch_param('phone'),
            'ano_auto' => $ano_auto,
            'auto_id'=>$auto,
            'seguro_id'=>$seguro
            );
        if(ee()->db->insert('exp_clientes_seguros', $data)){
            return '<p class="thanks-msg">TU COTIZACIÓN HA SIDO ENVIADA A:</p>';
        }
        else{
            return "";
        }
    }
} 
/* End of file pi.registro.php */
/* Location: ./system/expressionengine/third_party/registro/pi.registro.php */