/*! jQuery - v0.0.1 - 2014-08-28
*
* Copyright (c) 2014 Jonathan Heilmann;
*
* SOURCE
* http://stackoverflow.com/questions/10352057/how-to-define-variables-when-jquery-is-inserted-in-the-footer
*
* CHANGELOG
* 0.0.1:	-initial release
*
*/
;(function($) {
	if (typeof mfpInlineFunctions != 'undefined') {
		$.each(mfpInlineFunctions, function(idx, func){
			func($);
		});
	}
})(window.jQuery || window.Zepto);