# Rick & Morty Character listing

**Description:**

Using this api: https://rickandmortyapi.com/documentation Create a single-page application, using Rick and Morty public API, to list all the characters. Use vanilla es5/es6 with a view library of your choice. 
ReactJS is highly recommended for the view layer. 
Display the information however you like. Don't be afraid to use beautiful colors and a tidy layout. Be creative.
<br />
## Required Features:
- Listing of all Rick & Morty show characters limited to 20 items per page.
- Simple "Previous" and "Next" buttons for pagination.
- Filtering functionality: I want to be able to filter characters by Gender, Species, and Status, using 3 separate dropdown components, one for each filter. 
- By clicking on the character, I should see a popup box with the full information of that single character. 
- Simple routing. The app should be able to push the selected filters into browser's URL using the History API, so when a user refreshes or shares the URL, he gets the filters pre-selected upon landing. example `/characters?gender=Male&Status=alive`
- The listing items should include All character information (species, gender, origin etc) & the character images

## Coding Standards:
Use these coding standards: https://github.com/airbnb/javascript

## Notes:
- You can either use a NodeJS server or create a serverless html file.
- Don't forget to import all the necessary libraries / transpilers !
- Prefer es6 code. You can use stage-0 tc39 proposals.
- Simple webpack setup with babel/sass loaders is recommended.
- You can upload your working code on websites like https://codepen.io to show off your work


## Bonus:
- Use SASS
- Handling of unhandleded promise rejections
- Normalize JSON data
- Use redux store
- Simple assertion tests
- Make the layout responsive
