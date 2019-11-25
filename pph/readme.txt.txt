----Documentation on how to install this webApp----

****Basic****
*	First of all we have to install Laravel App. 
*	After the installation on the root of the webApp we need to run the below command
		composer require laravelcollective/html
*	Then we have to run the sql file which is included in the e-mail.
*	Then we have to make the setUp in the .env file to make the connection with Database.

*	We need to visit https://www.weatherbit.io/account/create a free account.
*	After logging in we need to copy the Master API Key and paste it in the "apiKey" field in \config\sources\SourcesProvider.php
	(Note: API Key Provisioning may take up to 30 minutes)
	
***System***

*	In the C:\Windows\System32\drivers\etc\hosts we need to add a new line like below
	127.0.0.1 pph.test
* In the C:\xampp\apache\conf\extra\httpd-vhosts.conf we need to add the follow lines
	<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/pph/public"
    ServerName pph.test
	ErrorLog "logs/pph.test.log"
	</VirtualHost>
*	Restart xampp or wamp server.

**webApp**
*	Created a filesController just to upload the file from the weatherBit.
*	You can find it in pph.test/files/admin.
*	It is a demo just for the upload of the file which is stored in path_to_app\pph\files
*	The webApp is ready for the next day forecast.


*What I did not like in my webApp*

*	The UI is not really good. I am not the best player using HTML and CSS.
*	I used Laravel. I much better in Yii 1.1 but it is deprecated. So i choosed Laravel(self educated). I think i did not use every power Laravel can provide me.
*	Back-end validation for the fields. I did not used validation on Request object on my Ajax call. I understood it right now(almost 23.00).
*	I did not use Docker(But i am keen on Docker)


