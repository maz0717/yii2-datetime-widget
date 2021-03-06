<?php
namespace trntv\yii\datetime\assets;

use yii\web\AssetBundle;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class MomentTimezoneAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/moment-timezone';

    /**
     * @var array
     */
    public $js = [
        'builds/moment-timezone-with-data-2012-2022.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'trntv\yii\datetime\assets\MomentAsset'
    ];
}
