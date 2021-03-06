<?php

namespace Elgg\Upgrades;

use Elgg\Database\QueryBuilder;
use Elgg\Upgrade\Result;
use Elgg\Upgrade\SystemUpgrade;

/**
 * Subscribe all content owners to their own content
 *
 * @since 4.0
 */
class ContentOwnerSubscriptions implements SystemUpgrade {

	/**
	 * {@inheritDoc}
	 */
	public function getVersion(): int {
		return 2021060401;
	}

	/**
	 * {@inheritDoc}
	 */
	public function needsIncrementOffset(): bool {
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function shouldBeSkipped(): bool {
		$methods = elgg_get_notification_methods();
		if (empty($methods)) {
			return true;
		}
		
		return empty($this->countItems());
	}

	/**
	 * {@inheritDoc}
	 */
	public function countItems(): int {
		return elgg_count_entities($this->getOptions());
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(Result $result, $offset): Result {
		
		$entities = elgg_get_entities($this->getOptions([
			'offset' => $offset,
		]));
		
		// get registered notification methods
		$methods = elgg_get_notification_methods();
		
		/* @var $entity \ElggEntity */
		foreach ($entities as $entity) {
			$owner = $entity->getOwnerEntity();
			if (!$owner instanceof \ElggUser) {
				// how did this happen
				$result->addSuccesses();
				continue;
			}
			
			if ($entity->hasMutedNotifications($owner->guid)) {
				// user already blocked notifications
				$result->addSuccesses();
				continue;
			}
			
			if ($entity->hasSubscriptions($owner->guid)) {
				// already subscribed
				$result->addSuccesses();
				continue;
			}
			
			// get user preferences
			$content_preferences = $owner->getNotificationSettings('content_create');
			$enabled_methods = array_keys(array_filter($content_preferences));
			if (empty($enabled_methods)) {
				$result->addSuccesses();
				continue;
			}
			
			// loop through all notification types
			foreach ($enabled_methods as $method) {
				// only enable supported methods
				if (!in_array($method, $methods)) {
					continue;
				}
				
				$entity->addSubscription($owner->guid, $method);
			}
			
			$result->addSuccesses();
		}
		
		return $result;
	}
	
	/**
	 * Get query options
	 *
	 * @param array $options additional options
	 *
	 * @return array
	 */
	protected function getOptions(array $options = []): array {
		$defaults = [
			'types' => ['object', 'group'],
			'limit' => 100,
			'batch' => true,
			'batch_inc_offset' => $this->needsIncrementOffset(),
			'wheres' => [
				function (QueryBuilder $qb, $main_alias) {
					$owner_guids = $qb->subquery('entities');
					$owner_guids->select('guid')
						->andWhere($qb->compare('type', '=', 'user', ELGG_VALUE_STRING));
					
					return $qb->compare("{$main_alias}.owner_guid", 'in', $owner_guids->getSQL());
				},
			],
		];
		
		return array_merge($defaults, $options);
	}
}
