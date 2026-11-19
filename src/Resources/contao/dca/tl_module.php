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

/*
 * Palette
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['mapcalendar'] = '{title_legend},name,type;{cal_legend},dsbCal,verbandCalendars;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

/*
 * Felder
 *
 * Namen und SQL-Typen entsprechen exakt den Redmind-Originalen, damit die
 * Datenbank-Aktualisierung nach der Umstellung nichts ändern will.
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['dsbCal'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['dsbCal'],
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'calendar1' => [
                'label' => &$GLOBALS['TL_LANG']['tl_module']['calendar1'],
                'exclude' => true,
                'inputType' => 'select',
                'foreignKey' => 'tl_calendar.title',
                'eval' => ['style' => 'width:220px'],
            ],
        ],
        'tl_class' => 'clr',
        'dragAndDrop' => false,
    ],
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['verbandCalendars'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['verbandCalendars'],
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'mapid' => [
                'label' => &$GLOBALS['TL_LANG']['tl_module']['mapid'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => ['style' => 'width:100px'],
            ],
            'selectTitle' => [
                'label' => &$GLOBALS['TL_LANG']['tl_module']['selectTitle'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => ['style' => 'width:220px'],
            ],
            'activeText' => [
                'label' => &$GLOBALS['TL_LANG']['tl_module']['activeText'],
                'exclude' => true,
                'inputType' => 'text',
                'eval' => ['style' => 'width:140px'],
            ],
            'calendar1' => [
                'label' => &$GLOBALS['TL_LANG']['tl_module']['calendar1'],
                'exclude' => true,
                'inputType' => 'select',
                'foreignKey' => 'tl_calendar.title',
                'eval' => ['style' => 'width:220px'],
            ],
            'calendar2' => [
                'label' => &$GLOBALS['TL_LANG']['tl_module']['calendar2'],
                'exclude' => true,
                'inputType' => 'select',
                'foreignKey' => 'tl_calendar.title',
                'eval' => ['includeBlankOption' => true, 'blankOptionLabel' => '-', 'tl_class' => 'clr', 'style' => 'width:220px'],
            ],
        ],
        'tl_class' => 'clr',
        'dragAndDrop' => true,
    ],
    'sql' => 'blob NULL',
];
