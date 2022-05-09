# Możliwe endpointy na ten moment (format: METODA ADRES -> pola do przesłania | opis)
### Endpointy do autoryzacji uzytkownika:
POST /user/register.php -> name, email, password | rejestracja użytkownika  
POST /user/login.php -> email, password | logowanie użytkownika  
GET /user/logout.php | wylogowywanie użytkownika (+)  

### Endpointy do zwracania produktów (gier):
GET /product/products.php | zwraca szystkie gry (podstawowe informacje)  
GET /product/product.php -> product_id | zwraca wszystkie posidane informacje o grze opartej o jej id  
GET /product/search.php -> search | zwraca listę gier pasująych do podanej frazy - szukanie w tytule i podtytule (podstawowe informacje)  

### Endpointy do zarządzania koszykiem:
POST /cart/add.php -> product_id | dodaje gre do koszyka (+)  
POST /cart/remove.php -> product_id | usuwa gre z koszyka (+)  
GET /cart/content.php | zwraca gry, które zostały dodane do korzyka (podstawowe informacje o grach) (+)  

### Endpointy do zarządzania zakupami (na ten moment jest tylko jeden):
POST /purhcase/purchase.php -> product_id | kupuje gre o danym id - w trakie prac (+)
GET /purchase/checkout.php | kupuje wszyskie gry zawarte w koszyku - w trakie prac (+)
GET /purchase/show.php | zwraca zakupione gry (podstawowe informacje) (+)  

**(+) - zalogowany użytkownik jest wymagany**

# Wszystkie endpointy zwracają odpowiedź w formacie JSON. Na przykład:  
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
  "message": "Zwórocono pomyślnie listę produktów!",
  "products": [
    {
      "product_id": "1",
      "title": "Minecraft",
      "subtitle": "Minecraft",
      "publisher": "Mojang Studios",
      "released": "2009",
      "price": "100.00",
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
    },
    {
      "product_id": "2",
      "title": "GTA V",
      "subtitle": "Grand Theft Auto V",
      "publisher": "Rockstar Games",
      "released": "2013",
      "price": "100.00",
      "description": "Grand Theft Auto V (GTA V) – komputerowa gra akcji, należąca do serii Grand Theft Auto. Została wydana na konsole PlayStation 3 i Xbox 360 17 września 2013 przez studio Rockstar Games. Akcja gry została umiejscowiona w fikcyjnym mieście Los Santos oraz w terenach pozamiejskich nazwanych Blaine County w stanie San Andreas, stworzonych na podstawie miasta Los Angeles i Kalifornii. 10 czerwca 2014 podczas targów E3 ujawniono zapowiedź gry w wersjach na komputery osobiste oraz konsole ósmej generacji – PlayStation 4 i Xbox One. Wersje konsolowe ukazały się 18 listopada 2014, a na komputery osobiste 14 kwietnia 2015. W czerwcu 2020 zapowiedziano wydanie gry na konsole dziewiątej generacji – PlayStation 5 oraz Xbox Series X.",
      "pictures": "images/gta5/i1.png;images/gta5/i2.png;images/gta5/i3.png",
      "minimum_central_processing_unit": "Intel Core 2 Quad Q6600 2,4GHz lub AMD Phenom 9850 2,5 GHz",
      "minimum_graphics_processing_unit": "NVIDIA GeForce 9800 GT 1GB lub AMD Radeon HD 4870 1GB",
      "minimum_main_memory": "4 GB",
      "minimum_disc_space": "65 GB",
      "minimum_platforms": "Windows Vista / 7 SP1 / 8 / 8.1 64-Bit",
      "recommended_central_processing_unit": "Intel Core i5-3470 3,2GHz / AMD FX-8350 4GHz",
      "recommended_graphics_processing_unit": "NVIDIA GeForce GTX 660 2GB lub AMD Radeon HD 7870 2GB",
      "recommended_main_memory": "8 GB",
      "recommended_disc_space": "65 GB",
      "recommended_platforms": "Windows Vista / 7 SP1 / 8 / 8.1 64-Bit"
    }
  ]
}
```
```
{
  "success": true,
  "message": "Zwórocono pomyślnie zawartość koszyka!",
  "products": [
    {
      "product_id": 1,
      "title": "Minecraft",
      "subtitle": "Minecraft",
      "price": "100.00",
      "publisher": "Mojang Studios",
      "released": "2009"
    },
    {
      "product_id": 2,
      "title": "GTA V",
      "subtitle": "Grand Theft Auto V",
      "price": "100.00",
      "publisher": "Rockstar Games",
      "released": "2013"
    }
  ]
}
```
```
{
  "success": true,
  "message": "Zwórocono pomyślnie listę produktów pasujących do podanej frazy!",
  "products": [
    {
      "product_id": 2,
      "title": "GTA V",
      "subtitle": "Grand Theft Auto V",
      "price": "100.00",
      "publisher": "Rockstar Games",
      "released": "2013"
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
      "purchase_price": "100.00",
      "purchase_date": "2022-05-08 13:40:09"
    }
  ]
}
```