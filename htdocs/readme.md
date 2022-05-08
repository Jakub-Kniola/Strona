# Endpointy użytkownika

### POST /user/register.php -> name, email, password  
```
{
  "success": false,
  "message": "Podany adres email jest już zajęty!"
}
```
```
{
  "success": true,
  "message": "Zarjestrowano pomyślnie!"
}
```

POST /user/login.php -> email, password  
```
{
  "success": false,
  "message": "Jesteś już zalogowany!"
}
```
```
{
  "success": true,
  "message": "Zalogowano pomyślnie!"
}
```

### POST /user/logout.php
Przykłady  
```
{
"success": false,
"message": "Nie jesteś zalogowany!"
}
```
```
{
    "success": true,
    "message": "Wylogowano pomyślnie!"
}
```

# Endpoiny produktów (gier)

GET /product/products.php
