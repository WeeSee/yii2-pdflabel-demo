<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use weesee\pdflabel\PdfLabel;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Here are some samples for Yii2-Extension <code>yii2-pdflabel</code>.
    </p>
    <p>Select label format:
    <ul><?php
        foreach(PdfLabel::getLabelNames('A4') as $name => $format)
            echo "<li>".Html::a("Label-PDF ".$name,
                ['pdf-label-download','label'=>$name],
                ['target'=>'_blank']
            )."</li>";
        ?>
    </ul>
    </p>
    <p>
        <?= Html::a("Checkout <code>yii2-pdflabel</code> extension on Github",'http://github.com/weesee/yii2-pdflabel'); ?>
    </p>
</div>
