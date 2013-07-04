<?php if (!defined('APPLICATION')) exit();

/**
 * Define the plugin:
 */
$PluginInfo['MaintenanceMode'] = array(
	'Name'			=> 'Maintenance Mode',
	'Description'	=> 'Puts your Site in maintenance state - so you can make modifications, backups, etc.',
	'Version'		=> '1.3',
	'Author'		=> 'Oliver Raduner',
	'AuthorEmail'	=> 'vanilla@raduner.ch',
	'AuthorUrl'		=> 'http://raduner.ch/',
	'License'		=> 'Free',
	'RequiredPlugins' => FALSE,
	'HasLocale'		=> TRUE,
	'RegisterPermissions' => FALSE,
	'SettingsUrl'	=> FALSE,
	'SettingsPermission' => FALSE,
	'MobileFriendly' => TRUE,
	'RequiredApplications' => array('Vanilla' => '>=2.0.9')
);


/**
 * Maintenance Plugin
 *
 * Puts an overlay on your site, in order that no User interaction can happen.
 * Extremely useful if you need to make some maintenance in the background,
 * without wanting to take the whole site offline.
 *
 * @version 1.3
 * @since 1.0
 * @date 13-JAN-2011
 * @author Oliver Raduner <vanilla@raduner.ch>
 * 
 * @Todo Integrate working "locales" of the Maintenance Notice to the Plugin...
 */
class MaintenanceModePlugin extends Gdn_Plugin
{
	
	/**
	 * Hack the Base Render in order to achieve our goal
	 * 
	 * @version 1.2
	 * @since 1.0
	 */
	public function Base_Render_Before($Sender)
	{
		// Don't display Maintenance overlay anywhere in the Admin area...
		$AdminAreas =  array(	'DashboardController',
								'SettingsController',
								'PluginsController',
								'ImportController',
								'MessageController',
								'RoleController',
								'RoutesController',
								'SetupController',
								'UserController',
								'AuthenticationController',
								'UtilityController',
								'EntryController');
		if (InArrayI($Sender->ControllerName, $AdminAreas)) return;
		
		// Define the CSS to display the maintenance overlay
		$CustomCss = '
			<style type="text/css">
			html { height: 100%; background: url("'.C('Garden.WebRoot').$this->GetResource("images/maintenance.png", FALSE, FALSE).'") no-repeat center 0%; margin: 0; }
			body { visibility:hidden; overflow:hidden; text-align:center; }
			div#maintenance {
				position:absolute;
				visibility: visible;
				display: block;
				left: 50%;
				margin-left: -150px;
				width: 320px;
				top: 300px;
				color: #777;
				font-weight: bold;
				font-size: 14pt;
			}
			#maintenance small { font-size: 8pt; font-weight: normal; }
			</style>
		';
		
		// Add the custom CSS styles to the Head
		$Sender->Head->AddString($CustomCss);
	}
	
	
	/**
	 * Hack the Base Body output in the bottom (after whole page is there)
	 *
	 * @version 1.2
	 * @since 1.0
	 */
	public function Base_AfterBody_Handler($Sender)
	{
		// Make a new div to display the maintenance notice
		echo '<div id="maintenance">'.T('MaintenanceNotice').'<br />
		<a href="'.Url('/').'dashboard/settings"><small>→ Site Settings</small></a></div>';
	}
	
	
	/**
	 * Initialize anything
	 *
	 * @version 1.0
	 * @since 1.0
	 */
	public function Setup() {  }	

}