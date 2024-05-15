<?php

namespace CongnqNexlesoft\MaintenanceMode\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    /**
     * force response and END current process
     *
     * @param $data
     * @param int $responseCode
     *
     * @return void
     */
    private function forceResponse($data, int $responseCode = Response::HTTP_OK): void
    {
        // handle CORS here
        $this->manualHandleCORSHeader();
        // response json
        header('Content-Type: text/html; charset=UTF-8');
        http_response_code($responseCode);
        echo $data;
        //
        die(); // END here
    }

    /**
     * force response Json and END current process
     *
     * @param $data
     * @param int $responseCode
     *
     * @return void
     */
    private function forceResponseJson($data, int $responseCode = Response::HTTP_OK): void
    {
        // handle CORS here
        $this->manualHandleCORSHeader();
        // response json
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($responseCode);
        echo json_encode($data);
        //
        die(); // END here
    }

    /**
     * will add a header Access-Control-Allow-Origin if needed
     * @return void
     */
    private function manualHandleCORSHeader()
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? null;
        $nelmio_cors_bundle_CORS_ALLOW_ORIGIN = getenv('CORS_ALLOW_ORIGIN') ?? null;
        if ($origin && $nelmio_cors_bundle_CORS_ALLOW_ORIGIN) {
            if (preg_match('{' . $nelmio_cors_bundle_CORS_ALLOW_ORIGIN . '}i', $origin)) {
                // handle The origin '$origin' is allowed
                header("Access-Control-Allow-Origin: $origin");
            } else {
                // handle The origin '$origin' is not allowed
            }
        } else {
            // handle no origin was sent, or no CORS_ALLOW_ORIGIN was setting
        }
    }


}
