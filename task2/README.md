# 2. Images & Registries

## 2.1 Get images
Pulling an imageis done using `docker pull [registry.domain/][image]`.

**Run:**
```shell
docker pull caddy:2.7.4-alpine
```

This will download the image and extract it.
It can then be used to create and start containers.
If you try to start a container using `docker run`, Docker will
automatically try to pull a missing image if possible.

**Output:**
```
2.7.4-alpine: Pulling from library/caddy
96526aa774ef: Pull complete 
37be51084fb8: Pull complete 
22d867aa37ac: Pull complete 
147aa3899aa3: Pull complete 
Digest: sha256:11ae052d9015105757d19caf86dc51fc14403841f2b65e93fe320f4d0e197385
Status: Downloaded newer image for caddy:2.7.4-alpine
docker.io/library/caddy:2.7.4-alpine
```

## 2.2 Create images
Images are defined in files called `Dockerfile`.
Images are build from layers stack one over another.
It is recommended to keep the number of layers as low as possible.
(Almost) Every statement in a Dockerfile defines a layer.

Let's build an image wit an webserver and some `index.html` file.
The webserver should be reachable from the web browser on port 8080.

**ToDo:**
1. Open `Dockerfile`
2. Use the `COPY` statement to copy the `index.html` into the container image
3. Use the `WORKDIR` statement to specify the current working directory

**Build Docker image:**

_Run:_
```shell
docker build .
```

_Output:_
```
[+] Building 0.4s (9/9) FINISHED
 => [internal] load .dockerignore                                        0.0s
 => => transferring context: 2B                                          0.0s
 => [internal] load build definition from Dockerfile.solution            0.0s
 => => transferring dockerfile: 320B                                     0.0s
 => [internal] load metadata for docker.io/library/caddy:2.7.4-alpine    0.0s
 => [1/4] FROM docker.io/library/caddy:2.7.4-alpine                      0.0s
 => [internal] load build context                                        0.0s
 => => transferring context: 317B                                        0.0s
 => [2/4] RUN mkdir -p /var/www/html                                     0.3s
 => [3/4] COPY ./index.html /var/www/html/index.html                     0.0s
 => [4/4] WORKDIR /var/www/html                                          0.0s
 => exporting to image                                                   0.0s
 => => exporting layers                                                  0.0s
 => => writing image sha256:f854c1b418df2ad77d4a8504660ce3c86c6bbca5b4352a01abd89a8edb731891
```

This outputs the ID of the newly created image.
In the example, the ID is `f854c1b418df2ad77d4a8504660ce3c86c6bbca5b4352a01abd89a8edb731891`
and can be used in `docker run <id>`.

**Start Docker container:**

_Run:_
```shell
docker run --rm -p 8080:80 <image_id>
```

_Output:_
```
{"level":"warn","ts":1696928772.6084628,"logger":"admin","msg":"admin endpoint disabled"}
{"level":"warn","ts":1696928772.608525,"logger":"http.auto_https","msg":"server is listening only on the HTTP port, so no automatic HTTPS will be applied to this server","server_name":"static","http_port":80}
{"level":"info","ts":1696928772.6085968,"logger":"tls.cache.maintenance","msg":"started background certificate maintenance","cache":"0xc0004cbd80"}
{"level":"info","ts":1696928772.6086204,"logger":"tls","msg":"cleaning storage unit","description":"FileStorage:/data/caddy"}
{"level":"info","ts":1696928772.6086543,"logger":"tls","msg":"finished cleaning storage units"}
{"level":"info","ts":1696928772.6086874,"logger":"http.log","msg":"server running","name":"static","protocols":["h1","h2","h3"]}
{"level":"info","ts":1696928772.608697,"msg":"Caddy serving static files on :80"}
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
This again outputs the ID of the newly created image.

**Start Docker container:**
```shell
docker run --rm -p 8080:80 <image_id>
```

Oh snap! The text didn't change!

Now run the `docker build .` command again, but with `--no-cache` set.
When you now start a Container with the new image, the text changed!

This is due to Docker caching unchanged image layers to improve build time.
And as you did not change the `COPY``statement, Docker doesn't copy your file again!


