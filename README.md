# PHP Address Book Service

Welcome!

With this little app you'll be able to add addresses, update an address, view addresses and delete addresses which are all saved to a cookie attached to your session.

### Starts up the php backend
```
php -S 0.0.0.0:9000
```

### Touring your REST service

With the app running, you can check things out on the command line using curl (or any other tool you like).

### View a specific Address:
    $ curl localhost:9000/api/address/view/?id=1
    {
        "id":1,
        "first_name":"firstName",
        "last_name":"lastName",
        "email":"email@email.com",
        "phone":"999-999-9999",
        "address_1":"address",
        "address_2":"address2",
        "city":"city",
        "state":"CA",
        "zipcode":"91361"
    }

### List all Addresses:
    $ curl localhost:9000
    [{
        "id" : 1,
        "first_name" : "firstName",
        "last_name" : "lastName",
        "email" : "email@email.com",
        "phone" : "999-999-9999",
        "address_1" : "address",
        "address_2" : "address2",
        "city" : "city",
        "state" : "CA",
        "zipcode" : "91361"
    }]

### Create a New Address:
    $ curl -X POST localhost:9000 -d "{\"address\":{\"first_name\": \"George\", \"last_name\": \"Washington\", \"email\": \"bla@bla.com\", \"phone\": \"(999) 999-9999\",\"address_1\": \"16 Pennsylvania Ave\",\"address_2\": \"Apt 2\",\"city\": \"Washington\",\"state\": \"D.C\",\"zipcode\": \"99999\"}}" -H "Content-Type:application/json"
    {
        "id":2,
        "first_name":"George",
        "last_name":"Washington",
        "email":"bla@bla.com",
        "phone":"(999) 999-9999",
        "address_1":"16 Pennsylvania Ave",
        "address_2":"Apt 2",
        "city":"Washington",
        "state":"D.C",
        "zipcode":"99999"
    }

### Update an Existing Address:
    $ curl -X PUT localhost:9000 -d "{\"address\":{\"first_name\": \"George\", \"last_name\": \"Washington\", \"email\": \"bla@bla.com\", \"phone\": \"(999) 999-9999\",\"address_1\": \"16 Pennsylvania Ave\",\"address_2\": \"Apt 2\",\"city\": \"Washington\",\"state\": \"D.C\",\"zipcode\": \"99999\"}}" -H "Content-Type:application/json"
    {
        "id":1,
        "first_name":"Denzel",
        "last_name":"Washington",
        "email":"bla@bla.com",
        "phone":"(999) 999-9999",
        "address_1":"16 Pennsylvania Ave",
        "address_2":"Apt 2",
        "city":"Washington",
        "state":"D.C",
        "zipcode":"99999"
    }

### Delete an Existing Address:
    $ curl -X DELETE localhost:9000 -d "{\"addressId\": 3}"
    { 
        "message" : "success"
    }