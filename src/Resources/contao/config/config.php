<?php

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_combiner';

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['replaceDynamicScriptTags'][] = [
    '\\Terminal42\\CombinerBundle\\EventListener\\HookProxy',
    'replaceDynamicScriptTags'
];

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_combiner'] = 'Terminal42\\CombinerBundle\\Entity\\CombinerEntity';
