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
 * License, use of this software will be governed by version 2
 * or later of the General Public License.
 */

namespace chat\system\message\type;

use \chat\data\message\Message;
use \chat\data\room\Room;
use \wcf\data\user\UserProfile;

/**
 * TombstoneMessageType marks a different message as dead.
 */
class TombstoneMessageType implements IMessageType {
	use TDefaultPayload;

	/**
	 * @inheritDoc
	 */
	public function getJavaScriptModuleName() {
		return 'Bastelstu.be/Chat/MessageType/Tombstone';
	}

	/**
	 * @see	\chat\system\message\type\IMessageType::canSee()
	 */
	public function canSee(Message $message, Room $room, UserProfile $user = null) {
		if ($user === null) $user = new UserProfile(\wcf\system\WCF::getUser());

		$parameters = [ 'message' => $message
		              , 'room'    => $room
		              , 'user'    => $user
		              , 'canSee'  => true
		              ];
		\wcf\system\event\EventHandler::getInstance()->fireAction($this, 'canSee', $parameters);

		return $parameters['canSee'];
	}

	/**
	 * @see	\chat\system\message\type\IMessageType::canSeeInLog()
	 */
	public function canSeeInLog(Message $message, Room $room, UserProfile $user = null) {
		return false;
	}

	/**
	 * @see»\chat\system\message\type\IMessageType::supportsFastSelect()
	 */
	public function supportsFastSelect() {
		return false;
	}
}
