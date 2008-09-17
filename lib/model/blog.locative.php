<?php
/// Copyright (c) 2004-2008, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)

function getLocatives($blogid) {
	return getEntries($blogid, 'id, userid, title, slogan, location', 'length(location) > 1 AND category > -1', 'location');
}
?>