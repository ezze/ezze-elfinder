<?php

Yii::import("ext.ezzeelfinder.ElFinderConnectorAction");

/**
 * A widget to integrate ElFinder uploader.
 *
 * @author Dmitriy Pushkov <ezze@ezze.org>
 * @version 2.0-rc1/0.0.1
 */
class ElFinderWidget extends CWidget
{
    /**
     * jQuery selector for a container to place ElFinder in.
     *
     * @var string
     */
    public $selector = "#elfinder";

    /**
     * ElFinder client's configuration options as described here:
     * https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
     *
     * Please note that these options must be passed as an array and will be
     * converted to JSON object automatically.
     *
     * @var array
     */
    public $clientOptions = array();

    /**
     * A route to ElFinder connector's action.
     *
     * This action must be implemented as a reference to {@link ElFinderConnectorAction} class.
     *
     * @var string
     */
    public $connectorRoute = null;

    /**
     * ElFinder connector's configuration options as described here:
     * https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
     *
     * @var array
     */
    public $connectorOptions = array();

    /**
     * Used to store an asset URL of ElFinder's initialization script.
     * This script is located in "js" directory of the extension.
     *
     * @var string
     */
    protected $_initJsUrl = null;

    /**
     * Used to store an asset URL of ElFinder's scripts, images and CSS files.
     * These files are located in "assets" directory of the extension.
     *
     * @var string
     */
    protected $_elFinderAssetsUrl = null;

    /**
     * Used to store an asset URL of ElFinder's CSS directory.
     *
     * @var string
     */
    protected $_elFinderCssUrl = null;

    /**
     * Used to store an asset URL of ElFinder's scripts directory.
     *
     * @var string
     */
    protected $_elFinderJsUrl = null;

    /**
     * Used to store JSON object's string retrieved from {@link clientOptions}.
     *
     * @var string
     */
    protected $_jsonClientOptions = null;

    /**
     * Retrieves an asset URL of ElFinder's initialization script.
     *
     * @return string
     */
    public function getInitJsUrl()
    {
        if ($this->_initJsUrl === null)
        {
            $this->_initJsUrl = Yii::app()->getAssetManager()->publish(
                dirname(__FILE__) . "/js/elFinderInit.js"
            );
        }

        return $this->_initJsUrl;
    }

    /**
     * Retrieves an asset URL of ElFinder's files directory.
     *
     * @return string
     */
    public function getElFinderAssetsUrl()
    {
        if ($this->_elFinderAssetsUrl === null)
        {
            $this->_elFinderAssetsUrl = Yii::app()->getAssetManager()->publish(
                dirname(__FILE__) . "/assets"
            );
        }

        return $this->_elFinderAssetsUrl;
    }

    /**
     * Retrieves an asset URL of ElFinder's CSS directory.
     *
     * @return string
     */
    public function getElFinderCssUrl()
    {
        if ($this->_elFinderCssUrl === null)
            $this->_elFinderCssUrl = $this->elFinderAssetsUrl . "/css";

        return $this->_elFinderCssUrl;
    }

    /**
     * Retrieves an asset URL of ElFinder's scripts directory.
     *
     * @return string
     */
    public function getElFinderJsUrl()
    {
        if ($this->_elFinderJsUrl === null)
            $this->_elFinderJsUrl = $this->elFinderAssetsUrl . "/js";

        return $this->_elFinderJsUrl;
    }

    /**
     * Retrieves a string representation of JSON object with ElFinder's
     * client configuration options.
     *
     * @return string
     */
    public function getJsonClientOptions()
    {
        if ($this->_jsonClientOptions === null)
            $this->_jsonClientOptions = json_encode($this->clientOptions);
        return $this->_jsonClientOptions;
    }

    /**
     * Initializes the widget preparing an URL to ElFinder's connector.
     */
    public function init()
    {
        if ($this->connectorRoute !== null && is_string($this->connectorRoute)
                && $this->connectorOptions !== null && is_array($this->connectorOptions))
        {
            $connectorOptionsSerialized = serialize($this->connectorOptions);
            $connectorOptionsEncoded = base64_encode($connectorOptionsSerialized);
            $this->clientOptions['url'] = Yii::app()->createUrl($this->connectorRoute, array(
                ElFinderConnectorAction::GET_PARAM_ELFINDER_CONNECTOR_OPTIONS => $connectorOptionsEncoded
            ));
        }
    }

    /**
     * Runs the widget rendering a template.
     */
    public function run()
    {
        $this->render("elfinder");
    }
}