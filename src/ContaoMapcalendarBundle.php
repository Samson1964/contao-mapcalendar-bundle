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

namespace Schachbulle\ContaoMapcalendarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Haupt-Bundle-Klasse der Kalenderübersicht mit Deutschlandkarte.
 *
 * Der Klassenname bestimmt das Asset-Verzeichnis: web/bundles/contaomapcalendar/.
 * Wer die Klasse umbenennt, muss die Pfade in den Templates mitziehen.
 */
class ContaoMapcalendarBundle extends Bundle
{
}
