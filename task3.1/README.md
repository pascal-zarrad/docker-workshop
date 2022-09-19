# Docker Compose

You got a basic docker-compose.yaml with a single service called "web".
Unfortunately, this service is missing its port configuration, bind mounts.

Also Caddy requires the "file-server" argument to serve files!

ToDo:
 1. Map port 80 in the Caddy container to port 8080 on the host!
 2. Use a bind mount to mount the `index.html` in the container to the path `/var/www/html/index.html`!
 3. Update the command for the container to be "caddy file-server"!

After doing `docker-compose up` you should be able to access the started webserver at `localhost:8080`.  
