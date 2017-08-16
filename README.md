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
	} catch (ServerExectpion $e) {
		// 500 error
	}

All methods return stdClass objects

# Config/Options

The following config options are available:

	'base_uri' (required default: http://localhost:8000): API URL
	'timeout' (optional default: 10): Timeout of request in seconds
	'connect_timeout' (optional default: 10): Number of seconds to wait while trying to connect to server

# Testing

Testing is done with phpunit. You can [install php globally](https://phpunit.de/manual/current/en/installation.html) or by using the executable in `./vendor/bin/phpunit`.

Run the tests by executing phpunit in the root directory of the project:

With global install:

    `phpunit`

With composer install:

    'vendor/bin/phpunit'
