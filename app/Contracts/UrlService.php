<?php

namespace App\Contracts;

use App\Url;
use DateTime;

interface UrlService
{
    /**
     * @param string $apiDevKey
     * @param string $hash
     * @return Url
     */
    public function load(string $apiDevKey, string $hash): Url;

    /**
     * @param string $apiDevKey
     * @param string $originalUrl
     * @param string $customAlias
     * @param DateTime $expireDate
     * @return mixed
     */
    public function create(
        string $apiDevKey,
        string $originalUrl,
        ?string $customAlias,
        ?DateTime $expireDate
    ): Url;

    /**
     * @param string $apiDevKey
     * @param string $urlKey
     * @return mixed
     */
    public function delete(string $apiDevKey, string $urlKey): void;

    /**
     * @param string $urlKey
     * @return string
     */
    public function findOriginalUrlByUrlKey(string $urlKey): string;
}
