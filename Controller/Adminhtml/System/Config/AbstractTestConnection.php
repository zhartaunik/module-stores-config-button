<?php
declare(strict_types=1);

namespace PerfectCode\StoresConfigButton\Controller\Adminhtml\System\Config;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use PerfectCode\StoresConfigButton\Api\TestConnectionInterface;

/**
 * Controller used for testing connection from stores configuration.
 */
abstract class AbstractTestConnection extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Magento_Config::config_system';

    /**
     * @var TestConnectionInterface
     */
    private TestConnectionInterface $testConnection;

    /**
     * TestConnection constructor.
     *
     * @param Context $context
     * @param TestConnectionInterface $testConnection
     */
    public function __construct(Context $context, TestConnectionInterface $testConnection)
    {
        parent::__construct($context);
        $this->testConnection = $testConnection;
    }

    /**
     * Execute test API key value request.
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        try {
            $isConnected = $this->testConnection->execute();
            $message = $isConnected ? __('Connection Successful!') : __('Connection Failed!');
        } catch (Exception $e) {
            $message = __('An error occurred during connection');
            $isConnected = false;
        }

        /** @var Json $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $result->setData([
            'success' => $isConnected,
            'message' => $message->render(),
        ]);
    }
}
