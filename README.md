# Basic Symfony 5 setup with docker-sync

Example of using `docker-sync` for developing a symfony application on OSX.

Running the example
---

Create a symfony project under the symfony dir

https://symfony.com/doc/current/best_practices.html#use-the-symfony-binary-to-create-symfony-applications

```
$ make start
$ make composer-install
```

If everything went okay, then the app should be listening on `http://localhost:8500`

Once the app is upp and running, you need to run the workers

```
make workers
```
To stop the app

```
$ make stop
 ```

To run the tests

```
$ make test
```