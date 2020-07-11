<?php

namespace App\Services;

use App\Contracts\HashGenerationService;
use App\Contracts\UrlService;
use App\Url as UrlModel;
use DateTime;
use Illuminate\Support\Facades\Auth;

/**
 * Class Url
 * @package App\Services
 *
 * @property string hash
 * @property string original_url
 * @property DateTime expiration_date
 * @property string custom_alias
 * @property User user
 */
class Url implements UrlService
{
    private HashGenerationService $hashService;

    /**
     * Url constructor.
     * @param HashGenerationService $hashService
     */
    public function __construct(HashGenerationService $hashService)
    {
        $this->hashService = $hashService;
    }

    public function create(
        string $apiDevKey,
        string $originalUrl,
        ?string $customAlias,
        ?DateTime $expireDate
    ): UrlModel {
        $url = new UrlModel([
            'hash' => $this->hashService->createHash(),
            'original_url' => $originalUrl,
            'expiration_date' => $expireDate,
            'custom_alias' => $customAlias,
            'user_id' => Auth::user()->id,
        ]);

        $url->saveOrFail();

        return $url;
    }

    /**
     * @param string $apiDevKey
     * @param string $urlKey
     */
    public function delete(string $apiDevKey, string $urlKey): void
    {
        $url = UrlModel::findOrFail($urlKey);
        $url->delete();
    }

    /**
     * @param string $apiDevKey
     * @param string $hash
     * @return UrlModel
     */
    public function load(string $apiDevKey, string $hash): UrlModel
    {
        return UrlModel::findOrFail($hash);
    }

    /**
     * @param string $urlKey
     * @return string
     */
    public function findOriginalUrlByUrlKey(string $urlKey): string
    {
        /** @var UrlModel $url */
        $url = UrlModel::query()
            ->where('hash', $urlKey)
            ->orWhere('custom_alias', $urlKey)
            ->firstOrFail();

        return $url->original_url;
    }
}
