<?php
/**
 * @author      Tsvetan Stoychev <t.stoychev@extendix.com>
 * @website     http://www.extendix.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */

class Extendix_CouponImport_Model_SimpleImport
    extends Mage_Dataflow_Model_Convert_Container_Abstract
{

    public function parse()
    {
        $batchModel = Mage::getSingleton('dataflow/batch');
        /* @var $batchModel Mage_Dataflow_Model_Batch */

        $batchImportModel = $batchModel->getBatchImportModel();
        $importIds = $batchImportModel->getIdCollection();

        foreach ($importIds as $importId) {
            $batchImportModel->load($importId);
            $importData = $batchImportModel->getBatchData();

            $this->saveRow($importData);
        }
    }

    /**
     * @param array $data
     */
    public function saveRow(array $data)
    {
        /** @var Extendix_CouponImport_Model_Import_SalesRule $salesRuleImportModel */
        $salesRuleImportModel = Mage::getSingleton('extendix_coupon_import/import_salesRule');
        $salesRuleImportModel->createCouponSpecificSkus($data);
    }

}