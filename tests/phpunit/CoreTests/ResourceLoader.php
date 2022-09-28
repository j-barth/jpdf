<?php
namespace CoreTests;

class ResourceLoader {

    const BASE_RESOURCE_EXPECTED_PATH = '/Resources/Expected/';

    public function getFromResource($filePath) {
        return file_get_contents(__DIR__ . '/..' .self::BASE_RESOURCE_EXPECTED_PATH . $filePath, 'r');
    }
}
