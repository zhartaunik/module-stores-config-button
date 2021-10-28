# Overview.

This micro module allows you easily create a button for admin area to hang some action on it.

# How to.

## Create controller with the validation. 
Create a route if doesn't exist:
> app/code/Vendor/Module/adminhtml/routes.xml
```xml
<router id="admin">
    <route id="some_name" frontName="some_name">
        <module name="Vendor_Module" before="Magento_Backend" />
    </route>
</router>
```
Create your empty controller class
> app/code/Vendor/Module/Controller/Adminhtml/System/Config/TestBasicAuth.php
```php
class TestBasicAuth extends \PerfectCode\StoresConfigButton\Controller\Adminhtml\System\Config\AbstractTestConnection
{
}
```

Implement `PerfectCode\StoresConfigButton\Api\TestConnectionInterface` with the validation code.
> app/code/Vendor/Module/Model/Client/Command/TestBasicAuthorization.php
```php
/**
 * Verifies basic authorization.
 */
class TestBasicAuthorization implements TestConnectionInterface
{
    public function execute(): bool
    {
        // some code ...
        
        return true;
    }
}
```

Push validator to your controller:
> app/code/Vendor/Module/adminhtml/di.xml
```xml
    <type name="Vendor\Module\Controller\Adminhtml\System\Config\TestBasicAuth">
        <arguments>
            <argument name="testConnection" xsi:type="object">Vendor\Module\Model\Client\Command\TestBasicAuthorization</argument>
        </arguments>
    </type>
```

## Add button to the configuration.
Create new virtual type for the frontend_model:
> app/code/Vendor/Module/adminhtml/di.xml
```xml
    <virtualType name="BasicAuthTestConnection" type="PerfectCode\StoresConfigButton\Block\Adminhtml\System\Config\TestBasicAuth">
        <arguments>
            <argument name="data" xsi:type="array">
                <item name="button_label" xsi:type="string">Some button label.</item>
                <item name="connection_failed_message" xsi:type="string">Some fail message.</item>
                <item name="empty_message" xsi:type="string">Some message.</item>
                <item name="fields_to_test" xsi:type="array">
                    <item name="field1" xsi:type="string">section_name_group_name_field1</item>
                    <item name="field2" xsi:type="string">section_name_group_name_field2</item>
                </item>
            </argument>
        </arguments>
    </virtualType>
```

Add the button to system.xml (config_path should contain the path to your controller):

Controller action to execute ajax call. Consist of following parts:
* Defined in adminhtml.routes.xml
* Path to the file Controller/Adminhtml/System/Config/TestBasicAuthorization.php skipping Controller/Adminhtml and file name
* File name (Action name) TestBasicAuthorization.php
> app/code/Vendor/Module/adminhtml/system.xml
```xml
<field id="test_basic_auth" sortOrder="10" showInDefault="1" showInWebsite="1" showInStore="0">
    <label />
    <frontend_model>BasicAuthTestConnection</frontend_model>
    <config_path>some_name/system_config/TestBasicAuth</config_path>
</field>
```
