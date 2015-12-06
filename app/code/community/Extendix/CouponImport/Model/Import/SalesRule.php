<?php
/**
 * @author      Tsvetan Stoychev <t.stoychev@extendix.com>
 * @website     http://www.extendix.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */

class Extendix_CouponImport_Model_Import_SalesRule
{
    /** @var \Extendix_CouponImport_Model_Import_SalesRule_Action  */
    private $_actionModel;

    /** @var \Extendix_CouponImport_Model_Import_SalesRule_CustomerGroup  */
    private $_customerGroupModel;

    /** @var \Extendix_CouponImport_Model_Import_SalesRule_Website  */
    private $_websiteModel;

    /**
     * Simple constructor (adding dependencies)
     */
    public function __construct()
    {
        $this->_actionModel        = Mage::getModel('extendix_coupon_import/import_salesRule_action');
        $this->_customerGroupModel = Mage::getModel('extendix_coupon_import/import_salesRule_customerGroup');
        $this->_websiteModel       = Mage::getModel('extendix_coupon_import/import_salesRule_website');
    }

    /**
     * @param array $data
     */
    public function createCouponSpecificSkus(array $data)
    {
        $data['coupon_type'] = Mage_SalesRule_Model_Rule::COUPON_TYPE_SPECIFIC;

        $this->_actionModel->prepareAction($data);
        $this->_websiteModel->prepareWebsite($data);
        $this->_customerGroupModel->prepareCustomerGroup($data);

        /** @var Mage_SalesRule_Model_Rule $rule */
        $rule = Mage::getModel('salesrule/rule');

        //Native Magento way for creating coupons
        $rule->loadPost($data);
        $rule->save();
    }

}