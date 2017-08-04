RIPS API Connector
---

# Installation

Use composer to inlcude the package:

    composer require rips/api_connector

# Usage

Initialize a new instance of the RIPS API Connector:

    use RIPS\APIConnector\API;
    
    $api = new API('username', 'password');

	// get all users
    $users = $api->users->getAll();

    // create new organization
    $org = $api->orgs->create([
        'name' => 'My New Org',
        'validUntil' => '2018-08-03T15:23:04.286Z',
    ]);


# Testing

coming soon...
