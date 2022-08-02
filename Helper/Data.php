<?php
/**
 * AC Tecnology.
 *
 * @category  AC Tecnology
 * @package   Actecnology_CustomerTotalPurchase
 * @author    AC Tecnology www.actecnologies.com
 * @copyright Copyright (c) AC Tecnology Software Private Limited
 */
namespace Actecnology\CustomerTotalPurchase\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\Customer;
use Magento\Ui\Component\Listing\Columns\Column;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class Data extends AbstractHelper
{
	public $customerCollection;
	private $formKey;
	private $storeManager;
	private $stockRegistry;
	private $categoryRepository;
	private $customerSession;
	private $sessionManager;
	private $httpContext;
	private $category;
    
    protected $orderCollectionFactory;
	private $objectManager = null;
    private $instanceName = null;

	public function __construct(
		Customer $customerCollection,
		\Magento\Framework\App\ResourceConnection $resource,
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Session\SessionManager $sessionManager,
		\Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
		\Magento\Catalog\Model\CategoryRepository $categoryRepository,
		\Magento\Framework\App\Http\Context $httpContext,
		\Magento\Framework\Data\Form\FormKey $formKey,
		\Magento\Catalog\Model\Category $category,
		\Magento\Framework\Registry $registry,

		///Para consultar atributo de producto
		\Magento\Catalog\Model\ProductRepository $productRepo,

		//Product image
		\Magento\Catalog\Helper\Image $imageHelper,

        //para product
        CollectionFactory  $orderCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = \Magento\Sales\Model\ResourceModel\Order\Collection::class
	)
	{
		$this->_connection = $resource->getConnection();
		$this->customerCollection = $customerCollection;
		$this->formKey = $formKey;
		$this->category = $category;
		$this->storeManager = $storeManager;
		$this->stockRegistry = $stockRegistry;
		$this->categoryRepository = $categoryRepository;
		$this->customerSession = $customerSession;
		$this->sessionManager = $sessionManager;
		$this->httpContext = $httpContext;
		///Para consultar atributo de producto
		$this->_productRepo = $productRepo;
		$this->_registry = $registry;
		//Product collection
		$this->imageHelper = $imageHelper;

        //product
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;

		parent::__construct($context);
	}

	// obetener las ordenes
    public function getCustomerOrder($customerId = null){

        /** @var \Magento\Sales\Model\ResourceModel\Order\Collection $collection */
        $collection = $this->objectManager->create($this->instanceName);

        if ($customerId) {
            $collection->addFieldToFilter('customer_id', $customerId);
			// $collection->addFieldToFilter('status', array('neq' => 'canceled'));
        }

        return $collection;
    }

	// las ordenes sin las canceladas
	public function getCustomerOrderTwo($customerId = null){

		if ($customerId) {
			
			$connection = $this->_connection;
			$stockTable = $connection->getTableName('sales_order');
			$query = "SELECT sum(grand_total) FROM ".$stockTable." WHERE customer_id = ".$customerId;
			$result = $connection->fetchOne($query);
		}

		return $result;
	}
}
?>
