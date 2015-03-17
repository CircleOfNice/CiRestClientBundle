<?php

namespace Ci\CurlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Provides methods for routes with http methods POST, GET, PUT, DELETE
 *
 * @author    CiGurus <gurus@groups.teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class MockController extends Controller {

    /**
     * mockup method for post requests (only used for tests)
     */
    public function postAction(Request $request) {
        $httpCode = $request->getContent() ? $request->query->get('httpCode') : 400;
        return $this->response($request->__toString(), $httpCode);
    }

    /**
     * mockup method for put requests (only used for tests)
     */
    public function putAction(Request $request) {
        $httpCode = $request->getContent() ? $request->query->get('httpCode') : 400;
        return $this->response($request->__toString(), $httpCode);
    }

    /**
     * mockup method for get requests (only used for tests)
     */
    public function getAction(Request $request) {
        return $this->response($request->__toString(), $request->query->get('httpCode'));
    }

    /**
     * mockup method for delete requests (only used for tests)
     */
    public function deleteAction(Request $request) {
        return $this->response($request->__toString(), $request->query->get('httpCode'));
    }

    /**
     * returns a new empty response
     *
     * @param  string $content
     * @param  int    $httpCode
     * @return Response
     */
    private function response($content, $httpCode) {
        $httpCode = empty($httpCode) ? 200 : $httpCode;
        return new Response($content, $httpCode);
    }
}