# Możliwe endpointy na ten moment (format: METODA ADRES -> pola do przesłania)
POST /user/register.php -> name, email, password  
POST /user/login.php -> email, password  
GET /user/logout.php  

GET /product/products.php  
GET /product/product.php -> product_id  

Wszystkie endpointy zwracają odpowiedź w formacie JSON. Na przykład:  
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
      "subtitle": "brak",
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
    }
  ],
}
```