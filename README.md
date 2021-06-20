# Candidate tests
- [Frontend test project](README-FRONTEND.md)
- [Backend test project](README-BACKEND.md)
- [Backend API test](README-BE-WEATHER.md)

### Process

Fork this repo, and clone it on your local environment <br />
`git clone git@github.com:<your-github-username>/candidate-tests.git`
<br />
<br />
Enter the created folder<br />
`cd ./candidate-tests`
<br />
<br />
Create a branch named after your fullname <br/>
`git checkout -b yourfullname`
<br />
<br />
When you are done please commit your code and push your branch
<br />
```
git add . 
git commit -m 'Enter your commit comment here'
git push origin yourfullname
```
<br />
<br />
And then create a pull request from your repository `<your-github-username>/candidate-tests` branch to `PeoplePerHour/candidate-tests/master` branch.
<br />
Just don't forget to send us a message that you have committed your code.

### Things to avoid
- Long PRs, code must be as simpler as it could be.
- Over-complicated
- Over-engineered
- Copy-pasting code from other libraries, without fully understanding what it does.
- Not asking for clarification. If something is unclear please go ahead and ask us.

**Important Note**: If you need any clarification, please create a new issue and we will respond asap.

## Do your magic!

-----------------------------------------------

How to run my test using docker:
1. Build the Dockerfile, running ./build.sh
2. Run localy, using run.sh
3. Either install composer depedencies running composer install locally - or remotely, by attaching a shell onto the running image.
4. Enter 0.0.0.0:8001 to make app requests.

How to run without docker
1. Install composer depedencies running composer install locally.
2. Run the php dev server against the public code folder.
3. Enter 0.0.0.0:8001 to make app requests

For our demo purposes, you may find the exact .env file i used in development, on .development.env at the root of my project code folder.
Please, rename to .env for the application to run.

How to use the api:
1. By entering either a combination of lon/lat coordinates or city.
2. By entering an additional parameter. Supported parameters are lang and units (expecting same values as per weatherbit specification).
3. Api stores same pattern requests for an hour to save brandwidth.


A little bit about the demo app and what i took into consideration:
1. My app, is based on lumen framework. A simple and lightweight PHP framework, building small services and apis.
2. This API, doesn't incorporate all the features of a complete API (such as universal response classes, deep linking etc). It has all it needs, for a mock start API service in a demo-test environment.
3. It is fault-tolerant in mind.
4. It follows the PSR-12 specs.
5. It caches responses on a hourly basis
6. It has a typical logging when needed to monitor the api requests (both succesful and those with service warnings)


How to test some basic scenarios:
You may explore my tests @ code/tests/WeatherbitTest.php
To run the tests, simply run ./vendor/bin/phpunit


