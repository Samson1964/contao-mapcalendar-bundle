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

namespace Schachbulle\ContaoMapcalendarBundle\Model;

use Contao\CalendarEventsModel;
use Contao\Database;
use Contao\Date;
use Contao\Model\Collection;

/**
 * Erweitert das Termin-Modell um eine Suche nach Veranstaltungsart.
 */
class UpcomingEventsModel extends CalendarEventsModel
{
    /**
     * Findet kommende Termine mehrerer Kalender, optional gefiltert nach Veranstaltungsart.
     *
     * @param array<int|string>   $arrIds     IDs der Kalender
     * @param int                 $intLimit   Maximale Trefferzahl (0 = unbegrenzt)
     * @param array<string,mixed> $arrOptions Zusätzliche Optionen, unterstützt "order"
     * @param mixed               $type       ID der Veranstaltungsart oder false
     *
     * @return Collection|CalendarEventsModel[]|null
     */
    public static function findUpcomingByPidsFilteredByType($arrIds, $intLimit = 0, array $arrOptions = [], $type = false)
    {
        if (empty($arrIds) || !\is_array($arrIds)) {
            return null;
        }

        $t = static::$strTable;
        $time = Date::floorToMinute();
        $pids = implode(',', array_map('\intval', $arrIds));

        $join = '';
        $joinwhere = '';

        // Nur numerische Werte zulassen, der Wert stammt aus dem Request
        if ($type && is_numeric($type)) {
            $join = " LEFT JOIN tl_calendar_events_event_type et ON et.calendar_events_id=$t.id";
            $joinwhere = 'et.event_type_id='.(int) $type.' AND';
        }

        $sql = "SELECT $t.id FROM $t $join WHERE $joinwhere ($t.endTime>=$time OR ($t.recurring='1' AND ($t.recurrences=0 OR $t.repeatEnd>=$time)))"
            ." AND $t.pid IN($pids)"
            ." AND ($t.start='' OR $t.start<='$time')"
            ." AND ($t.stop='' OR $t.stop>'".($time + 60)."')"
            ." AND $t.published='1'";

        if (isset($arrOptions['order'])) {
            $sql .= ' ORDER BY '.$arrOptions['order'];
        } else {
            $sql .= " ORDER BY $t.startTime";
        }

        if ($intLimit > 0) {
            $sql .= ' LIMIT '.(int) $intLimit;
        }

        $ids = Database::getInstance()->prepare($sql)->execute()->fetchEach('id');

        if (empty($ids)) {
            return null;
        }

        return static::findMultipleByIds($ids);
    }
}
