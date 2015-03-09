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


Version 0.5.0
^^^^^^^^^^^^^

| Within version 0.5.0, the rendering of link in plugin changed and thus the file "EXT:jh_magnificpopup/Resources/Private/Templates/Magnificpopup/Show.html" has been modified.
| **Please consider this if you use a locally modified version**
|
| A fallback is available, but if you want to use the new link-image, you will have to update your modified file.
| Replace this line next to the end of the file

.. code-block:: html

	<a class="{link-class}" href='{link}'>{link-text}</a>

by

.. code-block:: html

	<f:if condition="{tsLink}">
		<f:then>
			{tsLink -> f:format.raw()}
		</f:then>
		<f:else>
			<a class="{link-class}" href='{link}'>{link-text}</a>
		</f:else>
	</f:if>
