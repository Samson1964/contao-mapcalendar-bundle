# Kalenderübersicht mit Deutschlandkarte für Contao

Frontendmodul für die Website des Deutschen Schachbundes: eine anklickbare
Deutschlandkarte, darunter die kommenden Termine. Ein Klick auf ein Bundesland
lädt per AJAX die Termine des zugehörigen Landesverbands nach; ein Filter
schränkt nach Veranstaltungsart ein.

Ursprünglich von der redmind GmbH für den DSB entwickelt, seit 2020 mehrfach
gepflegt und hier als eigenständiges Contao-Bundle verpackt.

## Voraussetzungen

* PHP 7.4 oder 8.x
* Contao 4.13 mit Kalender-Bundle
* [MultiColumnWizard](https://packagist.org/packages/menatwork/contao-multicolumnwizard-bundle) ^3.4
* Die Tabelle `tl_event_type` (Veranstaltungsarten) und die Zuordnungstabelle
  `tl_calendar_events_event_type` – **beide bringt dieses Bundle nicht mit**,
  sie müssen in der Installation bereits vorhanden sein (siehe unten).

## Modultyp

| Typ | Name im Backend | Template |
| --- | --- | --- |
| `mapcalendar` | Kalenderübersicht mit Deutschlandkarte | `mod_mapcalendar`, `mod_mapcalendar_inner` |

Einstellungen im Modul:

* **DSB-Kalender** – ein oder mehrere Kalender, deren Termine beim ersten Aufruf erscheinen.
* **Landesverbände-Kalender** – je Zeile die Kennung des Bundeslands in der Karte
  (`mapid`), der Anzeigename, ein Einleitungstext und bis zu zwei Kalender.

Es werden höchstens 15 kommende Termine angezeigt.

## Veranstaltungsarten

Der Filter liest die veröffentlichten Einträge aus `tl_event_type` und sucht die
passenden Termine über `tl_calendar_events_event_type` (Spalten
`calendar_events_id`, `event_type_id`). Die Tabellen, ihre DCA und das Feld
`eventType` in `tl_calendar_events` gehören **nicht** zu diesem Bundle und auch
nicht zum früheren Redmind-Code in `src/redmind/`. Sie stammen aus einem anderen
Teil der schachbund.de-Installation und müssen dort bleiben.

Das Bundle registriert lediglich ein Modell `EventTypeModel` für `tl_event_type`,
falls noch keines registriert ist.

## Installation

Solange das Paket nicht auf Packagist steht, das GitHub-Repository als Quelle in
die `composer.json` des Projekts eintragen:

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/Samson1964/contao-mapcalendar-bundle" }
]
```

Danach:

```bash
composer require schachbulle/contao-mapcalendar-bundle:^1.0
vendor/bin/contao-console contao:install
vendor/bin/contao-console cache:clear --env=prod
```

Composer ab 2.9 blockiert Contao 4.13 wegen offener Security-Advisories. Falls die
Installation daran scheitert: `composer config policy.advisories.block false`.

## Umstieg von `src/redmind/MapCalendar`

1. In der `composer.json` des Servers den psr-4-Eintrag
   `"Redmind\\MapCalendar\\": "src/redmind/MapCalendar/"` entfernen und
   `RedmindMapCalendar` aus `app/ContaoManagerPlugin.php` (bzw. `config/bundles.php`) austragen.
2. Den Ordner `src/redmind/MapCalendar/` löschen. Achtung: Der Ordner
   `src/redmind/Helper/` enthält die Modelle, die die Karte bisher benutzt hat.
   Er darf erst weg, wenn auch das
   [Layout-Bundle](https://github.com/Samson1964/contao-dsblayout-bundle) installiert ist.
3. Die Assets liegen jetzt unter `bundles/contaomapcalendar/` statt
   `bundles/redmindmapcalendar/`. Eigene Template-Kopien im Theme anpassen:

   ```bash
   grep -rl "bundles/redmindmapcalendar" templates/
   ```

4. Datenbank-Aktualisierung im Backend **prüfen**: Für `tl_module` darf nichts
   vorgeschlagen werden, weil Feldnamen und -typen unverändert sind. Werden
   `DROP`-Anweisungen angeboten, nicht ausführen und erst der Ursache nachgehen.

Der Modultyp `mapcalendar` in `tl_module.type` bleibt gleich; die angelegten
Module müssen nicht angefasst werden. In der Typauswahl steht das Modul jetzt in
der Gruppe „Deutscher Schachbund“.

## Lizenz

Proprietär. Der ursprüngliche Code stammt von der redmind GmbH und wurde für den
Deutschen Schachbund e.V. entwickelt; die Urheberrechtsvermerke sind erhalten.
