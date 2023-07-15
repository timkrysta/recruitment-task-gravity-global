# Gravity Global - Recruitment Task - Frontend

## Introduction
The frontend is written in TypeScript and styles in Sass.

The table `<table id="users"></table>` is rendered dynamically using the `TableRenderer` class. Both headers and table body is rendered dynamically therefore it's flexible enough if in future we would like to add some additional field to users.json like `subscriptionStatus` etc.

## Building the application
Because I have written frontend in TS we need to compile it before it will be served and executed by the browser. To do it I have created a shorthand script in `package.json` that compiles TypeScript to JavaScript and Sass to CSS. All you need to do is run:
```sh
cd ./frontend && npm run build
```

## Author
[Tymoteusz Krysta](https://www.linkedin.com/in/tim-krysta/) - krystatymoteusz@gmail.com
