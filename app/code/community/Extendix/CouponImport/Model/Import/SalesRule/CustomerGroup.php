<?php
/**
 * @author      Tsvetan Stoychev <t.stoychev@extendix.com>
 * @website     http://www.extendix.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */

class Extendix_CouponImport_Model_Import_SalesRule_CustomerGroup
{

    const ALL_GROUPS_STRING           = 'all';
    const CUSTOMER_GROUP_DELIMITER    = ',';
    const CUSTOMER_GROUP_IDS_DATA_KEY = 'customer_group_ids';

    /** @var null|array */
    private $_customerGroups;

    /**
     * @param array $data
     */
    public function prepareCustomerGroup(array &$data)
    {
        $customerGroupIds = $data[self::CUSTOMER_GROUP_IDS_DATA_KEY];

        if (self::ALL_GROUPS_STRING === $customerGroupIds) {
            $data[self::CUSTOMER_GROUP_IDS_DATA_KEY] = $this->_getAllCustomerGroups();
        } else {
            $data[self::CUSTOMER_GROUP_IDS_DATA_KEY] = explode(self::CUSTOMER_GROUP_DELIMITER, $customerGroupIds);
        }
    }

    /**
     * @return null|array
     */
    private function _getAllCustomerGroups()
    {
        if (null === $this->_customerGroups) {
            $this->_customerGroups = array();

            //get all customer groups
            $customerGroups = Mage::getModel('customer/group')->getCollection();

            foreach ($customerGroups as $group) {
                $this->_customerGroups[] = $group->getId();
            }
        }

        return $this->_customerGroups;
    }

}