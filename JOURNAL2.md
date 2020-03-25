## Setup passport
to install passport and use GRANT password, its really easy, no need to setup login route api at all.
just follow: https://laravel.com/docs/7.x/passport#installation
php artisan passport:client to make a client

To login/get token:
use POST to http://127.0.0.1:8000/oauth/token/
the body should have this info:
    grant_type:password
    client_id:3
    client_secret:YQPBGGChnGKjzjnirB35D7T6OBfsDEFaHSNcKPSC
    username:delilah@vimigo.my
    password:password
    scope:*

## Filter/search:
https://www.youtube.com/watch?v=3PeF9UvoSsk
https://www.youtube.com/results?search_query=Laravel+api+Pagination+with+Filters
https://www.youtube.com/watch?v=KWnmOBkHzUo

## csv import user
https://www.youtube.com/channel/UC4gijXR8cM4gmEt9Olse-TQ/search?query=inferno+%2315


## how to handle exception eg: 404 etc
https://www.youtube.com/watch?v=_mdZxG6ExbE
