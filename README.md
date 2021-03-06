# Elastic Universe

## Stack

-   PHP 8.1.0
-   Elasticsearch 5.6.14
-   Nginx 1.23.0

## Install

After cloning and before starting the project for the first time, from a terminal run command `make dockerize`. This will start up required containers, and install all dependencies.
it will also add default index and mappings to elastic search db.

Run `make fix-permissions` afterwards, so that all generated files can be writable.

`make-startup` command is being used when we just want to start up containers.

## API Documentation

Postman collection and documentation are stored inside the
`elastic-univese.postman_collection.json` file.
Newer versions of postman has a nice tab to present collections and view descriptions:
![](https://i.imgur.com/1zHqZ2b.png)

Additionally, there is also an online documentation, but it seems less readable:
https://documenter.getpostman.com/view/5374706/UzQvs4oX

## Run Tests

run `make test` to run unit tests, and `make generate-coverage` to generate html code coverage report, stored in `storage/app/public/build/coverage-report`
![](https://i.imgur.com/CZqt3wG.png)
