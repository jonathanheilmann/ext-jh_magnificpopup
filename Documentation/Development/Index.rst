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


Development
-----------


Hooks
^^^^^

Hooks will be used for any non-exbase code.

An Extension to demonstrate the usage of the hooks is available in TER (Extension-key jh_magnificpopup_hookexamples)

Available hooks
"""""""""""""""

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   AjaxHook/Index
   AnimationEffectsHook/Index


Signal-Slot-Dispatcher
^^^^^^^^^^^^^^^^^^^^^^

The Signal-Slot-Dispatcher is the extbase way of giving the opportunity to have some custom methods called at a certain process. Signals will be used for extbase-code.

Available signals
"""""""""""""""""

.. container:: ts-properties

  ===================================================== ============================================================ =================================
  Class                                                 Method                                                       Parameter
  ===================================================== ============================================================ =================================
  MagnificpopupController                               showAction                                                   data, settings, viewAssign
  ===================================================== ============================================================ =================================

**data**: Data from contentObject (known as cObj), used by the extension

**settings**: Settings of the extension, global settings from TypoScript and local settings from plugin are merged already

**viewAssign**: Array that will be assigned to the fluid tempalte