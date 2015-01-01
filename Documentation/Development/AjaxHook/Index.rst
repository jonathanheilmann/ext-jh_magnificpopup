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


Ajax Hook
^^^^^^^^^

(Available since version 0.3.0)

Use this hook if you want to add your own type to be opend as ajax lightbox.

Required and available link-parameters:


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
         \

   :Description:
         Required: The type your hook is build for.

 - :Param:
      jh_magnificpopup[hookConf]

   :Value:
         \

   :Description:
         Optional: A string or array for your own configurations



Include and register your class like this in your ext_localconf.php:

.. code-block:: php

	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['jh_magnificpopup']['EidTypeHook'][] = 'EXT:mx_extension_key/Classes/Hooks/EidTypeHook.php:Vendor\ExtensionName\Hooks\EidTypeHook->ajax';


The function should return a result structured like this:

.. code-block:: php

	array(
		'matchedType'	=>	boolean,
		'name'			=>	cObjectName,
		'conf'			=>	array(
			cObjextProperty	=>	cObjectValue
		),
		'wrap'			=>	string,
	)

Description:

**machtedType**: Set to TRUE if your hook matches the type, all other hooks will be skipped.

**name**: For a list of supportet cObject Names please see http://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Index.html

**conf**: For configuration of the cObject please see http://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Index.html

**wrap**: By default the lightbox is not wrapped. The default wrap for tye inline and reference is "<div class="white-popup-block">|</div>"

Example
"""""""

Link:

::

	http://example.com/index.php?eID=jh_magnificpopup_ajax&jh_magnificpopup[type]=simple_text_example&jh_magnificpopup[hookConf]=aString

Hook:

.. code-block:: php

  /**
   * EidTypeHook
   */
  class EidTypeHook {

      /**
       *
       *
       * @param array $params params required by hook
       * @param mixed $obj reference of $this
       * @return array
       */
      public function ajax(&$params, $obj) {
          $conf = array('matchedType' => FALSE);
          if ($params['type'] == 'simple_text_example') {
              $conf = array(
                  'matchedType' => TRUE,
                  'name'	=> 'TEXT',
                  'conf'	=> array(
                      'value'	=> 'This is an easy example. Passed hookConf: ' . $params['hookConf'],
                  ),
                  'wrap'	=> '<div class="white-popup-block">|</div>',
              );
          }
          return $conf;
      }
  }

This will return a lighbox with content-text: "This is an easy example. Passed hookConf: aString"

For a working demonstration please see EXT:jh_magnificpopup_hookexamples and appropriated documentation.