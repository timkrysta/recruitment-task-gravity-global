# Gravity Global - Recruitment Task - Backend

<img src="https://github.com/laravel/sanctum/workflows/tests/badge.svg" alt="Build Status" style="max-width: 100%;">

## Introduction
The API includes three endpoints:
| Purpose                    | Endpoint                   |
|----------------------------|----------------------------|
| 1. Adding a new user       | POST /api/users/store      |
| 2. Retrieving users        | GET /api/users/getAll      |
| 3. Delete user by id       | POST /api/users/deleteById |

<br>

## Endpoint 1: POST /api/users/store

This endpoint is used to add new user to the file (data source). The request should be sent with the following properties:

- `name`: The user's name (required, string, alphanumeric characters and dashes)
- `username`: The user's username (required, string, alphanumeric characters and dashes, must be unique)
- `email`: The user's email address (required, valid email format, must be unique)
- `phone`: The user's phone number (required, string)
- `address`: The user's address (array)
  - `address.street`: The street of the user's address (required, string)
  - `address.suite`: The suite/apartment number of the user's address (required, string)
  - `address.city`: The city of the user's address (required, string)
  - `address.zipcode`: The zipcode of the user's address (required, string)
- `website`: The user's website (optional, string)
- `company`: The user's company (array)
  - `company.name`: The name of the user's company (required, string)
  - `company.catchPhrase`: The catch phrase of the user's company (optional, string)
  - `company.bs`: The business slogan of the user's company (optional, string)

<details>
<summary><font size="5"><b>View Response</b></font></summary>

If any of the required properties are missing or have an incorrect data type, the API will return a JSON object with the following format:


```json
{
    "message": "Validation Failed",
    "error": {
        "inputName": [
            "Message indicating what happened."
        ]
    }
}
```

If the user is successfully added, the API will return a JSON object with the following format:


```json
{
    "message": "Success"
}
```
</details>

<br>

## Endpoint 2: GET /api/users/getAll

This endpoint is used to retrieve the details of all users. The API will return a JSON object with the following format:

```json
[
    {
        "id": 1,
        "name": "Leanne Graham",
        "username": "Bret",
        "email": "Sincere@april.biz",
        "address": {
            "street": "Kulas Light",
            "suite": "Apt. 556",
            "city": "Gwenborough",
            "zipcode": "92998-3874",
            "geo": {
                "lat": "-37.3159",
                "lng": "81.1496"
            }
        },
        "phone": "1-770-736-8031 x56442",
        "website": "hildegard.org",
        "company": {
            "name": "Romaguera-Crona",
            "catchPhrase": "Multi-layered client-server neural-net",
            "bs": "harness real-time e-markets"
        }
    },
    {
        "id": 2,
        "name": "Ervin Howell",
        "username": "Antonette",
        "email": "Shanna@melissa.tv",
        "address": {
            "street": "Victor Plains",
            "suite": "Suite 879",
            "city": "Wisokyburgh",
            "zipcode": "90566-7771",
            "geo": {
                "lat": "-43.9509",
                "lng": "-34.4618"
            }
        },
        "phone": "010-692-6593 x09125",
        "website": "anastasia.net",
        "company": {
            "name": "Deckow-Crist",
            "catchPhrase": "Proactive didactic contingency",
            "bs": "synergize scalable supply-chains"
        }
    }
]
```

<br>

## Endpoint 3: POST /api/users/deleteById

This endpoint is used to delete a user by id. The request should be sent with the `userId` parameter.

If the user is successfully deleted, the API will return a JSON object with the following format:

```json
{
    "message": "Success"
}
```

If `userId` parameter is not present, the API will return an error:

```json
{
    "message": "Validation Failed",
    "error": {
        "userId": [
            "The userId field is required."
        ]
    }
}
```

<br>

## Author
[Tymoteusz Krysta](https://www.linkedin.com/in/tim-krysta/) - krystatymoteusz@gmail.com


<br>

## Final provisions
To execute tests run:
```sh
cd ./backend && ./vendor/bin/phpunit --testsuite Feature
```
