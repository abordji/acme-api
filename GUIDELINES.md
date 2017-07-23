# Guidelines

Develop in PHP a small REST API with JSON output without
framework nor library.

1. This API must provide a way to:
    * retrieve an user (id, name, email) according to its identifier
    * retrieve a track (id, name, duration) according to its identifier

2. This API must provide a way to:
    * retrieve the favorite tracks of an user
    * add a track to the favorites
    * remove a track from the favorites

You must keep in mind that the API may be able to evolve
(new types of output, new attributes in objects, new objects ...).
You have at your disposal a MySQL database.
