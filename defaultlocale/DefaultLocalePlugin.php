<?php

namespace Craft;

class DefaultLocalePlugin extends BasePlugin {

	public function init() {
		parent::init();
		
		$defaultlocale = craft()->config->get('defaultLocale'); // Retrieve default locale from global config.
		if ($defaultlocale == null) { // Fall back to 'en_us' if no default is set in the configuration.
			$defaultlocale = 'en_us';
		}
		
		if (!craft()->isConsole() && craft()->request->isSiteRequest() && !craft()->request->isLivePreview()) { // Only for frontend requests.
			$element = craft()->getUrlManager()->getMatchedElement(); // Find the element that the current URL is going to.
			if ($element == false && craft()->language != $defaultlocale) { // No element matched, and the current locale is different from the default.

				// Find an element for the default locale, if possible.
				$oldlanguage = craft()->language; // Store the given locale, to revert to after checking.
				craft()->setLanguage($defaultlocale); // Change locale to default.
				craft()->setComponent('urlManager', new UrlManager()); // Reset the URL Manager, its internal state can't change otherwise.
				craft()->getUrlManager()->parseUrl(craft()->request); // Re-parse url to update route and target element.
				$element = craft()->getUrlManager()->getMatchedElement(); // Find the element matched with the default locale, if possible.
				craft()->setLanguage($oldlanguage); // Change locale to previous.

				if ($element != false) { // If an element with the default locale was found, check if it has a version with the original requested locale enabled, in case it has a different URL.
					$element = craft()->elements->getElementById($element->id); // Try to retrieve the element with the same ID, using the original locale.
					if ($element && $element->getStatus() == 'live') { // The element exists in the original locale and is enabled, redirect to it.
						craft()->request->redirect($element->getUrl(), true, 301);
					}
				}
			}
		}
	}

	public function getVersion() {
		return '1.0.1';
	}

	public function getSchemaVersion()
	{
		return '1.0.0';
	}

	public function getName() {
		return Craft::t('Default Locale');
	}

	public function getDescription() {
		return Craft::t('Intercepts 404 errors on non-default locales and tries to find entries with the same slug.');
	}

	public function getDeveloper() {
		return 'Charlie Development';
	}

	public function getDeveloperUrl() {
		return 'http://charliedev.com/';
	}
	
	public function getDocumentationUrl()
	{
		return 'https://github.com/charliedevelopment/Craft2-Default-Locale/blob/master/README.md';
	}
	
	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/charliedevelopment/Craft2-Default-Locale/master/release.json';
	}	
}