## Project Info
Simple blog API

## Installation
1. Clone repo
2. Build local environment with (docker)
```
$ docker-compose up -build 
$ docker-compose up -d
$ docker exec -it blogtest_app bash
$ composer install
$ cp .env.example .env
$ php bin/console doctrine:migrations:migrate 
```
And that's it! The application should be available at the following url http://localhost:8080

## API

Create new post:

**POST /api/blog/create**
```
{
    'title' => 'Text',
    'content' => 'Text',
    'image' => 'File'
}
```
---
List of posts (paginated):

**GET /api/blog?page=1&limit=10**

---
Single post:

**GET /api/blog/{id}**

## Console

Create post via console:

**php bin/console blog:create-post**
