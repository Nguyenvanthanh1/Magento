<?php

namespace Tigren\CustomerGroupCatalog\Model;

use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;
use Tigren\CustomerGroupCatalog\Api\Data\RuleInterface;
use Tigren\CustomerGroupCatalog\Api\RuleRepositoryInterface;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Rule;

/**
 * Class RuleRepository
 * @package Tigren\CustomerGroupCatalog\Model
 */
class RuleRepository implements RuleRepositoryInterface
{
    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var Rule
     */
    protected $ruleResource;

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @param RuleFactory $ruleFactory
     * @param Rule $ruleResource
     */
    public function __construct(RuleFactory $ruleFactory, Rule $ruleResource)
    {
        $this->ruleFactory = $ruleFactory;
        $this->ruleResource = $ruleResource;
    }


    /**
     * @param RuleInterface $rule
     * @return mixed|RuleInterface|\Tigren\CustomerGroupCatalog\Model\Rule
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(RuleInterface $rule)
    {
        if ($rule->getRuleId()) {
            $rule = $this->get($rule->getRuleId()->addData($rule->getData()));
        }
        try {
            $this->ruleResource->save($rule);
            unset($this->rules[$rule->getRuleId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('The "%1" rule was unable to be saved. Please try again.',
                $rule->getRuleId()));
        }
        return $rule;
    }


    /**
     * @param $ruleId
     * @return mixed|RuleInterface|\Tigren\CustomerGroupCatalog\Model\Rule
     * @throws NoSuchEntityException
     */
    public function get($ruleId)
    {
        if (!isset($this->rules[$ruleId])) {
            $rule = $this->ruleFactory->create();
            $rule->load($ruleId);
            if (!$rule->getRuleId()) {
                throw new NoSuchEntityException(__('The rule with the "%1" ID wasn\'t found. Verify the ID and try again.',
                    $ruleId));
            }
            $this->rules[$ruleId] = $rule;
        }
        return $this->rules[$ruleId];
    }


    /**
     * @param $ruleId
     * @return true
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($ruleId)
    {
        $model = $this->get($ruleId);
        $this->delete($model);
        return true;
    }


    /**
     * @param RuleInterface $rule
     * @return true
     * @throws CouldNotDeleteException
     */
    public function delete(RuleInterface $rule)
    {
        try {
            $this->ruleResource->delete($rule);
            unset($this->rules[$rule->getId()]);
        } catch (ValidatorException $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('The "%1" rule couldn\'t be removed.', $rule->getRuleId()));
        }
        return true;
    }
}
