Maintenance Mode addon
=============================
## for Vanilla Forums
### The original maintenance mode addon for Vanilla Forums.
### Puts your Site into a maintenance state - so you can take care of upgrades, modifications, backups, etc.

When activated, an overlay is being displayed on your site, in order to prevent any User interaction.

Useful for situations where you need to make maintenance work in the background, without wanting to take the whole site offline.

### Download & installation
* Download & extract the addon's ZIP file
* Copy the folder `MaintenanceMode` into your Vanilla's `/plugin/`-directory
* Log in & browse to the Settings-Page in your Vanilla Forum: `myforum.com/settings/plugins/`
* Enable the listed "Maintenance Mode"-addon. BOOM, your Forum now displays a Maintenance notice!

#### Vanilla Forums version support
The current version of this addon is developed & tested with Vanilla Forums 3.3.

However, chances are high, that it will also run on previous versions.
If you want to try, simply adjust or remove the following lines from the `addon.json`-file after download:

```
    "require": {
        "vanilla": ">=3.0",
        "dashboard": ">=3.0"
    }
```

### Locales & changing notice text
The addon supports the following languages out of the box:

* English
  * English (US)
  * English (CA)
* Dutch
* French
* German

If you want to have a different Maintenance notice, edit the matching "locale" file inside the addons's `/locale/`-directory.

### Don't like the maintenance image?
You can replace the default image by putting any file named `maintenance.png` inside the addon's `/design/`-folder.

### Links
* Addon page: [Maintenance Mode](https://open.vanillaforums.com/addon/maintenancemode-plugin) on open.vanillaforums.com
* GitHub project: [oliveratgithub/vanillaforums-MaintenanceMode](https://github.com/oliveratgithub/vanillaforums-MaintenanceMode)
