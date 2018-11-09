# AngularJS Project by Lilian Gousiou

## Description

A single-page application using AngularJS. It displays information calling the Rick and Morty API and bundles all JavaScript files with Webpack.

## Installation & Running

Angular-http-server installation needed. Extra packages are included in lib folder.

`$ npm install -g angular-http-server`

Run application as in angular-http-server configuration file.

`$ angular-http-server --config angular-http-server.config.js`

It opens in a default browser automatically [localhost:8081](http://localhost:8081/), where is running the application.

## Structure
```
lilian_gousiou
├── angular-http-server.config.js
├── app
│   ├── bundle.js
│   ├── css
│   │   ├── ngDialog.css
│   │   └── style.css
│   ├── favicon.ico
│   ├── index.html
│   ├── index.js
│   ├── js
│   │   ├── config.js
│   │   ├── controller.js
│   │   └── factories.js
│   └── templates
│       ├── character.html
│       ├── characters.html
│       ├── filtering.html
│       └── paging.html
├── package.json
├── package-lock.json
├── README.md
├── webpack.config.js
├── yarn-error.log
└── yarn.lock
```

### HTML

`index.html`
Includes favicon, .css files and bundle.js.

`/templates/characters.html`
Displays characters listing page.

`/templates/character.html`
Includes character info modal content.

`/templates/filtering.html`
Displays listing page header with filtering.

`/templates/paging.html`
Displays listing page footer with paging.

### CSS

`/css/style.css`
Includes all custom css for filtering, listing, paging, modal and loader.

`/css/ngDialog.css`
Includes angularJS ngDialog css.

### JS

`/index.js`
Includes both required npm packages (angular, angular-route, ng-dialog) and custom JavaScipt files described below.

`/js/config.js`
AngularJS application module configuration, dependencies and routing.

`/js/factories.js`
Returns RESTfull API calls.

`/js/controller.js`
AngularJS controller includes listing and modal functionalities.

### Webpack

`/bundle.js`
Webpack output that bundles all JavaScript files  depended on index.js.
