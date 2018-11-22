.. include:: ../Includes.txt


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

Title in Magnific Popup with EXT:fluid_styled_content
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Add this single line to your template-setup to display the image title as title in Magnific Popup:

.. code-block:: typoscript

    lib.fluidContent.settings.media.popup.linkParams.ATagParams.dataWrap = class="{$styles.content.textmedia.linkWrap.lightboxCssClass}" rel="{$styles.content.textmedia.linkWrap.lightboxRelAttribute}" title="{file:current:title}"

Custom title in Magnific Popup
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The way the Magnific Popup title is customized depends on styling extension used by your website.

EXT:fluid_styled_content
""""""""""""""""""""""""
No how to available yet


Open original images instead of processed
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
If you want to show the "original image" you have to change the source-parameter for link-generating:

Actual:

.. code-block:: typoscript

    tt_content.image.20.1.imageLinkWrap.enable.ifEmpty.typolink.parameter.data = file:current:link

New (for opening the original images)

.. code-block:: typoscript

    tt_content.image.20.1.imageLinkWrap.enable.ifEmpty.typolink.parameter.data = file:current:publicUrl
    tt_content.image.20.1.imageLinkWrap.typolink.parameter.data = file:current:publicUrl


Link to original image in image title
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
In file `Templates/TypoScript/Default.html` replace

.. code-block:: typoscript

    titleSrc: 'title',

by

.. code-block:: typoscript

    titleSrc: function(item) {
        return item.el.attr('title') + ' &middot; <a href="'+item.src+'" target="_blank">view original image</a>';
    },


EXT:imagecycle
^^^^^^^^^^^^^^

EXT:imagecycle modifies default TypoScript setup, thus these lines are required:

.. code-block:: typoscript

    tt_content.image.20.1.imageLinkWrap.JSwindow = 0
    tt_content.image.20.default.1.imageLinkWrap.JSwindow = 0

    tt_content.image.20.1.imageLinkWrap.directImageLink = 1
    tt_content.image.20.default.1.imageLinkWrap.directImageLink = 1


EXT:jumpurl
^^^^^^^^^^^

EXT:jumpurl is deprecated and thus not supported natively. But you may modify a local copy of
`Resources/Public/js/jquery.filter-isImageFile.js` and set Constant
`plugin.tx_jhmagnificpopup.includeFilterIsImageFileJs` to your local copy path.

Just add

.. code-block:: javascript

    extension = extension.substr(0, (extension.lastIndexOf('&')));

after line 23. A full version is available here: `https://gist.github.com/jonathanheilmann/3e6e21559a0850450a366a67546a33c4 <https://gist.github.com/jonathanheilmann/3e6e21559a0850450a366a67546a33c4>`_
