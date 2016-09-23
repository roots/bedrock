<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 17:09
 */

namespace WonderWp\Plugin\Contact;


use Doctrine\ORM\EntityManager;
use WonderWp\DI\Container;
use WonderWp\Mail\WwpMail;
use WonderWp\Mail\WwpMailer;
use WonderWp\Mail\WwpWpMailer;
use WonderWp\Services\AbstractService;

class ContactHandlerService extends AbstractService
{
    public function handleSubmit($data, $formInstance, $formItem)
    {
        $sent = false;

        $container = Container::getInstance();
        /** @var EntityManager $em */
        $em = $container->offsetGet('entityManager');

        $data['datetime'] = new \DateTime();
        $data['locale'] = get_locale();
        $data['form'] = $formItem;
        //\WonderWp\trace($data);

        /** @var FormValidator $formValidator */
        $formValidator = $container->offsetGet('wwp.forms.formValidator');
        $errors = $formValidator->setFormInstance($formInstance)->validate($data);
        if (empty($errors)) {
            $contact = new ContactEntity();
            $contact->populate($data);

            //Save Contact
            //\WonderWp\trace($contact);
            $em->persist($contact);
            $em->flush();
            //\WonderWp\trace($contact);

            //Send Email
            $sent = $this->_sendContactMail($contact);
        }
        return $sent;
    }

    private function _sendContactMail(ContactEntity $contactEntity)
    {
        $mailSent = false;
        $container = Container::getInstance();

        /** @var WwpWpMailer $mail */
        $mail = $container->offsetGet('wwp.emails.mailer');

        //Set Mail From
        list($fromMail, $fromName) = $this->_getMailFrom($contactEntity);
        $mail->setFrom($fromMail, $fromName);

        //Set Reply To as well
        $mail->setReplyTo($fromMail,$fromName);

        //Set Mail To
        $toMail = $this->_getMailTo($contactEntity);
        if (!empty($toMail)) {
            //Several email founds
            if (strpos($toMail, ',') !== false) {
                $toMails = explode(',', $toMail);
                if (!empty($toMails)) {
                    foreach ($toMails as $mail) {
                        $mail->addTo($mail, $mail);
                    }
                }
            } else {
                $toName = $toMail;
                $mail->addTo($toMail, $toName);
            }
        } else {
            //Erreur pas de dest
        }

        /**
         * Subject
         */
        $subject = 'Test sub';
        $mail->setSubject($subject);

        /**
         * Body
         */
        $body = $this->_getBody($contactEntity);
        $mail->setBody($body);

        //$mail->addBcc('jeremy.desvaux+bcc@wonderful.fr','JD BCC');
        //$mail->addCc('jeremy.desvaux+cc@wonderful.fr','JD CC');

        /**
         * Envoi
         */
        $sent = $mail->send();

        return $sent;
    }

    /**
     * If contact detail in form, use them
     * Else, use site contact from
     */
    private function _getMailFrom(ContactEntity $contactEntity)
    {
        //Did the user provide a mail address in the form?
        $from = $contactEntity->getMail();
        if (!empty($from)) {
            $fromMail = $from;
            //Did the user provide his last name or first name in the form?
            if (!empty($contactEntity->getNom())) {
                $fromName = $contactEntity->getNom();
                if (!empty($contactEntity->getPrenom())) {
                    $fromName = $contactEntity->getPrenom() . ' ' . $contactEntity->getNom();
                }
            } else {
                $fromName = $fromMail;
            }
        } else {
            //Use info saved in the website settings
            $fromMail = get_option('wonderwp_email_frommail');
            $fromName = get_option('wonderwp_email_fromName');
        }
        return array($fromMail, $fromName);
    }

    /**
     * if subject and subject dest -> send to subject dest
     * else if form dest -> send to form dest
     * else -> send to site dest
     */
    private function _getMailTo(ContactEntity $contactEntity)
    {
        $formEntity = $contactEntity->getForm();
        $toMail = '';
        $subject = $contactEntity->getSujet();
        if (!empty($subject)) {
            $formData = is_object($formEntity) ? $formEntity->getData() : null;
            if (!empty($formData)) {
                $formData = json_decode($formData);
            }
            if (!empty($formData) && !empty($formData->sujet) && !empty($formData->sujet->sujets)) {
                $sujets = $formData->sujet->sujets;
                $chosenSubject = !empty($sujets->{$subject}) ? $sujets->{$subject} : null;
                if (!empty($chosenSubject) && !empty($chosenSubject->dest)) {
                    $toMail = $chosenSubject->dest;
                }
            }
        }
        //No dest found in subject
        if (empty($toMail)) {
            $toMail = $formEntity->getSendTo();
        }
        //No dest found in form entity
        if (empty($toMail)) {
            $toMail = get_option('wonderwp_email_tomail');
        }
        return $toMail;
    }

    private function _getBody(ContactEntity $contactEntity)
    {
        //\WonderWp\trace($contactEntity);
        $mailContent = '
        <h2>'.__('new.contact.msg.title',WWP_CONTACT_TEXTDOMAIN).'</h2>
        <p>'.__('new.contact.msg.intro',WWP_CONTACT_TEXTDOMAIN).': </p>
        <div>';
        //Add contact infos
        $infosChamps = array_keys($contactEntity->getFields());
        $unnecessary = array('id','post','datetime','locale','sentto');

        if(!empty($infosChamps)){ foreach ( $infosChamps as $column_name ) {
            if(!in_array($column_name,$unnecessary)) {
                $val = stripslashes(str_replace('\r\n','<br />',$contactEntity->{$column_name}));
                $label = __($column_name . '.trad', WWP_CONTACT_TEXTDOMAIN);
                if(!empty($val)){
                    $mailContent.='<p><strong>'.$label.':</strong> <span>'.stripslashes($val).'</span></p>';
                }
            }
        }}
        $mailContent .= '
                    </div>
                    <p>'.__('contact.msg.registered.bo',WWP_CONTACT_TEXTDOMAIN).'</p>
                    ';

        return $mailContent;
    }
}