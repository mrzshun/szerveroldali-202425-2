Blog feladat:
Legyenek blogposztok (Post)
Legyenek kategóriák (Category)
Postnak legyen szerzője (User - Laravel beépített)
Blogposzt legyen kategóriákban - minden blogposzt több kategóriában lehet, minden kategóriában több blogposzt
Kommentek: egy poszthoz tartozhasson több komment
A kommentnek van egy szerzője

Modellek:
Post
User
Category
Comment

Modellekhez tartozó mezők:
Post - title, description, text, visible, author (user_id)
Category - name, bg_color, text_color
Comment - post (post_id), author (user_id), text
Post-Category összerendelés?

1. lépés: modellek létrehozása
- artisan parancsok
- modell, migration, factory
php artisan make:mode <modelname>
- migration - mezők megadása

2. lépés modellek közötti kapcsolatok
User-Post - 1-n (1-many)
Post-Category - n-n (n-m, many-many)
Post-Comment - 1-n
User-Comment - 1-n