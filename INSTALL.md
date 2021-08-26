# Character-Listing Template for Rick & Morty API

This project is the test project for listing the characters from the backend api (node/express).

- Front end is react/redux with CoreUI theme.
Used the history package to remember the navigation.
Used the node-sass for style.
It has functions for filtering and pagination for characters list.
The main page is fully responsive.

- Backend is node/express.
Integrated the api for the pagination and fetching character's list and filtering.
Backend is now using json data.


## Installation

``` bash

# install app's dependencies
$ npm install
```


Create .env file to your project folder and then,

Config Frontend Project Port: PORT=xxxx


### Basic usage

``` bash
# serve backend for API at first
$ npm run serve

This API using GET method, so can access and test at http://localhost:3001

# frontend dev server with hot reload at http://localhost:xxxx
$ npm run start
```

Navigate to [http://localhost:xxxx](http://localhost:xxxx). The app will automatically reload if you change any of the source files.

### Build

Run `build` to build the project. The build artifacts will be stored in the `build/` directory.

```bash
# build for production with minification
$ npm run build
```

## What's included

Within the download you'll find the following directories and files, logically grouping common assets and providing both compiled and minified variations. You'll see something like this:

```
Character-Listing-Template
├── public/                     #static files
│   └── index.html              #html template
│
├── server/                     #backend API root
│   ├── data/                   
│   │   ├── characters.js       #data provider
│   │   ├── charactersData.js   #character data source
│   │   └── index.js      
│   └── routes.js               #backend routes config
│       ├── character.js        #route config for character
│       ├── health.js           #route config for ping
│       └── ...      
├── src/                        #frontend project root
│   ├── assets/                 #assets - js icons object
│   ├── containers/             #container source - template layout
│   │   ├── _nav.js             #sidebar config
│   │   └── ...      
│   ├── scss/                   #user scss/css source
│   ├── views/                  #views source
│   ├── App.js
│   ├── App.test.js
│   ├── polyfill.js
│   ├── history.js
│   ├── index.js
│   ├── routes.js               #routes config
│   └── store.js                #template state example 
│
├── package.json
│
└── server.js                   #backend app entry
```

## Copyright and License

copyright 2021 creativeLabs Denis Tuktarov.
