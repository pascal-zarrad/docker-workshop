# Multiple services
Running a single webserver is often not enough.
Let's create a dynamic web application that counts vists!

This should bring some light into networking with Docker and Docker compose.
Also, this should provie some insights into common Docker compose commands.

First of all, take a look at the docker-compose.yaml.

ToDo:
 1. Remmber building the Docker image in task 2? Now do it again, but configure it in `docker-compoe.yaml`. 
 2. Something is missng for Redis. Be sure to put your containers in the same network!
 3. Our web service needs to connect to Redis. Check the `app.py`. Seems like the hostname has been replaced with `?????`!
 4. Even if we'd start now. There would be no code. Remeber how the `index.html` got bind mounted in the last task?

After the steps have been solved, you can start the stack:
```shell
docker-compose up
```

You can also start daemonized:
```shell
docker-compose up -d
```

But you will have to stop it manually:
```shell
docker-compose stop
```

If you're done, destroy the containers:
```shell
docker-compose down -v
```
`-v` also destroys named volumes.
There are no named volumes in the stack, but its good to know the parameter.
