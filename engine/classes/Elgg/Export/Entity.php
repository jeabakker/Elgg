<?php

namespace Elgg\Export;

/**
 * Entity export representation
 *
 * @property int    $guid
 * @property string $type
 * @property string $subtype
 * @property int    $owner_guid
 * @property int    $container_guid
 * @property string $time_updated
 * @property string $url
 * @property int    $read_access
 * @property string $deleted
 * @property string $time_deleted
 */
class Entity extends Data {

	/**
	 * Get updated time
	 *
	 * @return \DateTime|null
	 */
	public function getTimeUpdated() {
		if (!$this->time_updated) {
			return null;
		}

		return new \DateTime($this->time_created);
	}
}
