<?php

namespace toubilib\core\application\ports\spi\exceptions\Interface;

interface JwtManagerInterface {

    const ACCESS_TOKEN = 3600;
    const REFRESH_TOKEN = 86400;

    public function create(array $payload, int $type): string;

}