.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Global Ajax
^^^^^^^^^^^

Available since version 0.3.0:

With the global ajax option enabled (plugin.tx_jhmagnificpopup.type.ajax.enableglobal) and eID for method ajax enabled (plugin.tx_jhmagnificpopup.useEidForAjaxMethod), it's possible to open every content-link in a Magnific Popup lightbox.

To enable the lightbox for a content-link add class "mfp-ajax-link".


Building a content-link
"""""""""""""""""""""""

To open content by ajax in a lightbox the link requires the following additionalParams:

.. t3-field-list-table::
 :header-rows: 1

 - :Param:
         Param

   :Value:
         Value

   :Description:
         Description

 - :Param:
         eID

   :Value:
         jh_magnificpopup_ajax

   :Description:
         Required - do not touch this

 - :Param:
         jh_magnificpopup[type]

   :Value:
         reference

   :Description:
         "reference" should be the default jh_magnificpopup[type]. "reference" is available too but should only used by jh_mafgnificpopup. Please see "Hook" below if you want to add your own type.

 - :Param:
         jh_magnificpopup[uid]

   :Value:
         \

   :Description:
         Comma-seperated lists of tt_content uids (required for jh_magnificpopup[type]=reference).

 - :Param:
         jh_magnificpopup[pid]

   :Value:
         \

   :Description:
         Comma-seperated lists of tt_content pids the uids are related to (required for jh_magnificpopup[type]=reference).

 - :Param:
         jh_magnificpopup[hookConf]

   :Value:
         \

   :Description:
         A string or array for your own configurations, if you use a hook with your own type.



Example
~~~~~~~
::

	http://example.com/index.php?eID=jh_magnificpopup_ajax&jh_magnificpopup[type]=reference&jh_magnificpopup[uid]=1,2,14&jh_magnificpopup[pid]=1,4


Extend Ajax
~~~~~~~~~~~
If you want to add your own type to be opend as ajax see chapter Development->Ajax Hook