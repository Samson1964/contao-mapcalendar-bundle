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

namespace Schachbulle\ContaoMapcalendarBundle\ContaoManager;

use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Schachbulle\ContaoMapcalendarBundle\ContaoMapcalendarBundle;

/**
 * Meldet das Bundle beim Contao Manager an.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * Liefert die Bundle-Konfiguration für den Contao Manager.
     *
     * Das Bundle wird nach dem Core- und dem Kalender-Bundle geladen, weil
     * die Kalenderkarte auf tl_calendar und tl_calendar_events zugreift.
     *
     * @param ParserInterface $parser Parser des Contao Managers (hier ungenutzt)
     *
     * @return array<int,BundleConfig> Genau ein Eintrag für dieses Bundle
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoMapcalendarBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    ContaoCalendarBundle::class,
                ]),
        ];
    }
}
