<?php declare(strict_types=1);

namespace NotifyOnStock;

use Shopware\Core\Framework\Plugin;


class NotifyOnStock extends Plugin
{
    private function cleanData(Connection $connection): void
    {
        // create DataBase Connection
        /*
         * ToDo / Gedankengänge:
         *  - Für Benachrichtigungsfeld noch ein Formular hinzufügen
         *  1. Wenn Benachrichtigungsfeld abgeschickt wird --> Dann speichere die ausgefüllten Daten in eine Tabelle
         *   - Von wo aus rufen wir diese Funktion auf? Wo bauen wir diese Funktion?
         *   - Wie kriegt man Zugriff auf das Formular bzw. die übergebenen Daten
         *  2. Wenn Artikel wieder auf Lager --> Dann schicke Email an Kunden, die für diesen Artikel benachrichtigt werden wollen
         *    --> EntityRepositoryInterface $scheduledTaskRepository
         *    - Wie triggert man den Auslöser, dass ein Artikel auf Lager ist?
         *    -
         *   Die nächsten Steps:
         *    - [X] Formular anpassen (<form> hinzufügen, um Daten übergeben zu können) -fertig-
         *    - [] Die originale Produktseite anpassen, nach der Bestätigung des Knopfs (successfully signed up for notification..)
         *    - [] Route zu einer originalen Produktseite anpassen
         *    - [X] Herausfinden, wie Route gebildet wird - Product Alert (Controller)
         *    - [X] remove product id from URL
         *    - [X] Route auf extra Seite mit home-page button
         *    - [x] ProductAlertController bauen
         *    - [] ProductAlertController vervollständigen
         *    - [] Template für Email schreiben
         *    - [] Wie speichern wir Daten in die Datenbanktabelle (Wie funktioniert die Migration?)
         *    - [] Einträge in Liste speichern (Form übergeben und Daten abspeichern)
         *    - [] Entitys festlegen für die Liste
         *
         *    - [X] Datenbanktabelle erstellen für Notification
         *    - [] Datensätze in die Tabelle speichern / übergeben
         *    - []
         */
    }
}