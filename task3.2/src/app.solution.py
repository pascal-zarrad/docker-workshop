import time

import redis
from flask import Flask

app = Flask(__name__)
# 3. The host does not seem valid. How might be the hostname of other services
#    in a compose stack?
cache = redis.Redis(host='redis', port=6379)

def get_hit_count():
    retries = 5
    while True:
        try:
            return cache.incr('hits')
        except redis.exceptions.ConnectionError as exc:
            if retries == 0:
                raise exc
            retries -= 1
            time.sleep(0.5)

@app.route('/')
def hello():
    count = get_hit_count()
    return 'Hello Test! I have been seen {} times.\n'.format(count)
