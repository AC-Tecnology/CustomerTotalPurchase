<?php
/**
 * AC Tecnology.
 *
 * @category  AC Tecnology
 * @package   Actecnology_CustomerTotalPurchase
 * @author    AC Tecnology www.actecnologies.com
 * @copyright Copyright (c) AC Tecnology Software Private Limited
 */
namespace Actecnology\CustomerTotalPurchase\Ui\Component\Listing\Column;

use Actecnology\CustomerTotalPurchase\Helper\Data;
use \Magento\Sales\Api\OrderRepositoryInterface;    //order
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;//

class TotalPurchase extends Column
{
    //protected $orderCollectionFactory;
    /**
     * 
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array              $components
     * @param array              $data
     * @param CollectionFactory  $orderCollectionFactory
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        CollectionFactory  $orderCollectionFactory,//
        OrderRepositoryInterface $orderRepository,  //order
        Data $myData
    ) {

        $this->_orderRepository = $orderRepository; // order
        $this->orderCollectionFactory = $orderCollectionFactory;//
        $this->helper = $myData;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                $order  = $this->_orderRepository->get($item["entity_id"]);
				if($order->getCustomerId()){

                    // First form
                    $total = 0;
                    $customerOrder = $this->orderCollectionFactory->create()->addFieldToFilter('customer_id', $item['entity_id'])
                                        ->addFieldToFilter('status', array('neq' => 'canceled'));

                    foreach($customerOrder as $order){
                        $total += $order->getGrandTotal();
                        //$total += $order->getBaseGrandTotal();
                    }
                    $total;
                    $item[$this->getData('name')] = number_format($total, 2, ',', ' ');
                    //$item[$this->getData('name')] = count($customerOrder);//Value which you want to display

                    // second form
                    // $customerOrder = $this->helper->getCustomerOrder();
                    // $item[$this->getData('name')] = count($customerOrder);

                    // third form
                    // $customerId = $order->getCustomerId();
                    // $customerOrder = $this->helper->getCustomerOrderTwo($customerId); //select
                    // $item[$this->getData('name')] = $customerOrder;

                }
            }
        }
        return $dataSource;
    }
}