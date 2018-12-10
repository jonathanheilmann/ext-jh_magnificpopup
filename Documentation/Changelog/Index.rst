.. include:: ../Includes.txt


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
         2.0.0

   :Changes:
        \* [TASK]          #62   Support TYPO3 9 LTS

 - :Version:
         1.1.0

   :Changes:
        \* [ENHANCEMENT]   #61   Link for the <figcaption>

 - :Version:
         1.0.1

   :Changes:
         \* [BUG]          #56   plugin magnificpopup for content - Inline and content-reference partial not found

         \* [BUG]          #45   In Inline-Content with option "closeBtnInside=True" the Close Button is NOT working with EDGE

         \* [DOCUMENTATION]#58   Title in Magnific Popup with EXT:fluid_styled_content

         \* [DOCUMENTATION]#54   Filter skips images when JumpURL enabled

         \* [DOCUMENTATION]#49   Not compatible to EXT:imagecycle (Added `how to`)

 - :Version:
         1.0.0

   :Changes:
         \* [BUG]          #50   Compatibility to bootstrap_package > 7 lost

         \* [ENHANCEMENT]  #47   Add compatibility to TYPO3 CMS version 8.5 and higher

         \* [TASK]               Remove unused ViewHelper `extension.loaded`

         \* [TASK]               Rewrite link rendering 

         \* [TASK]               Remove old link-setup

         \* [TASK]               Support EXT:fluid_styled_content CE `image`

         \* [TASK]               Always enable Lightbox, as it's extension's main feature

         \* [TASK]               Remove RTE support

         \* [TASK]               Update Namespace Vendor to `JonathanHeilmann`

 - :Version:
         0.6.4

   :Changes:
         \* [BUGFIX] #37   Fix translation

         \* [TASK]   #35   removalDelay is a ms value

 - :Version:
         0.6.3

   :Changes:
         \* [BUGFIX] eID fails when realurl is enabled

         \* [BUGFIX] Image filter fetch all links

 - :Version:
         0.6.2

   :Changes:
         \* [BUGFIX] Lazyload for images fails for type ajax and inline

         \* [BUGFIX] Content element fails with bootstrap_grids

         \* [BUGFIX] Wrong located typoscript

         \* [BUGFIX] image title is not shown in overlay

 - :Version:
         0.6.1

   :Changes:
         \* [BUGFIX] TYPO3 CMS 7 LTS: eID fails

 - :Version:
         0.6.0

   :Changes:
         \* [ENHANCEMENT] include composer.json

         \* [ENHANCEMENT] Make jh_magnificpopup work with fluid styled content

         \* [DOCUMENTATION] Add section "how to"

         \* [TASK] Update namespace (see Breaking changes -> Version 0.6.0)

         \* [TASK] Update Magnific Popup to version 1.1.0

         \* [TASK] Update jQuery

         \* [TASK] Update documentation

         \* Bugfixes

 - :Version:
         0.5.0

   :Changes:
         \* [TASK] Add support for TYPO3 CMS 7.6
   
         \* [TASK] Rewrite rendering of link in plugin

         \* [FEATURE] Add Link-image to plugin

         \* [FEATURE] Add link wizard to iframe-link in plugin

         \* [TASK] Update documentation

         \* [TASK] Implement PSR-2 standard

         \* [TASK] Move to GitHub

 - :Version:
         0.4.1

   :Changes:
         \* [TASK] Set Link-text length to 256 instead of 30

         \* [BUGFIX] Add missing semicolon

 - :Version:
         0.4.0

   :Changes:
         \* Added option to easy use animation effects for Magnific Popup (please see chapter Development->Animation Effects Hook)

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

