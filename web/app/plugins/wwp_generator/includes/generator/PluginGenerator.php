<?php

namespace WonderWp\Plugin\Generator;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\DBAL\Schema\MySqlSchemaManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\ORM\Tools\SchemaTool;
use WonderWp\APlugin\AbstractEntity;
use WonderWp\DI\Container;
use WonderWp\Forms\Fields\HiddenField;
use WonderWp\Forms\Fields\InputField;
use WonderWp\Forms\Fields\TextAreaField;
use WonderWp\Forms\Form;
use WonderWp\Plugin\Faq\FaqEntity;

class PluginGenerator{

    protected $_data;

    protected $_container;
    protected $_folders;

    public function __construct()
    {
        $this->_container = Container::getInstance();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->_data['table'] = $table;
    }

    public function getPluginForm($data){
        $container = Container::getInstance();

        /** @var Form $form */
        $form = $container->offsetGet('wwp.forms.form');

        //Table
        $f = new HiddenField('table', !empty($data['table']) ? $data['table'] : null);
        $form->addField($f);

        //Plugin Name
        $f = new InputField('name', !empty($data['name']) ? $data['name'] : null, ['label'=>'Nom du plugin']);
        $form->addField($f);

        //Plugin Description
        $f = new TextAreaField('desc', !empty($data['desc']) ? $data['desc'] : null, ['label'=>'Description']);
        $form->addField($f);

        //Namespace
        $f = new InputField('namespace', !empty($data['namespace']) ? $data['namespace'] : null, ['label'=>'Namespace']);
        $form->addField($f);

        return $form;
    }

    public function generate(){
        $this->_createFolders()
            ->_generateBootsrtapFile()
            ->_generateManager()
            ->_generateActivator()
            ->_generateDeActivator()

            ->_generateEntity()
            ->_generateForm()
            ->_generateListTable()

            ->_generateLanguages()
        ;
    }

    protected function _createFolders(){
        \WonderWp\trace($this->_data);
        $this->_folders = array();
        $this->_folders['base'] = WP_PLUGIN_DIR.'/'.sanitize_title($this->_data['name']);
        $this->_folders['includes'] = $this->_folders['base'].'/includes';

        if(!empty($this->_folders)){ foreach ($this->_folders as $folder){
            if(!is_dir($folder)){ mkdir($folder,0777,true); }
        }}

        return $this;
    }

    protected function _generateBootsrtapFile(){
        return $this;
    }

    protected function _generateManager(){
        return $this;
    }

    protected function _generateActivator(){
        return $this;
    }

    protected function _generateDeActivator(){
        return $this;
    }

    protected function _generateEntity(){
        /** @var EntityManager $em */
        $em = $this->_container->offsetGet('entityManager');
        /*$cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em);

        $metaDatas = $cmf->getAllMetadata();*/

        $schemaManager = $em->getConnection()->getSchemaManager();
        $driver = new DatabaseDriver($schemaManager);

        $className = $this->_data['namespace'].'\\'.Inflector::classify(strtolower($this->_data['table']));
        $driver->setClassNameForTable($this->_data['table'],$className);


        $metas = new ClassMetadata($className);
        $metas->namespace = $this->_data['namespace'];
        $driver->loadMetadataForClass($className,$metas);
        \WonderWp\trace($metas);

        $metaDatas=array();
        $metaDatas[] = $metas;

        $entityGenerator = new EntityGenerator();
        $entityGenerator->setGenerateAnnotations(true);
        $entityGenerator->setGenerateStubMethods(true);
        $entityGenerator->setRegenerateEntityIfExists(true);
        $entityGenerator->setUpdateEntityIfExists(true);
        $entityGenerator->setNumSpaces(true);
        $entityGenerator->setClassToExtend(AbstractEntity::class);
        $entityGenerator->generate($metaDatas, $this->_folders['includes']);
        return $this;
    }

    protected function _generateForm(){
        return $this;
    }

    protected function _generateListTable(){
        return $this;
    }

    protected function _generateLanguages(){
        return $this;
    }


}