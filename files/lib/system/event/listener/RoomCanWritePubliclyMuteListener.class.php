<?php
/*
 * Copyright (c) 2010-2018 Tim Düsterhus.
 *
 * Use of this software is governed by the Business Source License
 * included in the LICENSE file.
 *
 * Change Date: 2022-11-27
 *
 * On the date above, in accordance with the Business Source
 * License, use of this software will be governed by version 3
 * or later of the General Public License.
 */

namespace chat\system\event\listener;

use \chat\data\suspension\Suspension;
use \wcf\data\object\type\ObjectTypeCache;
use \wcf\system\exception\PermissionDeniedException;
use \wcf\system\WCF;

/**
 * Denies access to muted users.
 */
class RoomCanWritePubliclyMuteListener implements \wcf\system\event\listener\IParameterizedEventListener {
	/**
	 * @see	\wcf\system\event\listener\IParameterizedEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		$objectTypeID = ObjectTypeCache::getInstance()->getObjectTypeIDByName('be.bastelstu.chat.suspension', 'be.bastelstu.chat.suspension.mute');
		if (!$objectTypeID) throw new \LogicException('Unreachable');

		$suspensions = Suspension::getActiveSuspensionsByTriple($objectTypeID, $parameters['user']->getDecoratedObject(), $eventObj);
		if (!empty($suspensions)) {
			$parameters['result'] = new PermissionDeniedException(WCF::getLanguage()->getDynamicVariable('chat.suspension.info.be.bastelstu.chat.suspension.mute'));
		}
	}
}
