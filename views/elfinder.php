<?php

// Registering required scripts and CSS files
Yii::app()->clientScript->registerCoreScript("jquery");
Yii::app()->clientScript->registerCoreScript("jquery.ui");
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl()
        . "/jui/css/base/jquery-ui.css");
Yii::app()->clientScript->registerCssFile($this->elFinderCssUrl . "/elfinder.min.css");
Yii::app()->clientScript->registerScriptFile($this->elFinderJsUrl . "/elfinder.min.js");
Yii::app()->clientScript->registerCssFile($this->elFinderCssUrl . "/theme.css");

// If client's language is set then also registering language script
if (isset($this->clientOptions['lang']) && $this->clientOptions['lang'])
    Yii::app()->clientScript->registerScriptFile($this->elFinderJsUrl . "/i18n/elfinder." . $this->clientOptions['lang'] . ".js");

// Registering ElFinder's initialization script
Yii::app()->clientScript->registerScriptFile($this->initJsUrl);

// Registering a script to run initialization script when page's DOM will be built
$initScript = "jQuery(document).ready(function() {
    EzzeElFinder.init(\"" . $this->selector . "\", " . $this->jsonClientOptions . ")
});";
Yii::app()->clientScript->registerScript("elfinder-init", $initScript, CClientScript::POS_READY);

?>