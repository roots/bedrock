<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 22/09/2016
 * Time: 17:16
 */

namespace WonderWp\Plugin\Vote;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Cookie;
use WonderWp\API\Result;
use WonderWp\DI\Container;
use WonderWp\Forms\FormValidator;
use WonderWp\HttpFoundation\Request;
use WonderWp\Services\AbstractService;

class VoteHandlerService extends AbstractService
{
    public function handleSubmit($data, $formInstance)
    {
        $container = Container::getInstance();

        $uid = $this->_getUid($data);
        unset($data['entityToken']);
        $data['uid'] = $uid;
        $data['data'] = json_encode(array(
            'ip'=>$this->_getRealIpAddr()
        ));

        /** @var EntityManager $em */
        $em = $container->offsetGet('entityManager');

        $canUserVoteResult = $this->_canUserVote($data);
        if ($canUserVoteResult->getCode() !== 200) {
            return $canUserVoteResult;
        }

        /** @var FormValidator $formValidator */
        $formValidator = $container->offsetGet('wwp.forms.formValidator');
        $errors = $formValidator->setFormInstance($formInstance)->validate($data);
        if (!empty($errors)) {
            return new Result(403, ['msg' => implode("\n", $errors)]);
        }

        if (empty($errors)) {
            $vote = !empty($canUserVoteResult->getData('vote')) ? $canUserVoteResult->getData('vote') : new VoteEntity();
            $vote->populate($data);
            $em->persist($vote);
            $em->flush();
        }
        return new Result(200);
    }

    private function _getUid($data)
    {
        $uid = $data['entityToken'];
        if ($uid === md5(true)) {
            //No token -> generate and save token
            $uid = uniqid();
        } else {
            $uid = str_replace(md5(false), '', $uid);
        }

        //restore everywhere
        $this->_storeUid($uid);

        return $uid;
    }

    private function _canUserVote($data)
    {

        if(empty($data['uid'])){
            return new Result(403, ['msg' => 'Missing Uid']);
        }

        //check md5
        $check = (md5(sha1($data['entityname'] . '/' . $data['entityid'] . '/' . $data['post']))) === $data['entityChck'];
        if (!$check) {
            return new Result(403, ['msg' => 'Check not valid']);
        }

        //Check already voted
        $vote = $this->_checkAlreadyVoted($data);
        $alreadyVoted = is_object($vote);
        if ($alreadyVoted) {
            return new Result(200, ['msg' => 'Vote Updated','vote'=>$vote]);
        }

        return new Result(200);
    }

    public function _getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private function _storeUid($uid){
        $uidKey = md5('wwp-vote');
        $uidKey2 = strrev($uidKey);

        $request = Request::getInstance();

        //set in session
        $request->getSession()->set($uidKey, $uid);

        //set in cookie
        $cookie = new Cookie($uidKey, $uid, time() + (60 * 60 * 24 * 7 * 30 * 6)); //Expires in 6 months
        setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime());

        //set in second cookie
        $cookie2 = new Cookie($uidKey2, $uid, time() + (60 * 60 * 24 * 7 * 30 * 6)); //Expires in 6 months
        setcookie($cookie2->getName(), $cookie2->getValue(), $cookie2->getExpiresTime());

        return $this;
    }

    private function _checkAlreadyVoted($data){
        $vote = null;
        //Find By entityname, entity id, and uid
        $container = Container::getInstance();

        /** @var EntityManager $em */
        $em = $container->offsetGet('entityManager');

        /** @var EntityRepository $repository */
        $repository = $em->getRepository(VoteEntity::class);

        $attrs = [
            "entityname" => $data['entityname'],
            "entityid" => $data['entityid'],
            "uid" => $data['uid']
        ];

        $votes = $repository->findBy($attrs);

        if(!empty($votes)){
            /** @var VoteEntity $vote */
            $vote = reset($votes);
        }
        return $vote;
    }
}