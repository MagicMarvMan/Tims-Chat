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

define([ './Action', '../../console' ], function (Action, console) {
	"use strict";

	const DEPENDENCIES = [ 'UiInput' ]
	class WhisperAction extends Action {
		constructor(input) {
			super()

			this.input    = input
		}

		onClick(user, event) {
			if (!event.target.dataset.trigger) {
				console.warn('[WhisperAction]', `Missing trigger`)
				return
			}

			const sanitizedUsername = user.username.replace(/"/g, '""')
			const command = `/${event.target.dataset.trigger} "${sanitizedUsername}" `

			this.input.insertText(command, { append: false, prepend: true })
			this.input.focus()
		}
	}
	WhisperAction.DEPENDENCIES = DEPENDENCIES

	return WhisperAction
});
