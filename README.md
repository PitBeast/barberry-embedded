barberry-embedded
===============

API calls for Barberry library. Fork it if you need any project-specific features or different set of plugins.

Add file to storage
-------------------

*Request*

    $response = Barberry\Api::put($barberryConfig, $filePath)

*Response*

    Barberry id


Getting a file
--------------

To get an original file just request it by ID.

*Request*

    $response = Barberry\Api::get($barberryConfig, $id);

*Response*

    Binary object or null for non exist objects

Deleting a file
---------------

To delete an original file and clear cache just delete it by ID.

*Request*

    $response = Barberry\Api::delete($barberryConfig, $id);

*Response*

    true or false
