<?php

namespace Terminal42\CombinerBundle\EventListener;

use Contao\System;

class HookProxy
{
    public function replaceDynamicScriptTags($buffer)
    {
        System::getContainer()
            ->get('terminal42_combiner.listener.dynamic_script_tags')
            ->replaceGlobals()
        ;

        return $buffer;
    }
}
