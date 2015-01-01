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


ChangeLog
---------

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :Version:
         Version

   :Changes:
         Changes

 - :Version:
         0.4.0

   :Changes:
         \* Added option to easy use animation effects for Magnific Popup (please see chapter Developer->Animation Effects Hook)

         \* Added Signal for showAction

         \* Added support for RTE click-enlarge

         \* Added support for image lazyload for EXT:bootstrap_package when loading content by ajax

         \* [BREAKING CHANGE] Moved JavaScript from controller to template

         \* [ALPHA] Link to CE and load by ajax for RTE

 - :Version:
         0.3.2

   :Changes:
         \* Updated category of constants to naming conventions

         \* Fixed paths to Templates, Partials and Layouts

         \* Fixed bug #62716 (missing semicolon at the end of *.min.js files)

 - :Version:
         0.3.1

   :Changes:
         \* Improved documentation

         \* Improved Ajax Hook


 - :Version:
         0.3.0

   :Changes:
         \* Added TypoScript to use global Magnific Popup type ajax

         \* Added eID for Magnific Popup type ajax

         \* Moved default selector for images from fluidtemplate to typoscript

         \* Added instruction to use Magnific Popup for whole page (Support #61002)


 - :Version:
         0.2.8

   :Changes:
         \* Ignore images with class "excludeFromMagnificpopup" in jQuery image filter

         \* Inline-Content did not work if jQuery has been included in footer

         \* Fixed a bug in tceMain hook

 - :Version:
         0.2.7

   :Changes:
         \* fixed bug #59696 (filter-isImageFile doesn't work with UpperCase Filetype)

 - :Version:
         0.2.6

   :Changes:
         \* BREAKING CHANGES for global images and iframe (see manual chapter "Breaking Changes" of documentation for more information)

         \* Moved translation to XLIFF

         \* Added fully support for Zepto

         \* Removed jQuery.noConflict for isImageFile-filter

         \* Fixed a bug that broke inline-content

         \* Added support for bootstrap_packages (used by "The official Introduction Package")

         \* Moved javascript libraries to JSFooterlibs

 - :Version:
         0.2.5

   :Changes:
         \* Magnific Popup as content-element is now stable (now problems known)

         \* Updated dependencies: works with TYPO3 CMS 6.2

 - :Version:
         0.2.4

   :Changes:
         \* Added jpeg to image-filter

         \* Fixed task #55368

         \* Updated manual to ReST

 - :Version:
         0.2.3

   :Changes:
         \* Updated manual

         \* Added support-advice for TYPO3 CMS < 6.0

 - :Version:
         0.2.2

   :Changes:
         \* Added Extension Configuration in manual

         \* Fixed some violations (
         `https://metrics.typo3.org/dashboard/index/org.typo3:extension-
         jh\_magnificpopup <https://metrics.typo3.org/dashboard/index/org.typo3
         :extension-jh_magnificpopup>`_ )

         \* Fixed a bug that broke the closeBtnInside of inline and ajax
         elements

         \* Added Magnific Popup to RTE

         \* Fixed bug #51300

 - :Version:
         0.2.1

   :Changes:
         \* Same as 0.2.0, but with dependencies

 - :Version:
         0.2.0

   :Changes:
         \* Added Plugin – still BETA

         \* Updated Magnific Popup to version 0.9.9

         \* Introduced some breaking changes, please see manual for more
         information.

         \* Dropped Support for TYPO3 CMS 4.5

         \* Updated manual

 - :Version:
         0.1.2

   :Changes:
         \* Fixed Bug #51300 for TYPO3 CMS 4.5-4.7

         \* Updated Magnific Popup to version 0.9.9

 - :Version:
         0.1.1

   :Changes:
         \* Fixed Bug #51081: Installation causes a Fatal error and crashed the
         TYPO3 installation (4.5.x)

 - :Version:
         0.1.0

   :Changes:
         \* Added support for EXT:news and EXT:tt\_news

         \* Updated manual

 - :Version:
         0.0.2

   :Changes:
         \* Added Extension-Icon

         \* Changes in constants: mistake in writing of
         “includeMagnificpopupJs” and “includeMagnificpopupCss” (please control
         your constants when updating)

         \* Updated manual

 - :Version:
         0.0.1

   :Changes:
         \* Initial release


.. ###### END~OF~TABLE ######

