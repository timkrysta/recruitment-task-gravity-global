# Gravity Global - Recruitment Task - Frontend

## Introduction
The frontend is written in TypeScript and styles in Sass.

The table `<table id="users"></table>` is rendered dynamically using the `TableRenderer` class. Both headers and table body is rendered dynamically therefore it's flexible enough if in future we would like to add some additional field to users.json like `subscriptionStatus` etc. 

As with everything in IT, there is an alternative cost to this approach, namely SEO. The users table is probably intended for an admin panel where SEO is not important therefore I have done it this way. But if it was not intended for the admin panel use case then I would render the table on the server using PHP and serve ready HTML to the client so the crawlers would understand it better and index up higher.

## Building the application
Because I have written frontend in TS we need to compile it before it will be served and executed by the browser. To do it I have created a shorthand script in `package.json` that compiles TypeScript to JavaScript and Sass to CSS. All you need to do is run:
```sh
cd ./frontend && npm run build
```

Alternatively, you can use docker by just executing:
```sh
docker-compose up
```

## Author
[Tymoteusz Krysta](https://www.linkedin.com/in/tim-krysta/) - krystatymoteusz@gmail.com
