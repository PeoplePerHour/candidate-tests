# Rick & Morty Character listing

**Description:**

Using this api: https://rickandmortyapi.com/documentation Create a single-page application, using Rick and Morty public API, to list all the characters. Use vanilla es5/es6 with a view library of your choice. 
ReactJS is highly recommended for the view layer. 
Display the information however you like. Don't be afraid to use beautiful colors and a tidy layout. Be creative.  

## For Fullstack developers
Instead of using the api , create your own api (only the characters endpoint with pagination and filtering) in whatever framework you want (or core PHP) using the data from this json file [ricknmorty.json.zip](https://github.com/PeoplePerHour/candidate-tests/files/7030686/ricknmorty.json.zip)

## Required Features:
- Listing of all Rick & Morty show characters limited to 20 items per page.
- Simple "Previous" and "Next" buttons for pagination.
- Filtering functionality: I want to be able to filter characters by Name, and Gender. 
- Simple routing. The app should be able to push the selected filters into browser's URL using the History API, so when a user refreshes or shares the URL, he gets the filters pre-selected upon landing. example `/characters?gender=Unknown`
- The listing items should include All character information (species, gender, origin etc) & the character images

## Coding Standards:
Use these coding standards: https://github.com/airbnb/javascript

## Notes:
- You can either use a NodeJS server or create a serverless html file.
- Don't forget to import all the necessary libraries / transpilers !
- Prefer ES6 code. You can use stage-0 TC39 proposals.
- Simple webpack setup with babel/sass loaders is recommended.
- You can upload your working code on websites like https://codepen.io to show off your work

## Bonus:
- Use SASS
- Handling of unhandled promise rejections
- Normalize JSON data
- Use Redux store
- Simple assertion tests
- Make the layout responsive
- (For fullstack devs) dockerize the app 
