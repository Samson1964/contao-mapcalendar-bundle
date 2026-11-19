<?php

declare(strict_types=1);

/*
 * Contao Mapcalendar Bundle
 *
 * Ursprünglich entwickelt von der redmind GmbH für den Deutschen Schachbund e.V.
 *
 * @copyright  Copyright (c) 2020, redmind GmbH
 * @author     redmind GmbH <info@redmind.de>
 * @license    proprietary
 */

use Schachbulle\ContaoMapcalendarBundle\FrontendModule\MapCalendarModule;
use Schachbulle\ContaoMapcalendarBundle\Model\EventTypeModel;

/*
 * Frontend-Modul
 *
 * Der Schlüssel „mapcalendar“ steht in tl_module.type der bestehenden
 * Module und darf nicht verändert werden. Der Gruppenschlüssel „dsb“ wird
 * nicht gespeichert und dient nur der Gliederung der Typauswahl.
 */
$GLOBALS['FE_MOD']['dsb']['mapcalendar'] = MapCalendarModule::class;

/*
 * Modell der Veranstaltungsarten
 *
 * Auch das Mitglieder-Kalender-Bundle registriert ein Modell für diese
 * Tabelle. Wer zuerst kommt, gewinnt; beide Klassen sind gleichwertig.
 */
$GLOBALS['TL_MODELS']['tl_event_type'] = $GLOBALS['TL_MODELS']['tl_event_type'] ?? EventTypeModel::class;
