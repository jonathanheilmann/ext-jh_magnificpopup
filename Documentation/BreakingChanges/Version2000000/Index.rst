.. include:: ../../Includes.txt


Version 2.0.0
^^^^^^^^^^^^^

Dropped support of dedicated styling extensions
"""""""""""""""""""""""""""""""""""""""""""""""
As supporting multiple styling extensions like css_styled_content, fluid_styled_content and bootstrap_package and their
dedicated versions, support of these extensions has been dropped.
Instead of that EXT:jh_magnificpopup provides it's own styles to solve this.
If you adapted the old extensions templates, please read next passage "Compatibility mode".


Compatibility mode
""""""""""""""""""
As the templates has been reworked, there may be some breaking changes with your custom template adaptions.
To make your life easier, there is a compatibility mode, which will activate the old processing of data before passing
them to the template. Also the old paths will be used.

To enable compatibility mode set `plugin.tx_jhmagnificpopup.compatibilityMode` in Constant Editor category
`PLUGIN.TX_JHMAGNIFICPOPUP`

eID
"""
Usage of eID (ajax hooks) is marked as deprecated and will be removed in EXT:jh_magnificpopup version 3.0.0 as usage is
not as simple and popular as expected.
If you still require support, please contact me.
