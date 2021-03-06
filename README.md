<h6 align="center">
    <img src="https://live.staticflickr.com/65535/47047471134_cb3c38e55a_o_d.png" width="150"/>
</h6>

<h2 align="center">
    settings
</h2>

Laravel Settings package that is persistent to DB
<p align="center"> 
    <a href="https://packagist.org/packages/reecem/settings" target="_blank">
        <img class="latest_stable_version_img" src="https://poser.pugx.org/reecem/settings/version">
    </a>
    <a href="https://packagist.org/packages/reecem/settings" target="_blank">
        <img class="total_img" src="https://poser.pugx.org/reecem/settings/downloads">
    </a>
    <a href="https://packagist.org/packages/reecem/settings" target="_blank">
        <img class="latest_unstable_version_img" src="https://poser.pugx.org/reecem/settings/v/unstable">
    </a>
    <a href="https://packagist.org/packages/reecem/settings" target="_blank">
        <img class="license_img" src="https://poser.pugx.org/reecem/settings/license">
    </a>
</p>
This setting package makes use of the key-value storage method of settings.

## Installing 

Require via composer
```bash
composer require reecem/settings
```
Then install through the artisan command

```bash
php artisan settings:install
```

## updates 

when there is a new release please run `settings:update` just to refresh the published assets
```bash
php artisan settings:update
```

## Features
- Settings are cached to reduce reading time from the db
- `setting()` helper to access the settings from anywhere
- `multi.dimension.setting.array` - the settings can be saved in assoc array form
- settings can be cast to arrays, JSON or boolean from default
- WIP: encrypt the entire cached setting file

## todo
There is always something todo
- [x] add an encrypt option to individual settings
- [ ] improve the ui of the settings panel
- [ ] unit tests...

## Support
If you enjoy using the package you can support me on Ko-Fi or by paypal :smile:

<p align="center">
<a href='http://bit.ly/2J4ZPBM' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://az743702.vo.msecnd.net/cdn/kofi4.png?v=2' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>
&nbsp;
<a href='http://bit.ly/2Vw2rAb' target='_blank'><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="PayPal" /></a>
</p>
