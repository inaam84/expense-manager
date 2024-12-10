<?php

namespace App\Http\Controllers\Filepond;

use App\Http\Controllers\Controller;
use App\Services\FilepondService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FilepondController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['web', 'auth']);
    }

    /**
     * FilePond ./process route logic.
     *
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request, FilepondService $service)
    {
        // Check if chunk upload
        if ($request->hasHeader('upload-length')) {
            return Response::make($service->initChunk(), \Illuminate\Http\Response::HTTP_OK, ['content-type' => 'text/plain']);
        }

        $validator = $service->validator($request, config('filesystems.filepond_validation_rules', []));

        if ($validator->fails()) {
            return Response::make($validator->errors(), \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return Response::make($service->store($request), \Illuminate\Http\Response::HTTP_OK, ['content-type' => 'text/plain']);
    }

    /**
     * FilePond ./patch route logic.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function patch(Request $request, FilepondService $service)
    {
        return Response::make('Ok', \Illuminate\Http\Response::HTTP_OK)->withHeaders(['upload-offset' => $service->chunk($request)]);
    }

    /**
     * FilePond ./head route logic.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function head(Request $request, FilepondService $service)
    {
        return Response::make('Ok', \Illuminate\Http\Response::HTTP_OK)->withHeaders(['upload-offset' => $service->offset($request->patch)]);
    }

    /**
     * FilePond ./revert route logic.
     *
     * @return \Illuminate\Http\Response
     */
    public function revert(Request $request, FilepondService $service)
    {
        $filepond = $service->retrieve($request->getContent());

        $service->delete($filepond);

        return Response::make('Ok', \Illuminate\Http\Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}
