<?php
/**
 * @author      Tsvetan Stoychev <t.stoychev@extendix.com>
 * @website     http://www.extendix.com
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 */
class Extendix_CouponImport_Model_Import_SalesRule_Action
{

    const SKU_DATA_KEY    = 'sku';
    const SKU_DELIMITER   = ',';
    const ACTION_DATA_KEY = 'actions';

    /**
     * @param array $data
     */
    public function prepareAction(array &$data)
    {
        if(isset($data[self::SKU_DATA_KEY])) {
            $data[self::ACTION_DATA_KEY] = $this->_getSkuAction($data[self::SKU_DATA_KEY]);
            unset($data[self::SKU_DATA_KEY]);
        }
    }

    /**
     * Constructs SalesRule action which conditions matches
     * single or multiple skus that could be valid for specific coupon
     *
     * Basically this is workaround and it has a lot of hardcoded data
     * but so far there is no need do more because the goal is to have
     * very simple functionality ... could be written better in future
     * if there is a need (so far so good)
     *
     * @param string $sku
     * @return array
     */
    private function _getSkuAction($sku)
    {
        $operator = count(explode(self::SKU_DELIMITER, $sku)) > 1 ? '()' : '==';

        $actions =
            array(
                '1' => array(
                    'type' => 'salesrule/rule_condition_combine',
                    'aggregator' => 'all',//any
                    'value' => '1',
                    'new_child' => ''
                ),
                '1--1' => array(
                    'type' => 'salesrule/rule_condition_product',
                    'attribute' => 'sku',
                    'operator' => $operator,
                    'value' => $sku
                )
            );

        return $actions;
    }

}