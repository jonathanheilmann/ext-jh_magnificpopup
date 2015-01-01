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


Animation Effects Hook
======================

(Available since version 0.4.0)

Use this hook if you want to add your own animation effects to the Magnific Popup lightbox by adding a new mainClass.

Please use animation wisely and when it’s really required. Do not enable it when your popup may contain large image or a lot of HTML text.

General
-------

In general you will have to add some CSS to you page (maybe by TypoScript).
CSS examples could be found here: http://codepen.io/dimsemenov/pen/GAIkt

For Images
----------

To use an effect for the image-lightbox you will have to add the class (for example "mfp-zoom-in") to constant plugin.tx_jhmagnificpopup.magnificpopup.mainClass in Constant Editor. (Please make shure to add only one animation effect, otherwise the lightbox fails.)

For Plugin
----------

Actually there are two ways to register a new animation effect by adding mainClass:

#. adding some PageTS
#. using two hooks in an extension

1. Adding some PageTS
^^^^^^^^^^^^^^^^^^^^^

The faster way is to add two new lines to your PageTS (for zoom in effect):

.. code-block:: typoscript

	tx_jhmagnificpopup.mainClass.zoom = mfp-zoom-in
	tx_jhmagnificpopup.removalDelay.zoom = 500

tx_jhmagnificpopup.mainClass.zoom declares the class to be used for the animation effect. Whereas "zoom" will be selectable in selector-box mainClass in plugin FlexForm.

tx_jhmagnificpopup.removalDelay.zoom declares a removalDelay of 500ms to the lighbox. Whereas "zoom" will be selectable in selector-box removalDelay in plugin FlexForm.

1. Using two hooks in an extension
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

More complexive is to use a hook in your own extension.

Register your hooks like this:

.. code-block:: php

	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['jh_magnificpopup']['mainClass'][] = 'EXT:mx_extension_key/Classes/Hooks/MainClass.php:Vendor\ExtensionName\Hooks\MainClass->animationEffectName';
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['jh_magnificpopup']['removalDelay'][] = 'EXT:mx_extension_key/Classes/Hooks/MainClass.php:Vendor\ExtensionName\Hooks\removalDelay->animationEffectName';

The first hook should return an array like this:

.. code-block:: php

	array($animationTitle, $cssClassName)

The seconde hook should return an array like this:

.. code-block:: php

	array($animationTitle, $removalDelay)

After this your animation effect is available in FlexForm.

For a working demonstration please see EXT:jh_magnificpopup_animation.