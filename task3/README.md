# Docker Compose



### Get images
Pulling an imageis done using `docker pull [registry.domain/][image]`.

```shell
docker pull nginx:latest
```

### Create images
Images are defined in files called `Dockerfile`.
Every statement in a Dockerfile defines a layer.

**Build Docker image:**
```shell
docker build .
```
This outputs the ID of the newly created image.

**Start Docker container:**
```shell
docker run --rm -p 8080:80 <image_id>
```

Visit the page on `http://localhost:8080`!

### Change something!
Do some change in the `index.html`.
For exmaple, change "Webserver" to "Caddy".

Now build the image again and run the container!
You have to rebuild it, as the file is stored in the image.

**Build Docker image:**
```shell
docker build .
```
This outputs the ID of the newly created image.

**Start Docker container:**
```shell
docker run --rm -p 8080:80 <image_id>
```

Oh snap! The text didn't change!

Now run the `docker build .` command again, but with `--no-cache` set.
When you now start a Container with the new image, the text changed!

This is due to Docker caching unchanged image layers to improve build time.
And as you did not change the `COPY``statement, Docker doesn't copy your file again!


