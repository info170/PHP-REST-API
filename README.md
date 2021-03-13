
<h4>REST API Phonebook on PHP</h4>

Ready for using in 3 steps:

1. Edit DB.php file to set DB credentials.

2. Execute "composer install" command to install Doctrine and Guzzle dependencies.

3. Send requests to address http://www.your_host.com/record

(The migration to create a new table will start automatically.)

Available queries:

// return all records
GET /record

// return a specific record
GET /record/{id}

// return a specific record searching parts of the name
GET /record/?search=name

// create a new record
POST /record

// update an existing record
PUT /record/{id}

// update an existing record
PATCH /record/{id}

// delete an existing record
DELETE /record/{id}

To add or update queries send data in json format in request body, for example:
<pre>
{
    "first_name": "Leo",
    "last_name": "Messi",
    "phone_number": "+15 999 444224455",
    "country_code": "ZW",
    "time_zone": "America/Denver"
}
</pre>
