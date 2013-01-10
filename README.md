barberry-embedded
===============

API calls for Barberry library. Fork it if you need any project-specific features or different set of plugins.

Add file to storage
-------------------

*Request*

    $response = Barberry\Api::put($barberryConfig[, $filePath = null])
    if $filePath omitted $_FILES will be used

*Response*

    Barberry\Response object


Getting a file
--------------

To get an original file just request it by ID.

*Request*

    $response = Barberry\Api::get($barberryConfig, $id[, $filter = null]);

*Response*

    Barberry\Response object

To resize and convert image get it by ID with extension.

*Request*

    $id .= '100x150.gif';
    $response = Barberry\Api::get($barberryConfig, $id[, $filter = null])


Deleting a file
---------------

To delete an original file just delete it by ID.

*Request*

    $response = Barberry\Api::delete($barberryConfig, $id);

*Response*

    Barberry\Response object
