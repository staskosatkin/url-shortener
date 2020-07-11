<?php

namespace App\Http\Controllers\API;

use App\Contracts\UrlService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUrl;
use App\Http\Requests\ShowUrl;
use App\Http\Requests\StoreUrl;
use Illuminate\Http\Response;

class UrlController extends Controller
{
    private UrlService $urlService;

    /**
     * UrlController constructor.
     * @param UrlService $urlService
     */
    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * @param ShowUrl $request
     * @return Response
     */
    public function show(ShowUrl $request): Response
    {
        $url = $this->urlService->load(
            $request->getApiDevKey(),
            $request->getHash()
        );

        return new Response($url->toJson(), Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUrl $request
     * @return Response
     */
    public function create(StoreUrl $request): Response
    {
        $urlModel = $this->urlService->create(
            $request->getApiDevKey(),
            $request->getOriginUrl(),
            $request->getCustomAlias(),
            $request->getExpireDate()
        );

        return new Response($urlModel->toJson(), Response::HTTP_CREATED, [
            'Content-Type' => 'application/json',
            'location' => route('show', ['urlKey' => $urlModel->hash]),
        ]);
    }

    public function delete(DeleteUrl $request): Response
    {
        $this->urlService->delete(
            $request->getApiDevKey(),
            $request->getHash()
        );

        return new Response('', Response::HTTP_NO_CONTENT);
    }

}
