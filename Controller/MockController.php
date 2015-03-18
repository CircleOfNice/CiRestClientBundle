<?php

namespace Ci\CurlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Provides methods for routes with http methods POST, GET, PUT, DELETE
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class MockController extends Controller {

    /**
     * mockup method for post requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function postAction(Request $request) {
        $httpCode = $request->getContent() ? $request->query->get('httpCode') : 400;
        return $this->response($request->__toString(), $httpCode);
    }

    /**
     * mockup method for put requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function putAction(Request $request) {
        $httpCode = $request->getContent() ? $request->query->get('httpCode') : 400;
        return $this->response($request->__toString(), $httpCode);
    }

    /**
     * mockup method for get requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function getAction(Request $request) {
        return $this->response($request->__toString(), $request->query->get('httpCode'));
    }

    /**
     * mockup method for delete requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function deleteAction(Request $request) {
        return $this->response($request->__toString(), $request->query->get('httpCode'));
    }

    /**
     * mockup method for patch requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function patchAction(Request $request) {
        $httpCode = $request->getContent() ? $request->query->get('httpCode') : 400;
        return $this->response($request->__toString(), $httpCode);
    }

    /**
     * mockup method for head requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function headAction(Request $request) {
        return $this->response('', $request->query->get('httpCode'));
    }

    /**
     * mockup method for options requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function optionsAction(Request $request) {
        return $this->response($request->__toString(), $request->query->get('httpCode'));
    }

    /**
     * mockup method for connect requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function connectAction(Request $request) {
        $httpCode = $request->getContent() ? $request->query->get('httpCode') : 400;
        return $this->response($request->__toString(), $httpCode);
    }

    /**
     * mockup method for trace requests (only used for tests)
     *
     * @param  Request $request
     * @return Response
     */
    public function traceAction(Request $request) {
        $httpCode = $request->getContent() ? $request->query->get('httpCode') : 400;
        return $this->response($request->__toString(), $httpCode);
    }

    /**
     * returns a new empty response
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
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