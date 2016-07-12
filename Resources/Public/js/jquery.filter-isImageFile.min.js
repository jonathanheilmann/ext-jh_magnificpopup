/*! jQuery :isImageFile filter - v0.0.6 - 2016-07-12
*
* Copyright (c) 2013-2016 Jonathan Heilmann; */
!function(e){e.extend(e.expr[":"],{isImageFile:function(r){var a=e(r);if(a.hasClass("excludeFromMagnificpopup"))return!1;var n=a.attr("href");if(null==n)return!1;n=n.toLowerCase();var t=n.substr(n.lastIndexOf(".")+1);switch(t){case"jpeg":case"jpg":case"png":case"gif":return!0;default:return!1}}})}(window.jQuery||window.Zepto);