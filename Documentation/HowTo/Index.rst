

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


How to
------

Add some more youtube patterns
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
With this modification, Magnific Popup supports some more youtube links like playlists and shorten youtu.be URLs

Add the setup of this gits to your template-setup:
`https://gist.github.com/jonathanheilmann/5cf63a9b92eb63d602b6be0525d2181d <https://gist.github.com/jonathanheilmann/5cf63a9b92eb63d602b6be0525d2181d>`_


Powermail in Magnific Popup
^^^^^^^^^^^^^^^^^^^^^^^^^^^
This modifications will try to open a powermail form in Magnific Popup.

See `https://gist.github.com/jonathanheilmann/c75e139cf1e630f3125c <https://gist.github.com/jonathanheilmann/c75e139cf1e630f3125c>`_ for detailed introductions.


Custom title in Magnific Popup
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The way the Magnific Popup title is customized depends on styling extension used by your website.

EXT:css_styled_content
""""""""""""""""""""""
This example adds the image-title and original image filename as title to Magnific Popup:

#. Create file "fileadmin/[...]/jh_magnificpopup/Templates/TypoScript/Default_filename.html" (replace [...] by your custom location-path)
#. Edit created file and add content of this gist (file "Default_filename.html"): `https://gist.github.com/jonathanheilmann/20bc6bd3649976f479ca#file-default_filename-html <https://gist.github.com/jonathanheilmann/20bc6bd3649976f479ca#file-default_filename-html>`_
#. Add content of this gist (file "setup.txt") to your template-setup (replace [...] by your custom location-path): `https://gist.github.com/jonathanheilmann/20bc6bd3649976f479ca#file-setup-txt <https://gist.github.com/jonathanheilmann/20bc6bd3649976f479ca#file-setup-txt>`_

To add other image-properties, line 5 and 6 of setup.txt should be adapted, and thus the javascript in line 21 to 36 should be adapted, too.

EXT:fluid_styled_content
""""""""""""""""""""""""
No how to available yet


Open original images instead of processed
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
If you want to show the "original image" you have to change the source-parameter for link-generating:

Actual:

```
tt_content.image.20.1.imageLinkWrap.enable.ifEmpty.typolink.parameter.data = file:current:link
```

New (for opening the original images)

```
tt_content.image.20.1.imageLinkWrap.enable.ifEmpty.typolink.parameter.data = file:current:publicUrl
tt_content.image.20.1.imageLinkWrap.typolink.parameter.data = file:current:publicUrl
```


Link to original image in image title
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
In file `Templates/TypoScript/Default.html` replace

```
titleSrc: 'title',
```

by

```
titleSrc: function(item) {
    return item.el.attr('title') + ' &middot; <a href="'+item.src+'" target="_blank">view original image</a>';
},
```


EXT:imagecycle
^^^^^^^^^^^^^^

EXT:imagecycle modifies default TypoScript setup, thus these lines are required:

```
tt_content.image.20.1.imageLinkWrap.JSwindow = 0
tt_content.image.20.default.1.imageLinkWrap.JSwindow = 0

tt_content.image.20.1.imageLinkWrap.directImageLink = 1
tt_content.image.20.default.1.imageLinkWrap.directImageLink = 1
```
