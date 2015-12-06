<?php
/**
 * @author      Tsvetan Stoychev <t.stoychev@extendix.com>
 * @website     http://www.extendix.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */

class Extendix_CouponImport_Model_Import_SalesRule_Website
{

    const ALL_WEBSITES_STRING  = 'all';
    const WEBSITE_DELIMITER    = ',';
    const WEBSITE_IDS_DATA_KEY = 'website_ids';

    /** @var null|array */
    private $_websites;

    /**
     * @param array $data
     */
    public function prepareWebsite(array &$data)
    {
        $websiteIds = $data[self::WEBSITE_IDS_DATA_KEY];

        if (self::ALL_WEBSITES_STRING === $websiteIds) {
            $data[self::WEBSITE_IDS_DATA_KEY] = $this->_getAllWebsites();
        } else {
            $data[self::WEBSITE_IDS_DATA_KEY] = explode(self::WEBSITE_DELIMITER, $websiteIds);
        }
    }

    /**
     * @return array|null
     */
    private function _getAllWebsites()
    {
        if (null === $this->_websites) {
            //get all websites
            $websites = Mage::getModel('core/website')->getCollection();
            $this->_websites = array();

            foreach ($websites as $website){
                $this->_websites[] = $website->getId();
            }
        }

        return $this->_websites;
    }

}