# Console import
```
php yii currency/import
```

All data saved to currency table


# Update token process

To get new token user have to pass login\password in POST request to:
```
/auth/gen-jwt-token
```

CURL example:
```
curl -d "login=admin&password=***" -k -X POST https://php-middle.test/auth/gen-jwt-token
```

in response:
```
{
    "jti": "***",
    "iss": "https://php-middle.test",
    "uid": 1,
    "token": "***"
}
```

# Get currency data (Bearer Auth required)

Get full list of available currencies (with pagination):
```
[GET] /currencies?per-page=5&page=1
```

Get info about specific currency:
```
[GET] /currency/1
```

CURL example:
```
curl -H "Authorization: Bearer ***" -k -X GET https://php-middle.test/currencies
```

```
curl -H "Authorization: Bearer ***" -k -X GET https://php-middle.test/currency/1
```