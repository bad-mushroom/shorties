# Shorties URL Shortener

This is an example app for a URL shortener called "Shorties".

* Laravel 10
* php 8.3
* Docker / Sail
* Composer
  
<img width="320" alt="screenshot_main" src="https://github.com/bad-mushroom/shorties/assets/381203/2baf598d-b250-4a6f-b12c-da172b4c5f4b">
<img width="320" alt="screenshot_analytics" src="https://github.com/bad-mushroom/shorties/assets/381203/841564fd-074f-488e-aa23-258cd517ac90">


## Getting Started

Follow these steps to get Shorties running locally.

### Code Base

First thing is to clone this repo. Make sure to replace `./shorties` with your chosen path.

```
git clone https://github.com/bad-mushroom/shorties ./shorties
```

We're using the Laravel 10 framework here so there's some dependencies we need to pull in.

```
cd ./shorties
composer install
```

Composer should have copied `.env.example` to `.env` but if that processed didn't run you can do it manually.

```
# Windows
copy .env.example .env

# Mac | Linux
cp .env.example .env
```

### Container Environment

This guide will assume you have Docker installed.

* [Click here to install Docker for Windows](https://docs.docker.com/desktop/install/windows-install/)
* [Click here to install Docker for Mac](https://docs.docker.com/desktop/install/mac-install/)

For ease of development, Shorties is using Laravel's Sail wrapper for Docker. You should not need to configure and environment variables though you do need to set an encryption key. For now, just "up" the containers.

Note: Make sure you don't have any other containers running as they may interfere.

```
vendor/bin/sail up -d
```

Set your encryption key for Laravel

```
vendor/bin/sail artisan key:generate
```

All set! You should be able to run Shorties locally by visiting [http://localhost](http://localhost)


## Development Notes

### Automated Tests

There's a couple of automated tests you can run to ensure core functionality is working.

Feature Tests for verifying overall, end-to-end, behavior:

```
vendor/bin/sail test tests/Feature/ShortyTest.php
```

and Unit Tests for testing individual methods:

```
vendor/bin/sail test tests/Unit/Services/ShortyTest.php
```

### Code Notes

#### Service Class

Most of the heavy lifting is being done by a service class called `Shorty` in `app\Services\Shorty\`. I choose this approach to limit complexity in the implementing code and isolating the functionality so it can easily be expanded on with minimal impact to the code base.

There's a facade for accessing the service, also called `Shorty`.
* `Shorty::create()` - to create a new short URL
* `Shorty::lookup()` - to lookup an existing short URL
* Etc... see class for details

#### Redirecting

I wanted to keep the looking up of the short code and redirect simple for performance and not introduce its own controller. I created a single route that takes a "short code" parameter:

http://localhost/{short-code}

#### Configuration

There are some configuration options in `config/shorties.php` that can be overridden via .env variables. These values could easily have been added as class properties but consolidating them here gives us a place to expand customization for future features.

#### Misc

For a quick "it looks fine" experience, I went with Bootstrap 5 and kept the out-of-the box styles.

The `/analytics` endpoint can also be accessed as an API request by passing an `Accept: application/json` header:

```
curl --location 'http://localhost/analytics' --header 'Accept: application/json'
```

In the project root there's an `example.csv` with some valid and invalid URLs to test with.

## Conclusion

Overall this was a fun project to work on and I appreciate the reviewer's time!

### If time were endless

* Add authentication to allow user-owned short URLs (since right now they are all "public") :fire:
* Give short codes their own domain instead of everything shared on localhost. shor.ty :thinking:
* Doing a final review, I realized I did not paginate the analytics data. :sad:
* Through out the code I commented where improvements and "nice to haves" could be added
* Would be nice to have seeded some sample data to work with

