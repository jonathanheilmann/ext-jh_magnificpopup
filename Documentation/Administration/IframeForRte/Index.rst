

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


Iframe for RTE
^^^^^^^^^^^^^^

Since version 0.2.2 jh\_magnificpopup supports iframes for RTE.

To enable support you will need to include static “Magnific-Popup –
Content Element (jh\_mapgnificpopup)” to your template (if not done
already) and set the magnificpopup.type.iframe.enableglobal constant
(see Configuration of Plugin).


.. important::

   In some cases EXT:bootstrap_package overrides the PageTS added by jh_magnificpopup. If you can't see the options described in "Users manual" -> "Iframe for RTE", please add the PageTS to your RootPage.


.. code-block:: typoscript

	RTE.classesAnchor {
	  externalLinkInMagnificpopup {
	    class = mfp-link external-link-new-window
	    type = url
	    image >
	    titleText = LLL:EXT:jh_magnificpopup/Resources/Private/Language/locallang.xlf:pageTSconfig.externalLinkInMagnificpopup
	  }
	  internalLinkInMagnificpopup {
	    class = mfp-link internal-link-new-window
	    type = page
	    image >
	    titleText = LLL:EXT:jh_magnificpopup/Resources/Private/Language/locallang.xlf:pageTSconfig.internalLinkInMagnificpopup
	  }
	  downloadInMagnificpopup {
	    class = mfp-link download
	    type = file
	    image >
	    titleText = LLL:EXT:jh_magnificpopup/Resources/Private/Language/locallang.xlf:pageTSconfig.downloadInMagnificpopup
	  }
	}

	RTE.default.proc.allowedClasses := addToList(mfp-link external-link-new-window, mfp-link internal-link-new-window, mfp-link download)
	RTE.default.classesAnchor := addToList(mfp-link external-link-new-window, mfp-link internal-link-new-window, mfp-link download)

	RTE.default.buttons.link.properties.class.allowedClasses := addToList(mfp-link external-link-new-window, mfp-link internal-link-new-window, mfp-link download)
