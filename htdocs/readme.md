# Możliwe endpointy na ten moment (format: METODA ADRES -> pola do przesłania | opis)
### Endpointy do autoryzacji uzytkownika:
POST /user/register.php -> name, email, password | rejestracja użytkownika  
POST /user/login.php -> email, password | logowanie użytkownika  
GET /user/logout.php | wylogowywanie użytkownika (+)  

### Endpointy do zwracania produktów (gier):
GET /product/show.php -> product_id | zwraca wszystkie posidane informacje o grze o podanym id  
GET /product/search.php -> title, category, publisher, released, min_price, max_price, offset, limit | zwraca listę gier pasująych do podanych danych (podstawowe informacje) - wszystkie pole są opcjonalne, gdy żadne z nich nie zostanie podane zostaną zwrócone wszystkie gry

### Endpointy do zarządzania koszykiem:
POST /cart/add.php -> product_id | dodaje gre do koszyka (+)  
POST /cart/remove.php -> product_id | usuwa gre z koszyka (+)  
GET /cart/show.php | zwraca gry, które zostały dodane do korzyka (podstawowe informacje o grach) (+)  

### Endpointy do zarządzania zakupami (na ten moment jest tylko jeden):
POST /purhcase/purchase.php -> product_id | kupuje gre o podanym id (+)  
GET /purchase/checkout.php | kupuje wszyskie gry zawarte w koszyku (+)  
GET /purchase/show.php | zwraca zakupione gry (podstawowe informacje o grach) (+)  

**(+) - zalogowany użytkownik jest wymagany**

# Wszystkie endpointy zwracają odpowiedź w formacie JSON. Na przykład:  
```
{
    "success": false,
    "message": "Hasło musi posiadać od 8 do 128 znaków!"
}
```
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
```
{
    "success": true,
    "message": "Zalogowano pomyślnie!"
}
```
```
{
    "success": true,
    "message": "Zwórocono pomyślnie listę produktów pasujących do podanej danych!",
    "products": [
        {
            "product_id": 1,
            "title": "Minecraft",
            "subtitle": "Minecraft",
            "publisher": "Mojang Studios",
            "released": "2009",
            "icon": "images/minecraft/icon.png",
            "price": "100.00"
        },
        {
            "product_id": 2,
            "title": "GTA V",
            "subtitle": "Grand Theft Auto V",
            "publisher": "Rockstar Games",
            "released": "2013",
            "icon": "images/gta5/icon.png",
            "price": "300.00"
        },
        {
            "product_id": 3,
            "title": "GTA III",
            "subtitle": "Grand Theft Auto 3",
            "publisher": "Rockstar Games",
            "released": "2005",
            "icon": "images/gta3/icon.png",
            "price": "50.00"
        }
    ]
}
```
```
{
    "success": true,
    "message": "Zwórocono pomyślnie produkt!",
    "product": {
        "product_id": 1,
        "title": "Minecraft",
        "subtitle": "Minecraft",
        "category": "przygodowa",
        "publisher": "Mojang Studios",
        "released": "2009",
        "price": "100.00",
        "icon": "images/minecraft/icon.png",
        "description": "Minecraft – komputerowa gra survivalowa o otwartym świecie stworzona przez Markusa Perssona i rozwijana przez Mojang Studios. Minecraft pozwala graczom na budowanie i niszczenie obiektów położonych w losowo generowanym świecie gry. Gracz może atakować napotkane istoty, zbierać surowce czy wytwarzać przedmioty.",
        "pictures": "images/mineraft/i1.png;images/mineraft/i2.png;images/mineraft/i3.png",
        "minimum_central_processing_unit": "Intel P4/AMD K7 (np. Intel Core i3-3210 3.2 GHz lub AMD A8-7600 APU 3.1 GHz)",
        "minimum_graphics_processing_unit": "Nvidia GeForce 400 lub AMD Radeon HD 7000, Zintegrowana Intel HD Graphics 4000 lub AMD Radeon R5",
        "minimum_main_memory": "2 GB",
        "minimum_disc_space": "1 GB",
        "minimum_platforms": "Windows 7, 8, 10 (w zależności od wersji gry)",
        "recommended_central_processing_unit": "Intel Nehalem-Based/AMD Husky-Based (np. Intel Core i5-4690 3.5GHz lub AMD A10-7800 APU 3.5 GHz)",
        "recommended_graphics_processing_unit": "GeForce 700 lub AMD Radeon Rx 200",
        "recommended_main_memory": "4 GB",
        "recommended_disc_space": "4 GB",
        "recommended_platforms": "Windows 7, 8, 10 (w zależności od wersji gry)"
    }
}
```
```
{
    "success": true,
    "message": "Zwórocono pomyślnie listę produktów znajdujące się w koszyku!",
    "products": [
        {
            "product_id": 1,
            "title": "Minecraft",
            "subtitle": "Minecraft",
            "price": "100.00",
            "publisher": "Mojang Studios",
            "released": "2009",
            "icon": "images/minecraft/icon.png"
        },
        {
            "product_id": 2,
            "title": "GTA V",
            "subtitle": "Grand Theft Auto V",
            "price": "300.00",
            "publisher": "Rockstar Games",
            "released": "2013",
            "icon": "images/gta5/icon.png"
        }
    ]
}
```
```
{
    "success": true,
    "message": "Zwórocono pomyślnie listę zakupionych przedmiotów!",
    "products": [
        {
            "purchase_id": 1,
            "product_id": 1,
            "title": "Minecraft",
            "subtitle": "Minecraft",
            "publisher": "Mojang Studios",
            "released": "2009",
            "icon": "images/minecraft/icon.png",
            "purchase_price": "100.00",
            "purchase_date": "2022-05-08 13:40:09"
        },
        {
            "purchase_id": 6,
            "product_id": 2,
            "title": "GTA V",
            "subtitle": "Grand Theft Auto V",
            "publisher": "Rockstar Games",
            "released": "2013",
            "icon": "images/gta5/icon.png",
            "purchase_price": "300.00",
            "purchase_date": "2022-05-10 17:03:44"
        }
    ]
}
```