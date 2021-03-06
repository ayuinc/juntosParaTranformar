<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('SITE_NAME', 'juntosparatransformar');

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://".$_SERVER['HTTP_HOST'].'/';
//$base_url .= "://".$_SERVER['HTTP_HOST'].'/';
$admin_url  = $base_url . '/admin.php';

$config['index_page'] = "";
/*
|--------------------------------------------------------------------------
| ExpressionEngine Config Items
|--------------------------------------------------------------------------
|
| The following items are for use with ExpressionEngine.  The rest of
| the config items are for use with CodeIgniter, some of which are not
| observed by ExpressionEngine, e.g. 'permitted_uri_chars'
|
*/
$config['site_url'] = $base_url ;

$config['app_version'] = '293';
$config['license_contact'] = '';
$config['license_number'] = '4630-2858-5276-6671';
$config['debug'] = '1';
$config['cp_url'] = $config['site_url'].'/admin.php';
$config['doc_url'] = 'http://ellislab.com/expressionengine/user-guide/';
$config['is_system_on'] = 'y';
$config['allow_extensions'] = 'y';
$config['cache_driver'] = 'file';
$config['cookie_prefix'] = SITE_NAME.'_';
$config['cookie_httponly'] = 'y';

$config['server_path'] = FCPATH;

$config['site_index'] = '';
$config['theme_folder_url'] = $config['site_url']."/themes/";
$config['theme_folder_path'] = $config['server_path']."themes";
$config['save_tmpl_files'] = "y";
$config['tmpl_file_basepath'] = $config['server_path']."templates";
$config['avatar_url'] = $config['site_url']."/images/avatars/";
$config['avatar_path'] = $config['server_path']."images/avatars/";
$config['photo_url'] = $config['site_url']."/images/member_photos/";
$config['photo_path'] = $config['server_path']."images/member_photos/";
$config['sig_img_url'] = $config['site_url']."/images/signature_attachments/";
$config['sig_img_path'] = $config['server_path']."images/signature_attachments/";
$config['prv_msg_upload_path'] = $config['server_path']."images/pm_attachments/";

$config['captcha_path'] = $config['server_path']."images/captchas/";
$config['captcha_url'] = $config['site_url']."/images/captchas/";


// END EE config items

$config['upload_preferences'] = array(
    2 => array(                                                            // ID of upload destination
        'name'        => 'Coders',                          // Display name in control panel
        'server_path' => $config['server_path'].'images/coders/', // Server path to upload directory
        'url'         => $config['site_url'].'images/coders/'      // URL of upload directory
    ),
    3 => array(                                                            // ID of upload destination
        'name'        => 'Homepage',                          // Display name in control panel
        'server_path' => $config['server_path'].'images/homepage/', // Server path to upload directory
        'url'         => $config['site_url'].'images/homepage/'      // URL of upload directory
    ),
    1 => array(                                                            // ID of upload destination
        'name'        => 'Team',                          // Display name in control panel
        'server_path' => $config['server_path'].'images/team/', // Server path to upload directory
        'url'         => $config['site_url'].'images/team/'      // URL of upload directory
    ),
    4 => array(                                                            // ID of upload destination
        'name'        => 'Customers',                          // Display name in control panel
        'server_path' => $config['server_path'].'images/customers/', // Server path to upload directory
        'url'         => $config['site_url'].'images/customers/'      // URL of upload directory
    ),
    5 => array(                                                            // ID of upload destination
        'name'        => 'Cases',                          // Display name in control panel
        'server_path' => $config['server_path'].'images/cases/', // Server path to upload directory
        'url'         => $config['site_url'].'images/cases/'      // URL of upload directory
    ),
    6 => array(                                                            // ID of upload destination
        'name'        => 'jobs',                          // Display name in control panel
        'server_path' => $config['server_path'].'images/jobs/', // Server path to upload directory
        'url'         => $config['site_url'].'images/jobs/'      // URL of upload directory
    )
);

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of "AUTO" works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'AUTO'			Default - auto detects
| 'PATH_INFO'		Uses the PATH_INFO
| 'QUERY_STRING'	Uses the QUERY_STRING
| 'REQUEST_URI'		Uses the REQUEST_URI
| 'ORIG_PATH_INFO'	Uses the ORIG_PATH_INFO
|
*/
$config['uri_protocol']	= 'AUTO';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
*/
$config['charset'] = 'UTF-8';


/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'EE_';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the
| default system/expressionengine/logs/ directory. Use a full server path
| with trailing slash.
|
| Note: You may need to create this directory if your server does not
| create it automatically.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the
| default system/expressionengine/cache/ directory. Use a full server path
| with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class or the Sessions class with encryption
| enabled you MUST set an encryption key.  See the user guide for info.
|
*/
$config['encryption_key'] = '';


/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = TRUE;


/* End of file config.php */
/* Location: ./system/expressionengine/config/config.php */

$config['email_newline'] = "\r\n"; 
$config['email_crlf'] = "\r\n";
