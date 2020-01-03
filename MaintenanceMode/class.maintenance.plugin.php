<?php
/**
 * Maintenance Plugin
 *
 * Puts an overlay on your site, in order that no User interaction can happen.
 * Extremely useful if you need to make some maintenance in the background,
 * without wanting to take the whole site offline.
 *
 * @author Oliver Raduner <vanilla@raduner.ch>
 * @link https://open.vanillaforums.com/addon/maintenancemode-plugin
 * @link https://github.com/oliveratgithub/vanillaforums-MaintenanceMode
 *
 * @version 3.3
 * @since 1.0 13-JAN-2011 Oliver Raduner <vanilla@raduner.ch> Plugin class added
 * @since 1.2 Oliver Raduner <vanilla@raduner.ch> Minor enhancements
 * @since 1.3 06-JAN-2014 TienerForums <https://github.com/TienerForums> Translated for Dutch added
 * @since 3.3 03-JAN-2020 Oliver Raduner <vanilla@raduner.ch> Compatibilitiy with Vanilla Release 3.3
 */
class MaintenanceModePlugin extends Gdn_Plugin
{
	/** @var bool */
	var $isAdmin;

	/**
	 * Class constructor
	 */
	public function __construct($sender = '') {
		parent::__construct($sender, 'plugins/MaintenanceMode');
		$this->isAdmin = Gdn::session()->checkPermission('Garden.Settings.Manage');
	}

	/**
	 * Hack the Base Render in order to display the Maintenance notice in the frontend only
	 * 
	 * @version 2.0
	 * @since 1.0 13-JAN-2011 Oliver Raduner <vanilla@raduner.ch> Method added
	 * @since 1.2 Oliver Raduner <vanilla@raduner.ch> Excluded Admin pages from the Maintenance overlay
	 * @since 2.0 03-JAN-2020 Oliver Raduner <vanilla@raduner.ch> Changed output of CSS to a .css-File & updated head inject
	 */
	public function Base_Render_Before($sender)
	{
		/** Cast a message popup for site managers */
		if ($this->isAdmin) $sender->informMessage(Anchor(T('MaintenanceModeOn'), '/settings/plugins/enabled#maintenancemode-addon'), ['dissmissable' => false]);

		/** Don't display Maintenance overlay anywhere in the Admin area... */
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
		if (InArrayI($sender->ControllerName, $AdminAreas)) return;

		/** Add the custom CSS styles to the Head */
		if ($this->isAdmin !== true) $sender->addCssFile('maintenancemode.css', 'plugins/MaintenanceMode');
	}

	/**
	 * Hack the Base Body output in the bottom (after whole page is there)
	 *
	 * @version 2.0
	 * @since 1.0 13-JAN-2011 Oliver Raduner <vanilla@raduner.ch> Method added
	 * @since 1.0 13-JAN-2011 Oliver Raduner <vanilla@raduner.ch> Minor enhancements
	 * @since 2.0 03-JAN-2020 Oliver Raduner <vanilla@raduner.ch> Reworked HTML output
	 */
	public function Base_AfterBody_Handler($sender)
	{
		/** For Admins / Site Managers, do not show the regular Maintenance overlay */
		if ($this->isAdmin) return;

		/** Display the maintenance notice for all other users & visitors */
		//$sender->render($this->getView('notice.php')); // DISABLED due to Loop in rendering output
		$html = '<div id="maintenance-wrapper">
					<div id="maintenance-notice">
						<h4>'.T('MaintenanceNotice').'</h4>
						<a href="'.Url('/').'dashboard/settings"><small>&rarr; Site Settings</small></a>
					</div>
				</div>';
		echo $html;
	}

	/**
	 * Initialize things when enabling plugin
	 *
	 * @version 1.0
	 * @since 1.0 13-JAN-2011 Oliver Raduner <vanilla@raduner.ch> Method added
	 */
	public function Setup() { }

	/**
	 * Cleanup stuff upon disabling the plugin
	 *
	 * @version 1.0
	 * @since 1.0 03-JAN-2020 Oliver Raduner <vanilla@raduner.ch> Method added
	 */
	public function OnDisable() { }
}
