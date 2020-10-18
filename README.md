# Basic Symfony  setup with docker-sync


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