# Changelog

## Version 1.0.1 (2026-11-19)

* Change: README nennt den genauen Ort der Veranstaltungsarten auf schachbund.de:
  `app/Resources/contao/` mit DCA für `tl_event_type`, Feld `eventType` und
  Backend-Modul `event_types`. Diese Dateien bleiben bei der Umstellung liegen.

## Version 1.0.0 (2026-11-19)

* Add: Eigenständiges Contao-Bundle `schachbulle/contao-mapcalendar-bundle`
  (Namespace `Schachbulle\ContaoMapcalendarBundle`), herausgelöst aus
  `contao-dsb-bundle` 1.0.0, das die vier Redmind-Erweiterungen aus `src/redmind/`
  zusammengefasst hatte. Übernommen sind dessen PHP-8-Korrekturen für die Karte.
* Change: Die bisher im Helper liegenden Modelle gehören jetzt zur Karte:
  `EventTypeModel` und `UpcomingEventsModel` (früher `CalendarEventsRMModel`).
  `EventTypeModel` wird nur registriert, wenn für `tl_event_type` noch kein Modell
  eingetragen ist.
* Change: Assets unter `bundles/contaomapcalendar/` statt `bundles/redmindmapcalendar/`.
* Change: Gruppe in der Modultyp-Auswahl heißt intern `dsb` statt `redmind`;
  die Anzeige bleibt „Deutscher Schachbund“. Der Modultyp `mapcalendar` ist unverändert.
* Fix: Der Filter nach Veranstaltungsart nimmt nur numerische Werte an und
  selektiert `tl_calendar_events.id` statt eines mehrdeutigen `id` (aus dsb-bundle 1.0.0).
* Fix: Keine Warnungen mehr bei leeren Feldern `dsbCal`, `calendar1`, `calendar2`,
  `selectTitle` und `activeText` (aus dsb-bundle 1.0.0).

## Historie vor der Bundle-Umstellung (src/redmind/MapCalendar)

* 09.09.2025 – Fix: Undefined array key "dsb", "calendar1" in `MapCalendarModule.php`
  und "mapid" in `mod_mapcalendar.html5` unter PHP 8.
* 24.06.2025 – Fix: `Patchwork\Utf8::strtoupper` durch `strtoupper` ersetzt.
* 27.04.2022 – Template `mod_mapcalendar_inner`: Link „Alle Termine anzeigen“ heißt
  „Alle DSB-Termine anzeigen“.
* 28.10.2020 – Template `mod_mapcalendar_inner` geändert.
* 23.09.2020 – Mehrere DSB-Kalender möglich, DSB-Termine im Frontend vorausgewählt.
* 17.09.2020 – Redmind-Code in die Versionsverwaltung übernommen.
