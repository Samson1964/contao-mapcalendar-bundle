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
* [Veranstaltungsarten-Bundle](https://github.com/Samson1964/contao-eventtypes-bundle) ^1.0
  (wird von Composer mitinstalliert, bringt Haste 4 mit)

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
`calendar_events_id`, `event_type_id`). Tabelle, Feld, Backend-Modul und Modell
stellt das [Veranstaltungsarten-Bundle](https://github.com/Samson1964/contao-eventtypes-bundle)
bereit; die Termine werden im Backend dort mit Arten versehen.

## Installation

Solange die Pakete nicht auf Packagist stehen, beide GitHub-Repositories als
Quelle in die `composer.json` des Projekts eintragen. Composer liest
`repositories` nur aus der Projektdatei, deshalb muss auch die Abhängigkeit dort
stehen:

```json
"repositories": [
    { "type": "vcs", "url": "https://github.com/Samson1964/contao-mapcalendar-bundle" },
    { "type": "vcs", "url": "https://github.com/Samson1964/contao-eventtypes-bundle" }
]
```

Danach:

```bash
composer require schachbulle/contao-mapcalendar-bundle:^1.1
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
   Für die Veranstaltungsarten in `app/Resources/contao/` gilt der Umstiegsabschnitt
   im [Veranstaltungsarten-Bundle](https://github.com/Samson1964/contao-eventtypes-bundle).
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
