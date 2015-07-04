<?php
/**
 * This source file is copyrighted by Tamas Imrei <tamas.imrei@gmail.com>.
 * @author Tamas Imrei <tamas.imrei@gmail.com>
 */
namespace Imrei\AddRest\Controller;

use Imrei\AddRest\Components\Request;
use Imrei\AddRest\Components\Response;
use Imrei\AddRest\Exceptions\Http\HttpNotFoundException;
use Imrei\AddRest\Services\AddressService;
use Imrei\AddRest\Model\Entity\Address;
use Imrei\AddRest\View\Interfaces\Renderable;
use Imrei\AddRest\View\Interfaces\ContentTypeable;
use Imrei\AddRest\View\JSONView;

/**
 * Controller class mapping HTTP methods to object methods
 */
class AddressController
{
    /**
     * @var AddressService
     */
    protected $service;

    /**
     * This controller depends on the AddressService
     *
     * @param AddressService $service
     */
    public function __construct(AddressService $service)
    {
        $this->service = $service;
    }

    /**
     * Get one entity by its ID as an array
     *
     * @param Request $request
     * @return array
     * @throws HttpNotFoundException
     */
    public function getOneAction(Request $request)
    {
        $addressId = $request->getHttpGetParam('id');
        if (empty($addressId)) {
            throw new HttpNotFoundException();
        }

        $address = $this->service->getEntityById(intval($addressId));
        if (empty($address)) {
            throw new HttpNotFoundException();
        }
        $addressArray = $this->service->convertEntityToArray($address);

        $view = $this->makeView($request);
        return $this->makeResponse($view, $addressArray);
    }

    /**
     * Compile response object with the View selected
     *
     * @param object $view the View to be used for the response
     * @param mixed $data data to be rendered by the View
     * @return Response
     */
    protected function makeResponse($view, $data)
    {
        $response = new Response();

        if ($view instanceof Renderable) {
            $response->setBody($view->render($data));
        }

        if ($view instanceof ContentTypeable) {
            $response->addHeader('Content-type', $view->getContentType());
        }

        return $response;
    }

    /**
     * Make a View object based on the request
     *
     * Could be extended to handle XML or other data formats, based on
     * the request's Accept header, but now it only supports JSON View.
     *
     * @param Request $request
     * @return Renderable|JSONView
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function makeView(Request $request)
    {
        return new JSONView();
    }
}
