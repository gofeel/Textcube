// Google Map Plugin WYSISYG Helper
// - depends on EAF4.js and Google Map API v2.

function initializeGoogleMap() {
	// Nothing to do currently.
}

function GMapTool_Insert() {
	window.open(blogURL + '/plugin/GMapCustomInsert/', 'GMapTool_Insert', 'menubar=no,toolbar=no,width=550,height=650,scrollbars=yes');
}

STD.addUnloadEventListener(function() { GUnload(); });
