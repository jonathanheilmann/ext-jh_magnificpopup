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


Version 1.0.0
^^^^^^^^^^^^^

Changed namespace
"""""""""""""""""
| Namespace vendor has changed from "Heilmann" to "JonathanHeilmann".
| If you use a ViewHelper of this extension in a custom template, please update your namespace declaration.
| Actually a code migration is available, but will be removed in a later version.
| **Please consider this if you use a locally modified template**


Removed RTE support
"""""""""""""""""""
RTE support has been dropped, as this extension version focuses on TYPO3 8 LTS, which uses ckeditor.


Removed old link-setup
""""""""""""""""""""""
| Deprecated fluid template variables `link-class`, `link-text` and `link` has been removed.
| **Please consider this if you use a locally modified `Magnificpopup/Show` template**


Dropped fluid template variable `inlinecontent`
"""""""""""""""""""""""""""""""""""""""""""""""
Fluid template variable `inlinecontent` has been dropped in favour of an advanced rendering of inline and referenced
content.

In your custom template `Magnificpopup/Show` replace

```
<f:if condition="{inlinecontent}">
    <div id="{inlinecontent_id}" class="white-popup-block mfp-hide">
        {inlinecontent -> f:format.raw()}
    </div>
</f:if>
```

by

```
<f:switch expression="{settings.contenttype}">
    <f:case value="reference">
        <div id="mfp-inline-{data.uid}" class="white-popup-block mfp-hide">
            <jh:inlineContent.reference contentUids="{settings.content.reference}" />
        </div>
    </f:case>
    <f:case value="inline">
        <div id="mfp-inline-{data.uid}" class="white-popup-block mfp-hide">
            <jh:inlineContent.inline data="{data}" />
        </div>
    </f:case>
</f:switch>
```

**Please consider this if you use a locally modified `Magnificpopup/Show` template**

Removed ViewHelper `extension.loaded`
"""""""""""""""""""""""""""""""""""""
ViewHelper is not used by extension anymore. If you require this one, please consider to use EXT:vhs.
