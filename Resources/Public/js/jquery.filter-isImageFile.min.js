/*! jQuery :isImageFile filter - v0.0.5 - 2014-08-21
*
* Copyright (c) 2013-2014 Jonathan Heilmann; */
(function(e){e.extend(e.expr[":"],{isImageFile:function(t){var n=e(t);var r=e("img",n);if(e(r).hasClass("excludeFromMagnificpopup")){return false}var i=n.attr("href");if(i==null){return false}i=i.toLowerCase();var s=i.substr(i.lastIndexOf(".")+1);switch(s){case"jpeg":case"jpg":case"png":case"gif":return true;break;default:return false}}})})(window.jQuery||window.Zepto);