<?php
declare(strict_types=1);

namespace PerfectCode\StoresConfigButton\Api;

/**
 * @api
 *
 * Check some endpoint.
 */
interface TestConnectionInterface
{
    /**
     * In this method you should verify your endpoint accessibility.
     *
     * You may use params from $_REQUEST (they should be passed in di.xml with param 'fields_to_test')
     *
     * @return bool
     */
    public function execute(): bool;
}
