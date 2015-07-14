<?php

namespace Terminal42\CombinerBundle\DataContainer;

class Combiner
{

    public function listRecord($row)
    {
        return sprintf(
            '<div style="float:left">%s <span style="color:#b3b3b3;padding-left:3px">[%s]</span></div>',
            $row['name'],
            $GLOBALS['TL_LANG']['tl_combiner']['type'][$row['type']]
        );
    }
}
