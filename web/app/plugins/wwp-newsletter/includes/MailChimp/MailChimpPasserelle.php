<?php

namespace WonderWp\Plugin\Newsletter\MailChimp;

use Doctrine\ORM\EntityManager;
use Respect\Validation\Validator;
use WonderWp\API\Result;
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

        $f = new HiddenField('LIST_ID', $list->getId());
        $form->addField($f);

        $placeholder = __('subscribe.placeholder.trad',WWP_NEWSLETTER_TEXTDOMAIN);
        $displayRules = [
            'label'=>__('subscribe.label.trad',WWP_NEWSLETTER_TEXTDOMAIN)
        ];
        if(!empty($placeholder)){
            $displayRules['inputAttributes'] = array('placeholder'=>$placeholder);
        }
        $validationRules = array(Validator::notEmpty());
        $f = new EmailField('EMAIL',null,$displayRules,$validationRules);
        $form->addField($f);

        return $form;

    }

    public function handleFormSubmit(array $data)
    {

        if(empty($data['LIST_ID']) || empty($data['EMAIL'])){
            return new Result('403',['msg'=>"Missing List or Email"]);
        }

        $postRes = $this->_mailChimpWrapper->post("lists/".$data['LIST_ID']."/members", [
            'email_address' => $data['EMAIL'],
            'status'        => 'subscribed',
        ]);

        if($postRes['status']=='subscribed'){
            return new Result(200);
        } else {
            return new Result($postRes['status'],['msg'=>$postRes['title']]);
        }
    }
}