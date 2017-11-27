<?php

namespace Craft;

class DefaultLocaleVariable {
	
	/**
	 * A helper function for determining if a given entry is globally enabled, ignoring locale status.
	 * @param entry The entry to check.
	 * @return True if the entry is enabled, regardless of the locale status, false if not.
	 */
	public function isEnabled($entry) {
		// Using entry.status takes into account whether or not the local is enabled, but entry.enabled only tells us the global status, and disregards start/end dates.
		// This will use the global status, combined with checking the start and end dates, to determine if the entry is actually available or not, while disregarding the locale's own status.
		return $entry->enabled && ($entry->postDate == null || $entry->postDate->getTimestamp() <= time()) && ($entry->expiryDate == null || $entry->expiryDate->getTimestamp() > time());
	}
}