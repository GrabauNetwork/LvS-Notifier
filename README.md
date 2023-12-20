## LvS-Notifier
> **Was ist LvS-Notifier?**
>LvS-Notifier ist ein Script, welches die App *LvS-Pager* von [Vivasecure](https://www.vivasecur.de/loesungen/leitstellenverbund.html) ansprechen kann um eine automatisierte Testmeldung aussenden zu können.
Gedacht ist dieses Tool um eine regelmäßige Alamierung an alle oder an einzelne Mitglieder zu ermöglichen (bspw. Probealarm am Samstag)

____
> **Installationsanleitung** 
>```
>apt-get update && apt-get upgrade -y
> apt-get install php php-curl -y
> # Bearbeiten der config.php-Datei
> nano config.php
> # Speichern mit Strg+O Strg+X
>```
____
> ***Script ausführen***\
>Nachricht an alle Benutzer senden \
>```php notification.php``` \
>Nachricht an einzelnen Benutzer senden (s. $single_number in der \ >config.php - Datei) \
> ```php single_notification.php```

Bei Problemen und/oder Fragen bitte ein Ticket bei Issues öffnen
____
***Disclaimer***
Ich stehe in keinem Zusammenhang mit Vivasecure, dem Leitstellenverbundsystem o.ä.