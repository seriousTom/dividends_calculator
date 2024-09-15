#Dividend calculator (backend)

**This is the backend of the Dividend Calculator project. The frontend can be found [here](https://github.com/seriousTom/dividends_calculator_front)**

## About Dividend calculator

It's a dummy project that I built to learn Nuxt JS, Docker and deployment stuff in general. I came with an idea when I was filling received dividends for keeping companies stocks to excel and I didn't find how to display some statistics. I thought I can make project for it and probably I will finish it unlike other side projects because it would be useful for me.

Any feedback about what might be improved would be appreciated.

##How to start project

###Using docker-compose

1. Git clone both frontend and backed repositories into the same folder next to each other like that your_folder/dividends_calculator and your_folder/dividends_calculator_front (if your change folders name then you will have to edit docker-compose file too).
    - Frontend repository [here](https://github.com/seriousTom/dividends_calculator_front)
    - Backend repository [here](https://github.com/seriousTom/dividends_calculator)
2. Navigate to backend project and run `cp .env.example .env` or just rename .env.example to .env
3. Specify desired database name, username and password (DB_DATABASE, DB_USERNAME, DB_PASSWORD) values in .env
4. Run `docker-compose up -d` command in the backend project. It will install both backend and frontend projects.
5. Run these commands for the backend:
    - `docker exec -it dividends_calculator_web /bin/bash -c "composer install"`
    - `docker exec -it dividends_calculator_web /bin/bash -c "php artisan key:generate"`
    - `docker exec -it dividends_calculator_web /bin/bash -c "php artisan migrate"`
    - `docker exec -it dividends_calculator_web /bin/bash -c "php artisan passport:keys"`
    - `docker exec -it dividends_calculator_web /bin/bash -c "php artisan passport:install"`
    - `docker exec -it dividends_calculator_web /bin/bash -c "php artisan db:seed"`
6. Navigate to frontend project and run `cp .env.example .env` or just rename .env.example to .env.
