Blog - mit fog tudni?
Blogposztok
Blogposztnak van szerzője - User, aki létrehozta
Kategorizálás: vannak kategóriák, minden Blogposzt több kategóriában is szerepelhet - tagging


Modellek:
- Post
- Category
- User // ez beépítve van a Laravelben
- Comment


Modellekhez tartozó mezők
- Post: title, description, text, author
- Category: txt_color, bg_color, name
- Comment: text, user_id


Modellek közötti kapcsolatok
- User-Post: 1-n - egy usernek több blogposztja lehet, de egy blogposztnak pontosan egy szerzője van (1-sok)
- Post-Categories: n-n - egy poszt több kategóriához tartozik, egy kategóriához több poszt van
- Post-Comment: 1-n
- User-Comment: 1-n

https://webprogramozas.inf.elte.hu/#!/subjects/webprog-server/handouts/laravel-04-rel%C3%A1ci%C3%B3k

https://laravel.com/docs/12.x/eloquent-relationships#main-content


REST CRUD endpointok

CRUD: 

read -> egy elem, vagy az összes elem lekérdezése
Http metódus: GET
/categories         // mind lekérése
/categories/:id     // egy elem lekérdezése

create -> új entitás létrehozása
Http metódus: POST
Authentikált
/categories         // post bodyban adatok --> létrehozás

update -> változtatás 
Http metódus: PUT / PATCH
Authentikált
Mikor melyik?
PUT: a teljes objektumot átadjuk az összes mezőjével
PATCH: csak a frissítendő mezőket adjuk át
/categories/:id     //módosítás

delete -> törlés
Http metódus: DELETE
Authentikált
/categories         //egy törlése
/categories/:id     //összes törlése