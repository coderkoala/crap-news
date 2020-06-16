## Crap News Boilerplate

![CrapNewsApp](https://raw.githubusercontent.com/coderkoala/crap-news/master/public/img/Screenshot_2020-03-31%20News%20App%20Home.jpg)

A Laravel powered News website based on [Colorlib's MagNews Theme](https://colorlib.com/wp/template/magnews2/). The features it currently ships with are:

- Automated API full/fetch of News from NewsAPI Org's Endpoint
- Filter by Country/Source
- Allow Login/Registration of Users
- Users can rate existing news
- Commands for easy fetching and updating existing sources
- Export generates unique slugs based on news attributes (Author Name, Title among other things)
- Purely templatized and scalable.
- Smart Asset Management via npm/webpack

### Demo Credentials

**User:** admin@admin.com (Super Admin)
**OR:** user@user.com (Normal User)
**Password:** secret

### Official Documentation

Follow the official Laravel installation guide. Please follow the project specific documentation below. If you're confused at tackling it, [please visit laravel boilerplate documentation site](http://laravel-boilerplate.com/).

### Setup Guide

Follow Laravel's official setup guides, after that, it's pretty easy to get started. You may either utilize the SQL dump I've created of the API pulls I did for a few days, or use the artisan commands I've integrated into the app for easy population/seeding.

##### Steps

Setup NewsAPI Org's API Secret key. Paste it onto the right param under your environment file.

```
php artisan fetch sources
php artisan fetch news
```

And you're done. You should get anywhere from 1k -2k news and should be able to begin playing around with the app.

### Introduction

This is a hacky news portal website with I intend to reuse sometime later in my life. All of the assets I took were under Creative Common License. The theme is, [Colorlib's MagNews Theme](https://colorlib.com/wp/template/magnews2/). The boilerplate I used for this project is [Laravel Boilerplate](http://laravel-boilerplate.com/).

### Issues

It is riddled with issues. I'd not even dream of deploying it to a website, esp with no cron (oh gawd the nightmares. Fun fact: Did you know I managed bringing down my personal server when trying to test cron too rapidly? Yeah, don't do it.) If you have any queries or bugs to point out, feel free to lodge them in issues, and I'd be more than happy to fix it.

### Where does it go from here?

This project is nowhere near what my vision has in store for it. So expect sporadical updates, and a lot of experimentatons. I was to ship the initial Release Candidate with CRON, but it caused issues, so expect the first few updates geared towards cron.

###### Development Roadmap:

* [ ] Migration to Laravel 7.0
* [ ] Themeing package (I'm working on it separately, private for now) on blade fires to switch themes with minimal template touching.
* [ ] Database Query Optimizations, especially on front page (yikes).
* [ ] Normalizing the DB tables, building relationships between related tables (2NF+).
* [ ] Optimizing code. A lot of lazy programming is involved.
* [ ] Refactoring Controller to organized classes.
* [ ] Introducing API Controllers, introducing Passport.
* [ ] Backend Dashboard for popular news, and recent likes ( someone help me :O )
* [ ] Deprecation of Fetch News API Class in favor of an RSS feed crawling API. Generalizing the procedure so the code can be reused for any REST API calls.

More will be added as I discover the limitations of my current approach to a news portal architecture. But like I reiterate many times, expect infrequent, but large (possibly breaking) changes.

### License

[MIT](http://mit-license.org)

Copyright © 2020 [Nobel Dahal](https://nobeldahal.com.np)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
