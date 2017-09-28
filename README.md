RIPS Connector
---

# Installation

Update composer.json to read from the public RIPS repository

    "repositories": [
        {
            "type": "vcs",
            "url": "https://source.internal.ripstech.com/scm/rac/php-connector.git"
        }
    ],

Use composer to inlcude the package:

    composer require rips/connector:dev-dev

OR add to composer.json and run `composer update`
	
	"rips/connector": "dev-dev"


# Usage

    use RIPS\Connector\API;
	use RIPS\Connector\Exceptions\ClientException;
	use RIPS\Connector\Exceptions\ServerException;
    
	$config = ['base_uri' => 'http://localhost:8000'];
    $api = new API('username', 'password', $config);

	try {
		// get all users
		$users = $api->users->getAll();

		// create new organization
		$org = $api->orgs->create([
			'name' => 'My New Org',
			'validUntil' => '2018-08-03T15:23:04.286Z',
		]);
	} catch (ClientException $e) {
		// 400 error
	} catch (ServerException $e) {
		// 500 error
	}

All methods return stdClass objects or an array of stdClass objects

# Config/Options

The following config options are available:

	'base_uri' (required default: http://localhost:8000): API URL
	'timeout' (optional default: 100): Timeout of request in seconds
	'connect_timeout' (optional default: 10): Number of seconds to wait while trying to connect to server

# Testing

Testing is done with phpunit. You can [install phpunit globally](https://phpunit.de/manual/current/en/installation.html) or use the composer installed executabled in `vendor/bin/phpunit`.

Abstract classes use stubs found in test/Stubs.

Run the tests by executing phpunit in the root directory of the project:

With global install:

    `phpunit`

With composer install:

    'vendor/bin/phpunit'

# Endpoints:

Current endpoints implemented:

Applications:

    GET - /applications
    POST - /applications/{applicationId}/uploads

Scans:

    GET - /applications/scans/all
    GET|DELETE|POST - /applications/{applicationId}/scans
    GET|DELETE|PATCH - /applications/{applicationId}/scans/{scanId}
    GET - /applications/{applicationId}/scans/stats
   
Issues:

    GET - /applications/{applicationId}/scans/{scanId}/issues

Organisations:

    GET|DELETE|PATCH - /organisations/{organisationId}
    DELETE|POST - /organisations

Quotas:

    GET - /quotas

Teams:

    N/A

Users:

    GET - /users
    GET - /users/{teamId}
    POST - /users/invite/ui
