# First setup

https://docs.docker.com/desktop/install/mac-install/
(intel chip)

## Only first time!
### In project directory run:
```
docker network create cinema_api
docker-compose up --build
```
it may take a long time

### open new terminal and run:
```
docker exec -it cinema_api_php composer install
docker exec -it cinema_api_php php bin/console doctrine:migrations:migrate
```

### your application is running at **8080** port

## each time to start the application, only one command needs to be executed:
```
docker-compose up
```

### to stop docker containers press on terminal:
```ctrl + c```

## Endpoints
* GET http://localhost:8080/api/movies - list of movies
* POST http://localhost:8080/api/movies - create new movie
* POST http://localhost:8080/api/movies/{id} - update movie
* DELETE http://localhost:8080/api/movies/{id} - delete movie


* GET http://localhost:8080/api/rooms - list of rooms
* POST http://localhost:8080/api/rooms - create new room
* POST http://localhost:8080/api/rooms/{id} - update room
* DELETE http://localhost:8080/api/rooms/{id} - delete room


* GET http://localhost:8080/api/shows - list of shows
* POST http://localhost:8080/api/shows - create new show
* DELETE http://localhost:8080/api/shows/{id} - delete show


* POST http://localhost:8080/api/shows/{id}/buyTicket - buy ticket for show


* POST http://localhost:8080/api/app/clear-database - clear data base