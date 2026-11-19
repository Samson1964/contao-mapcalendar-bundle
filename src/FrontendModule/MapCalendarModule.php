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

namespace Schachbulle\ContaoMapcalendarBundle\FrontendModule;

use Contao\CoreBundle\Exception\ResponseException;
use Contao\FrontendTemplate;
use Contao\StringUtil;
use Schachbulle\ContaoEventtypesBundle\Model\EventTypeModel;
use Schachbulle\ContaoMapcalendarBundle\Model\UpcomingEventsModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * Kalenderübersicht mit anklickbarer Deutschlandkarte.
 */
class MapCalendarModule extends AbstractModule
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'mod_mapcalendar';

    /**
     * Maximale Anzahl angezeigter Termine.
     *
     * @var int
     */
    protected $maxEvents = 15;

    /**
     * Template des nachladbaren Inhaltsbereichs.
     *
     * @var FrontendTemplate|null
     */
    protected $innerTemplate;

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        if ($this->isBackendRequest()) {
            return $this->generateBackendWildcard('mapcalendar');
        }

        $this->innerTemplate = new FrontendTemplate('mod_mapcalendar_inner');

        $request = $this->getRequest();

        if (null !== $request && $request->isXmlHttpRequest()) {
            // Nur das angefragte Modul antwortet
            if ((string) $request->request->get('module_id') !== (string) $this->id) {
                return '';
            }

            $this->loadEvents($request->request->get('cid'), $request->request->get('filter'));

            if ($request->request->has('cid')) {
                throw new ResponseException(new Response($this->innerTemplate->parse()));
            }
        }

        return parent::generate();
    }

    /**
     * {@inheritdoc}
     */
    protected function compile(): void
    {
        $this->loadEvents('dsb');

        $lvs = StringUtil::deserialize($this->verbandCalendars, true);
        array_unshift($lvs, ['selectTitle' => 'Bundesland oder Verband']);

        $this->Template->inner = $this->innerTemplate->parse();
        $this->Template->lvs = $lvs;
        $this->Template->filters = EventTypeModel::findBy('published', '1') ?? [];
    }

    /**
     * Lädt die Termine des gewählten Kalenders in das innere Template.
     *
     * @param mixed $id     Index des Landesverbands, "dsb" oder 0 für alle
     * @param mixed $filter ID der Veranstaltungsart oder false
     */
    protected function loadEvents($id = 0, $filter = false): void
    {
        $cals = StringUtil::deserialize($this->verbandCalendars, true);
        array_unshift($cals, ['selectTitle' => 'Bundesland oder Verband']);

        $thisIds = [];

        if ('dsb' === $id) {
            // Alle Kalender des Deutschen Schachbundes
            foreach (StringUtil::deserialize($this->dsbCal, true) as $c) {
                if (\is_array($c) && !empty($c['calendar1'])) {
                    $thisIds[] = $c['calendar1'];
                }
            }

            $this->innerTemplate->activeStr = 'Deutschen Schachbundes';
            $this->innerTemplate->activeText = 'Alle Termine des';
        } elseif (!$id || !isset($cals[$id])) {
            // Alle Landesverbands-Kalender
            foreach ($cals as $c) {
                if (!\is_array($c)) {
                    continue;
                }

                if (!empty($c['calendar1'])) {
                    $thisIds[] = $c['calendar1'];
                }

                if (!empty($c['calendar2'])) {
                    $thisIds[] = $c['calendar2'];
                }
            }

            $this->innerTemplate->activeStr = false;
        } else {
            // Ein einzelner Landesverband
            $cal = (array) $cals[$id];

            if (!empty($cal['calendar1'])) {
                $thisIds[] = $cal['calendar1'];
            }

            if (!empty($cal['calendar2'])) {
                $thisIds[] = $cal['calendar2'];
            }

            $this->innerTemplate->activeStr = $cal['selectTitle'] ?? '';
            $this->innerTemplate->activeText = $cal['activeText'] ?? '';
        }

        $this->innerTemplate->events = $this->getEvents($thisIds, $filter);
    }

    /**
     * Liest die kommenden Termine der übergebenen Kalender.
     *
     * @param array<int,mixed> $calids
     * @param mixed            $filter
     *
     * @return \Contao\Model\Collection|null
     */
    protected function getEvents(array $calids, $filter = false)
    {
        if (empty($calids)) {
            return null;
        }

        return UpcomingEventsModel::findUpcomingByPidsFilteredByType($calids, $this->maxEvents, [], $filter);
    }
}
