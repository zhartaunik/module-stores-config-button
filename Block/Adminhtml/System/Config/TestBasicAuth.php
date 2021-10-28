<?php
declare(strict_types=1);

namespace PerfectCode\StoresConfigButton\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * This class is used for store_config element, for it's front_model to render the button.
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @method string|null getConnectionFailedMessage()
 * @method string|null getButtonLabel()
 * @method string[] getFieldsToTest()
 * @method string getConfigPath()
 *
 * getConfigPath: Controller action to execute ajax call. Consist of following parts:
 * #1 Defined in adminhtml/routes.xml
 * #2 Path to the file Controller/Adminhtml/System/Config/TestConnection.php skipping Controller/Adminhtml and file
 * name
 * #3 File name (Action name) TestConnection.php
 */
class TestBasicAuth extends Field
{
    /**
     * @inheritdoc
     */
    protected $_template = 'PerfectCode_StoresConfigButton::system/config/test_connection.phtml';

    /**
     * Remove element scope and render form element as HTML.
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $element->setData('scope', null);
        return parent::render($element);
    }

    /**
     * Get the button and scripts contents
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $this->addData(
            [
                'config_path' => __($element->getOriginalData()['config_path']),
            ]
        );

        return $this->_toHtml();
    }

    /**
     * Get test connection url.
     *
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->_urlBuilder->getUrl(
            $this->getConfigPath(),
            [
                'form_key' => $this->getFormKey(),
            ]
        );
    }
}
