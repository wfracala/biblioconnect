# BiblioConnect
## Autor: Wojciech Frącala
##Użyty standard EDIFACT: D.96A ORDERS
### Wymagania
Projekt wymaga PHP w wersji minimum 8.1, konfiguracji document root naplik public/index.php 

MySQL/MariaDB w wersji minimum 5.7

Opcjonalnie systemu kolejkowania, w obecnej wersji rozwiązany jest asynchronicznie przez komponent symfony messenger i kolejkowanie w bazie danych

## Instalacja

### Instalacja bibliotek 
```composer install```
### Inicjalizacja bazy danych

```php bin/console doctrine:migration:migrate```
### Utworzenie danych testowych

```php bin/console doctrine:fixtures:load (lub import bazy z pliku baza.sql)```

Komenda utworzy użytkownika o loginie admin@biblioconnect.com i haśle 12345678

``php bin/console messenger:consume``

Uruchamia consumera kolejki z wiadomościami EDIFACT(wybrać tryb async). Przy konfiguracji standardowej są konsumowane asynchronicznie z tabeli messenger_messages, można skonfigurować działanie z kolejkami jak rabbitMQ lub inne implementujące silnik MQTT
