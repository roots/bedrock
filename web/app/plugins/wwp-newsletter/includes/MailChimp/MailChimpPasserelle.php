<?php

namespace WonderWp\Plugin\Newsletter\MailChimp;

use Doctrine\ORM\EntityManager;
use WonderWp\DI\Container;
use WonderWp\Forms\Fields\EmailField;
use WonderWp\Forms\Fields\HiddenField;
use WonderWp\Forms\Form;
use WonderWp\Plugin\Newsletter\AbstractPasserelle;
use WonderWp\Plugin\Newsletter\NewsletterEntity;

/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 19/09/2016
 * Time: 16:17
 */
class MailChimpPasserelle extends AbstractPasserelle
{

    /**
     * @var MailChimp
     */
    private $_mailChimpWrapper;

    /**
     * MailChimpPasserelle constructor.
     * @param $_mailChimpWrapper
     */
    public function __construct()
    {
        $mcApiKey = get_option('cleApiMC');
        if(!empty($mcApiKey)) {
            $_mailChimpWrapper = new MailChimp($mcApiKey);
            $this->_mailChimpWrapper = $_mailChimpWrapper;
        }
    }


    public function getOptions()
    {
        $options = array(
            array("desc" => __("Options MailChimp"),
                "type" => "title"),

            array("name" => __('Clé API MailChimp'),
                "desc" => __('Numéro d\'identification pour ce site auprès du service MailChimp'),
                "id" => "cleApiMC",
                "std" => '',
                "type" => "text"),
        );
        return $options;
    }

    public function syncListes()
    {
        /** @var \wpdb $wpdb */
        global $wpdb;
        $result = $this->_mailChimpWrapper->get('lists');

        if (!empty($result['lists'])) {

            //Empty Table
            /** @var EntityManager $entityManager */
            $entityManager = Container::getInstance()->offsetGet('entityManager');
            $connection = $entityManager->getConnection();
            $platform = $connection->getDatabasePlatform();

            $connection->executeUpdate($platform->getTruncateTableSQL($wpdb->prefix . 'wwp_nllist', true /* whether to cascade */));

            //Read each list
            foreach ($result['lists'] as $listData) {
                //\WonderWp\trace($listData);
                $saveData = array(
                    'postUrl'=>$listData['subscribe_url_long']
                );
                $list = new NewsletterEntity();
                $list
                    ->setId($listData['id'])
                    ->setTitle($listData['name'])
                    ->setSubscribers($listData['stats']['member_count'])
                    ->setData($saveData)
                    ;
                $entityManager->persist($list);
            }
            $entityManager->flush();
        }
    }

    public function getSignupForm(NewsletterEntity $list)
    {
        /** @var Form $form */
        $form = Container::getInstance()->offsetGet('wwp.forms.form');
        /*$form = new NoewpFormulaire();
        $form->action = $posturl;
        $form->id = "mc-embedded-subscribe-form";
        if (empty($listid)) {
            $form->disabled = true;
        }
        $form->attributs['target'] = '_top';*/

        $f = new HiddenField('LIST_ID', $list->getId());
        $form->addField($f);

        $f = new EmailField('EMAIL',null,['label'=>__('subscribe.label.trad',WWP_NEWSLETTER_TEXTDOMAIN)]);
        $form->addField($f);

        $savedData = $list->getData();
        $postUrl=$savedData->postUrl;

        $opts = array(
            'formStart'=>array(
                'action'=>$postUrl,
                'id'=>'mc-embedded-subscribe-form',
                'target'=>'_top'
            )
        );
        return $form->renderView($opts);

    }
}