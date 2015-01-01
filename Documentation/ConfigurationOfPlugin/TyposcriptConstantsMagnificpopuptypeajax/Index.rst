

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


TypoScript Constants – magnificpopup.type.ajax
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This constants-array is used for Display type “Content-Reference” and
“Inline-Content” with Method “ajax”. Some important constants may be
overwritten inside the plugin-setup by flexform-settings.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:

   Data type
         Data type:

   Description
         Description:

   Default
         Default:


.. container:: table-row

   Property
         enableglobal

   Data type
         boolean

   Description
         Makes the ajax Magnific Popup available on every page.

   Default
         0


.. container:: table-row

   Property
         ajax.cursor

   Data type
         string

   Description
         CSS class that will be added to body during the loading (adds
         "progress" cursor)

   Default
         mfp-ajax-cur


.. container:: table-row

   Property
         disableOn

   Data type
         int+

   Description
         Path to the Magnific Popup javascript file. Leave empty to include no
         javascript.

   Default
         0


.. container:: table-row

   Property
         mainClass

   Data type
         string

   Description
         Path to the Magnific Popup css file. Leave empty to include no
         css.String that contains classes that will be added to the root
         element of popup wrapper and to dark overlay

   Default
         \


.. container:: table-row

   Property
         preloader

   Data type
         boolean

   Description
         Preloader in Magnific Popup is used as an indicator of current status.
         If option enabled, it’s always present in DOM only text inside of it
         changes.

   Default
         1


.. container:: table-row

   Property
         focus

   Data type
         string

   Description
         String with CSS selector of an element inside popup that should be
         focused. Ideally it should be the first element of popup that can be
         focused. For example 'input' or '#login-input'. Leave empty to focus
         the popup itself.

   Default
         \


.. container:: table-row

   Property
         closeInContentClick

   Data type
         boolean

   Description
         Close popup when user clicks on content of it. It’s recommended to
         enable this option when you have only image in popup.

   Default
         0


.. container:: table-row

   Property
         closeOnBgClick

   Data type
         boolean

   Description
         Close the popup when user clicks on the dark overlay.

   Default
         1


.. container:: table-row

   Property
         closeBtnInside

   Data type
         boolean

   Description
         If enabled, Magnific Popup will put close button inside content of
         popup.

   Default
         0


.. container:: table-row

   Property
         showCloseBtn

   Data type
         boolean

   Description
         Controls whether the close button will be displayed or not.

   Default
         1


.. container:: table-row

   Property
         enableEscapeKey

   Data type
         boolean

   Description
         Controls whether pressing the escape key will dismiss the active popup
         or not.

   Default
         1


.. container:: table-row

   Property
         modal

   Data type
         boolean

   Description
         When set to true, the popup will have a modal-like behavior: it won’t
         be possible to dismiss it by usual means (close button, escape key, or
         clicking in the overlay).

   Default
         0


.. container:: table-row

   Property
         alignTop

   Data type
         boolean

   Description
         If set to true popup is aligned to top instead of to center.

   Default
         0


.. container:: table-row

   Property
         fixedContentPos

   Data type
         string

   Description
         Options defines how popup content position property. Can be "auto",
         true or false. If set to true - fixed position will be used, to false
         - absolute position based on current scroll. If set to "auto" popup
         will automatically disable this option when browser doesn’t support
         fixed position properly.

   Default
         auto


.. container:: table-row

   Property
         fixedBgPos

   Data type
         string

   Description
         Same as fixedContentPos, but it defines position property of the dark
         transluscent overlay. If set to false - huge tall overlay will be
         generated that equals height of window to emulate fixed position. It’s
         recommended to set this option to true if you animate this dark
         overlay and content is most likely will not be zoomed, as size of it
         will be much smaller.

   Default
         auto


.. container:: table-row

   Property
         overflowY

   Data type
         string

   Description
         Defines scrollbar of the popup, works as overflow-y CSS property - any
         CSS acceptable value is allowed (e.g. auto, scroll, hidden). Option is
         applied only when fixed position is enabled.

   Default
         auto


.. container:: table-row

   Property
         removalDelay

   Data type
         int+

   Description
         Delay before popup is removed from DOM.

   Default
         0


.. container:: table-row

   Property
         closeMarkup

   Data type
         string

   Description
         Markup of close button.

   Default
         <button title="%title%" class="mfp-close"><i class="mfp-close-
         icn">&times;</i></button>


.. ###### END~OF~TABLE ######

