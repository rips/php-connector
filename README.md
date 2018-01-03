RIPS Connector
---

A simple PHP interface for easy access to the RIPS API.

# Installation

Use composer to include the package:

    composer require rips/connector:~2.10

OR add the following to composer.json and run `composer update`
	
	"rips/connector": "~2.10"


# Usage

    use RIPS\Connector\API;
	use RIPS\Connector\Exceptions\ClientException;
	use RIPS\Connector\Exceptions\ServerException;
    
	$config = ['base_uri' => 'http://localhost:8000'];

    // Initialize with config in constructor
    $api = new API('username', 'password', $config);

    // Or initialize manually
    $api = new API();
    $api->initialize('username', 'password', $config);

	try {
		// Get all users
		$users = $api->users->getAll();

		// Create new organization
		$org = $api->orgs->create([
			'name'       => 'My New Org',
			'validUntil' => '2018-08-03T15:23:04.286Z'
		]);
	} catch (ClientException $e) {
		// 400 error
	} catch (ServerException $e) {
		// 500 error
	}

Most methods will return either a `stdClass` object or an array of `stdClass` objects.

# Config/Options

The following config options are available:

	'base_uri' (required, default: http://localhost:8080): API URL
	'timeout' (optional, default: 100): Timeout of request in seconds
	'connect_timeout' (optional, default: 10): Number of seconds to wait while trying to connect to server
	'oauth2' (optional): OAuth2 configuration, see OAuth2 Config

## OAuth2Config

The following options are available as associative array under the oauth2 key:

    'enabled' (required): Use OAuth2 instead of legacy auth
    'client_id' (required): Client id for the login client
    'store_token' (optional, default: false): Flag if the OAuth2 tokens should be stored on disk
    'token_file_path' (optional): The file location for the token file
    'access_token' (optional, default: ""): If already present a accesstoken to use for login
        

# Testing

Testing is done with phpunit. You can [install phpunit globally](https://phpunit.de/manual/current/en/installation.html) or use the composer installed executable in `vendor/bin/phpunit`.

Abstract classes use stubs found in test/Stubs.

Run the tests by executing phpunit in the root directory of the project:

With global install:

    phpunit

With composer install:

    vendor/bin/phpunit
