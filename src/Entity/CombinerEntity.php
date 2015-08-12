<?php

namespace Terminal42\CombinerBundle\Entity;

use Contao\Model;

/**
 * @property int    $id
 * @property int    $pid
 * @property int    $tstamp
 * @property string $name
 * @property string $files
 * @property string $cacheFile
 */
class CombinerEntity extends Model
{
    /**
     * @var string
     */
    protected static $strTable = 'tl_combiner';

}
