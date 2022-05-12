FERIT Share - aplikacija namijenjena pohranjivanju datoteka i dijeljenju datoteka među studentima FERIT-a.

## Instalacija aplikacije
1. U terminala pozvati naredbu git clone https://github.com/ivanviduka/DiplomskiRad.git unutar direktorija koji može raditi sa serverom (npr. /var/www/html)
2. Ući u kreirani direktorij i pozvati naredbu composer install unutar terminala
3. Pozvati naredbu cp (ili copy) .env.example .env
4. Unutar .env datoteke postaviti vrijednosti za DB_DATABASE, DB_USERNAME i DB_PASSWORD
5. Pozvati naredbu php artisan key:generate
6. Pozvati naredbu php artisan migrate
7. Pozvati naredbu php artisan db:seed --class=CreateUsersSeeder
8. Unutar phpMyAdmin importati tablicu s popisom kolegija unutar odabrane baze podataka. Tablica se nalazi na repozitoriju pod nazivom subject-table, potrebno je postaviti naziv baze podataka na liniji #5 na vrijednost DB_DATABASE iz .env datoteke
9. Pristupiti aplikaciji s podacima: email - admin@etfos.hr, password -  B2bFERIT!

Moguće se registirati i s vlastitim korisničkim podacima, ali oni neće imati ovlasti administratora.
Za registraciju je potrebno koristiti email adresu koja završava na etfos.hr ili ferit.hr te zaporku od 8 znakova, velika i mala slova, broj te simbol

## Napomena
U aplikaciji je postavljeno ograničenje za veličinu datoteke na maksmimalno 10MB. Međutim, potrebno je provjeriti dopušta li lokalna php.ini datoteka tolike vrijednosti. Potrebno je provjeriti koja je trenutno aktivna datoteka (pri izradi aplikacije bila je /etc/php/7.4/cli/php.ini) te postaviti sljedeće vrijednosti: upload_max_filesize = 10M, post_max_size = 11M
