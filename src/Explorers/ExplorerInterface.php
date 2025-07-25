<?php

namespace Mitoop\Crypto\Explorers;

interface ExplorerInterface
{
    public function address(string $chain, string $address): string;

    public function transaction(string $chain, string $txId): string;
}
