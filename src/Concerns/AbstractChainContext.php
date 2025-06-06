<?php

namespace Mitoop\Crypto\Concerns;

use Mitoop\Crypto\Contracts\ChainContextInterface;
use Mitoop\Crypto\RpcProviders\RpcProviderFactory;
use Mitoop\Crypto\Support\Http\BizResponseInterface;
use Mitoop\Crypto\Support\Http\HttpRequestClient;
use Mitoop\Crypto\Support\Http\Response;
use Mitoop\Crypto\Wallets\Factory;
use Mitoop\Crypto\Wallets\Wallet;

/**
 * @method BizResponseInterface|Response postJson($endpoint, $jsonData = [], $headers = [])
 */
abstract class AbstractChainContext implements ChainContextInterface
{
    use HttpRequestClient;

    public function __construct(protected array $config) {}

    public function config(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    public function getExplorerUrl(): string
    {
        return rtrim($this->config('explorer_url'), '/');
    }

    public function generateWallet(): Wallet
    {
        return Factory::create($this->config('chain'))->generate();
    }

    public function validateAddress(string $address): bool
    {
        return Factory::create($this->config('chain'))->validate($address);
    }

    protected function getGuzzleOptions(): array
    {
        return RpcProviderFactory::create($this->config)->getGuzzleOptions();
    }
}
