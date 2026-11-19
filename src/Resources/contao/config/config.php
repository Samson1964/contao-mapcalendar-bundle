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

/*
 * Frontend-Modul
 *
 * Der Schlüssel „mapcalendar“ steht in tl_module.type der bestehenden
 * Module und darf nicht verändert werden. Der Gruppenschlüssel „dsb“ wird
 * nicht gespeichert und dient nur der Gliederung der Typauswahl.
 *
 * Tabelle und Modell der Veranstaltungsarten kommen aus
 * schachbulle/contao-eventtypes-bundle.
 */
$GLOBALS['FE_MOD']['dsb']['mapcalendar'] = MapCalendarModule::class;
