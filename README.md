# H1WE080122-PHP-Songbook
Sangbog API i Objektorienteret PHP med Mysql Database

## Forklaring af mapper
## core
Alt funktionel programmering skal placeres i core mappen. Det gælder klasse filer og filer med beskyttede oplysning som eksempelvis login oplysninger til databasen m.m.
___
### classes
Alle klasse filer placeres i classes mappen sammen med autoload.php, som sørger for at inkludere de relevante klasse filer når de kaldes.

Det er vigtigt at klassefilers filnavn er det samme som klassens navn. (Eks: *class User / user.php*) Ellers vil autoload ikke virke.

### userapp
I userappp mappen ligger dbconf, som er en klasse fil der kan etablere forbindelse til vores database og håndtere forskellige forespørgsler. Klassen dbconf indeholder kun oplysninger om vores database (host, bruger, adgangskode mm) men nedarver egenskaber og metoder fra klassen db og det er i denne fil at alle database forespørgsler bliver behandlet.
___
## public_html
Public html mappen er vores document root og dermed den mappe som brugere får adgang til via http.

## api
I mappen *api* deles de forskelliger elementer op i hver sin mappe med en .htaccess fil og en index.php fil. 

.htaccess filen skal bruges i forbindelse med vores routing.

I index.php filen sættes de forskellige endpoints op med hver sin route og klasse kald.

Følgende er en oversigt over routes til songs og request og class methods:

| Route navn | Endpoint | Request Metode | Klasse Metode |
|------|---|---|---|
| Liste | /api/song/ | GET | list() |
| Detaljer | /api/song/([0-9]*) | GET | details() |
| Opret | /api/song/ | POST | create() |
| Opdater | /api/song/ | PUT | update() | 
| Slet | /api/song/([0-9]*) | DELETE | delete() |





