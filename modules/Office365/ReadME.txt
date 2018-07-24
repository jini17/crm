REad ME for OFFICE365 Rest Api for Vtiger 7


Register and configure the app ON OFFICIAL WEB


1.Sign into the App Registration Portal using either your personal or work or school account.
  https://apps.dev.microsoft.com

2.Select Add an app under Converged applications.

3.Enter a name for the app, and select Create application.

The registration page displays, listing the properties of your app.

4.Under Platforms, select Add platform.

5.Select Web.

6.Add the following to the list of Redirect URIs:
 {base_url}/modules/Office365/authorize.php

7.Under Application Secrets click Generate New Password.

8.Copy the New password generated and Application Id, you'll need them in the next section.

9.Click Save.

10. Copy your ID and secret put on config.php in modules/office365/connectors/config.php

Configure on libraries on office365-api-php-client 
****** CONTACTS ONLY******
contacts in modules/office365 did not use any libraries just refer to  the official office365 api contacts and u should be able to understand 

/***********END CONTACTS*************
*******************************************CALENDAR ONLY****************************************************************************************************
1. The libraries for office365 is using platform of library google-api-php-client
*to understand how the libraries work please refer to official google-api-php-client. Please understand the workflow before editing this libraires.

this configuration will only cover on how u can add other events parameter in office365.
eg:meeting attendence or etc.

2. Redirect to {base_url}/libraries/office-api-php-client/src/Google/Service.

* please refer to official https://docs.microsoft.com/en-us/previous-versions/office/office-365-api/api/version-2.0/use-outlook-rest-api 
before adding new parameter , if u going to add new class into this api-php-client make sure u understand the workflow of official google-api-php-client rest API.

for adding new parameter in existing Class example:

if u are going to add something in Events 
*noted that Events Class is already exist.

refer to this for Events 
*https://docs.microsoft.com/en-us/previous-versions/office/office-365-api/api/version-2.0/calendar-rest-operations#sync-events

EXAMPLE:GET EVENTS INSTANCES
each instances must have this,
METHODS 	: "GET"
URL		:"https://outlook.office.com/api/v2.0/me/events/{event_id}" 
PARAMETER	: name : "event_id"
		  type : "string"

so in code will be like this when in office-api-php-client
see line 228 in Calendar.php
'INSTANCE NAME U RE GOING TO PUT' => array(
                  'path' => '/me/events/{eventId}',*{URL} * why only me/events/{eventId}?? read google-api-client documentation in official page.
                  'httpMethod' => 'GET',{methods}
                  'parameters' => array(
                      'eventId' => array({parameter}
                          'location' => 'path',
                          'type' => 'string',{parameter type}
                          'required' => true,
                      ),
                  ),
              ),



for parameter, the existing parameter type is 
1.string (calendar_id,eventId) *other than this u need to add new .
2.datetimeoffset
*please update here if u already add new parameter type.

-To update new parameter type please open resources.php and add new parameter type on call() function.

3. Make sure u added new function calls to call the instances that u just created for 
	example: 
			example instances above  at Google_Service_Calendar_Events_Resource class in get() function. 
4. finish.

Configure methods on office365-api-php-client

1. the following methods is already implement in the libraries
	-POST
	-GET
	-PATCH
	-DELETE
-add new method on REST.php in libraries/Http

Others Configuration for office365

1.add new Office records to Vtiger records
-change at ~/connectors/{calendar/contacts} and go to transformToSourceRecord.
2.change data on to be push on office365
*please make sure the data name that u going to push is existed in office365!!!
-check at transformToTargetRecord() which is been call by WSAPP controller. modules/WSAPP/controller.


Where to change the data fetch from office365?? 
-data fetch in models folder in contacts/calendar.


