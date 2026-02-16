<?php

class ModuleWs extends ObjectModel
{
    public $id_module;
    public $name;
    public $active;
    public static $definition = array(
        'table' => 'module',
        'primary' => 'id_module',
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
        ),
    );

    protected $webserviceParameters = [
        'objectNodeName' => 'bl_modules',
        'objectsNodeName' => 'bl_modules',
        'fields' => [
            'display_name' => ['getter' => 'getDisplayName'],
            'tab' => ['getter' => 'getTab'],
        ],
    ];

    public function getId()
    {
        return $this->id_module;
    }

    public function getDisplayName()
    {
        return Module::getInstanceByName($this->name)->displayName;
    }

    public function getTab()
    {
        return Module::getInstanceByName($this->name)->tab;
    }
}