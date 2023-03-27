<?php

namespace Tigren\Testimonial\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Ui\Component\MassAction\Filter;
use Tigren\Testimonial\Model\ResourceModel\Question\CollectionFactory;
use Tigren\Testimonial\Model\QuestionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    protected $filter;

    protected $questionCollectionFactory;

    protected $questionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $questionCollectionFactory,
        QuestionFactory $questionFactory
    ) {
        $this->filter = $filter;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->questionCollectionFactory->create());
            $totalCount = 0;
            foreach ($collection as $item) {
                /** @var \Tigren\Testimonial\Model\Question $item */
                $data = $this->questionFactory->create()->load($item->getId());
                $data->delete();
                $totalCount++;
            }
            $this->messageManager->addSuccess(__('A total of %1 question(s) have been deleted.', $totalCount));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
