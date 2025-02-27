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

namespace chat\system\command;

use \chat\data\room\Room;
use \chat\data\suspension\SuspensionAction;
use \chat\system\permission\PermissionHandler;
use \wcf\data\object\type\ObjectTypeCache;
use \wcf\data\user\UserProfile;
use \wcf\system\exception\PermissionDeniedException;
use \wcf\system\WCF;

/**
 * The unmute command revokes a new be.bastelstu.chat.suspension.mute suspension.
 */
class UnmuteCommand extends AbstractUnsuspensionCommand implements ICommand {
	/**
	 * @inheritDoc
	 */
	public function getJavaScriptModuleName() {
		return 'Bastelstu.be/Chat/Command/Unmute';
	}

	/**
	 * @inheritDoc
	 */
	public function isAvailable(Room $room, UserProfile $user = null) {
		if ($user === null) $user = new UserProfile(WCF::getUser());
		return $user->getPermission('mod.chat.canMute') || PermissionHandler::get($user)->getPermission($room, 'mod.canMute');
	}

	/**
	 * @inheritDoc
	 */
	public function getObjectTypeName() {
		return 'be.bastelstu.chat.suspension.mute';
	}

	/**
	 * @inheritDoc
	 */
	protected function checkPermissions($parameters, Room $room, UserProfile $user) {
		$permission = $user->getPermission('mod.chat.canMute');

		if (!$this->isGlobally($parameters)) {
			$permission = $permission || PermissionHandler::get($user)->getPermission($room, 'mod.canMute');
		}

		if (!$permission) throw new PermissionDeniedException();
	}
}
