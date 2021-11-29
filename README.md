# FIT VUT IIS 2021/2022 - Informační systémy, týmový projekt
## Aukce: prodej a nákup zboží a majetku prostřednictvím dražby
### Autoři
– Gotzman Matěj xgotzm00@stud.fit.vutbr.cz

– Sokolovskii Vladislav xsokol15@stud.fit.vutbr.cz

– Strýček Šimon xstryc06@stud.fit.vutbr.cz

### Dokumentace
Dokumentace je ve složce [`./doc/doc.html`](./doc/doc.html).

### Databáze
SQL skript pro vytvoření a inicializaci schématu databáze se nachází v [`./database/create_tables.sql`](./database/create_tables.sql).

### Instalace

#### Softwarové požadavky pro zprovoznění IS
1. PHP, verze aspoň 7.3
2. Composer
3. Jakakoliv relační databáze, viz soubor .env (Projekt byl testován na databázích MySQL a PostreSQL.)
4. AWS S3 bucket pro persistentní úkladaní obrázků, je možné použit předdefinovaný, viz soubor .env

#### Postup instalace na server
1. Naklonujte repozitař git clone https://github.com/vsokolov00/iis-project (repozitář zveřejněn až po odevzdání)
2. V kořenové složce projektu spusťte `composer install`
3. Upravte konfigurační soubor `.env` pokud chcete použit svůj AWS bucket, upravťe udaje tykajicí se databázi `DB_...`
4. Pokud jste úspěšně připojili svou databázi, spusťte příkaz `php artisan migrate`
5. Vytvořte soft link pro přístup k obrazkům `php artisan storage:link`
6. Spusťte server příkazem `php artisan serve`

### Vzhled aplikace
![Očekavaný vzhled aplikace (po naplnění data)](doc/vzhled.png?raw=true "Vzhled")
