

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


Plugin
^^^^^^

Create a content element with a plugin and select “Magnific Popup” or
use the wizard and select “Mapgnific Popup”.


Tab: General settings
"""""""""""""""""""""

Select "Display type" (Link, Inline-Content or Content-Reference) and "Link type" (Text or Image) introduced in version 0.5.0.

**Display type: Link**

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :Field:
         Field

   :Description:
         Description

 - :Field:
         Link text

   :Description:
         | Available if Link type is "Text":
         | The text that is displayed to the user

 - :Field:
         Link image

   :Description:
         | Available if Link type is "Image":
         | The image that is displayed to the user

 - :Field:
         Link target

   :Description:
         The Link target ( `http://www.you-domain.tld <http://www.you-
         domain.tld/>`_ ). This could be a website, a youtube-movie or
         everything else.


.. ###### END~OF~TABLE ######

**Display type: Inline-Content**

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :Field:
         Field

   :Description:
         Description

 - :Field:
         Link text

   :Description:
         | Available if Link type is "Text":
         | The text that is displayed to the user

 - :Field:
         Link image

   :Description:
         | Available if Link type is "Image":
         | The image that is displayed to the user

 - :Field:
         Method

   :Description:
         Select the way the content is loaded.Inline renders the content when
         opening the page with the link, ajax loads the content when the user
         opens the link.

 - :Field:
         Create new Page Content

   :Description:
         Create the content that should be displayed.


.. ###### END~OF~TABLE ######

**Display type: Content-Reference**

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :Field:
         Field

   :Description:
         Description

 - :Field:
         Link text

   :Description:
         | Available if Link type is "Text":
         | The text that is displayed to the user

 - :Field:
         Link image

   :Description:
         | Available if Link type is "Image":
         | The image that is displayed to the user

 - :Field:
         Method

   :Description:
         Select the way the content is loaded.Inline renders the content when
         opening the page with the link, ajax loads the content when the user
         opens the link.

 - :Field:
         Page Content

   :Description:
         Select the content that should be displayed.

.. ###### END~OF~TABLE ######


Tab: Magnific Popup settings
""""""""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :Field:
         Field

   :Description:
         Description

 - :Field:
         mainClass

   :Description:
         String that contains classes that will be added to the root element of
         popup wrapper and to dark overlay.

 - :Field:
         focus

   :Description:
         If the lightbox contains a form define the id of the field that should
         be focused when openingString with CSS selector of an element inside
         popup that should be focused. Ideally it should be the first element
         of popup that can be focused. For example 'input' or '#login-input'.
         Leave empty to focus the popup itself.

 - :Field:
         closeBtnInside

   :Description:
         If enabled, Magnific Popup will put close button inside content of
         popup.

 - :Field:
         modal

   :Description:
         When set to true, the popup will have a modal-like behavior: it won’t
         be possible to dismiss it by usual means (close button, escape key, or
         clicking in the overlay).

 - :Field:
         alignTop

   :Description:
         If set to true popup is aligned to top instead of to center.

 - :Field:
         overflowY

   :Description:
         Defines scrollbar of the popup, works as overflow-y CSS property - any
         CSS acceptable value is allowed (e.g. auto, scroll, hidden). Option is
         applied only when fixed position is enabled.

 - :Field:
         removalDelay

   :Description:
         Delay before popup is removed from DOM.


.. ###### END~OF~TABLE ######

