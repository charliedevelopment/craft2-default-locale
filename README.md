# Default Locale

*Default Locale* is a Craft CMS plugin that adds the ability to set a fallback locale for when the requested locale is disabled on an element. This allows multi-locale websites to safely have secondary locales disabled by default until translations are available.

When a request for an element would normally result in a 404 error, *Default Locale* will check if the request is for a locale different than the default one. If so, then a few things will happen:

* First, the url is used to check if there is an element that exists in the default locale with the same slug.
* If there is an element, then the element is used to check if there is actually a version available for our original locale, which can happen in the case of the default slug being used instead of a locale-specific one.
* If there is an element, and a version that exists for our original locale, then a redirect to the proper URL is sent back to the browser.
* If there is an element, but no version for our original locale, then craft continues with the default element as it would for a normal request, but with *craft's* own locale still set to the original.
* If there is no element, then the request continues as a 404 as normal.

See the flowcharts below which demonstrate what happens when requesting a page, `about-us`, in Spanish (`es`).

**Without a default locale**

![Craft routing without Default Locale](.resources/diagram/without-plugin.png)

**With a default locale**

![Craft routing with Default Locale](.resources/diagram/with-plugin.png)

## Requirements

* Craft CMS 2.x

## Installation

1. Download the latest version of *Default Locale*.
2. Move the `defaultlocale` directory into your `craft/plugins/` directory.
3. In the Craft control panel, go to *Settings > Plugins*.
4. Find *Default Locale* in the list of plugins and click the *Install* button.

## Configuration

Open `craft/config/general.php` and add a new item to the array for `defaultLocale`.

```php
return array(

	...

	'defaultLocale' => 'en_us',

	...

);
```

## Usage

While the plugin works without any additional configuration, you may want to know if an entry being displayed is actually for the requested locale or if it is being substituted by *Default Locale*. To find out, you can compare the `craft.locale` to the current `entry.locale`. See the example below where we are displaying a message if the entry was not availabe for the requested locale.

```
{% if craft.locale != entry.locale %}

	<p>Sorry, this page is only available in English.</p>

{% endif %}
```

---

*Built for [Craft CMS](https://craftcms.com/) by [Charlie Development](http://charliedev.com/)*
