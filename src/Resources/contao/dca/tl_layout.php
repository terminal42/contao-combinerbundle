<?php

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] .= ',combiners';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_layout']['fields']['combiners'] = [
    'label'      => &$GLOBALS['TL_LANG']['tl_layout']['combiners'],
    'exclude'    => true,
    'inputType'  => 'checkbox',
    'foreignKey' => 'tl_combiner.name',
    'eval'       => ['multiple' => true, 'tl_class' => 'clr'],
    'sql'        => "blob NULL",
];
