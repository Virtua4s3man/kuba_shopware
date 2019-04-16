<?php

namespace VirtuaPocztaPolska;

use Doctrine\Common\Collections\ArrayCollection;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Models\Country\Country;
use Shopware\Models\Dispatch\Dispatch;
use Shopware\Models\Dispatch\ShippingCost;
use Shopware\Models\Payment\Payment;

/**
 * Shopware-Plugin VirtuaPocztaPolska.
 */
class VirtuaPocztaPolska extends Plugin
{
    public function install(InstallContext $context)
    {
        $modelManager = $this->container->get('models');
        $dispatch = $this->createPocztaPolskaDispatch($modelManager);
        $modelManager->persist($dispatch);
        $modelManager->flush();
    }

    /**
     * @param $modelManager
     * @return Dispatch
     */
    private function createPocztaPolskaDispatch($modelManager)
    {
        $shippingMethod = new Dispatch();
        $shippingMethod->setName('Poczta Polska');
        $shippingMethod->setDescription('');
        $shippingMethod->setComment('');
        $shippingMethod->setTaxCalculation(0);
        $shippingMethod->setBindLastStock(0);
        $shippingMethod->setPosition(1);
        $shippingMethod->setActive(true);

        $shippingMethod->setMultiShopId(null);
        $shippingMethod->setCustomerGroupId(null);

        $shippingMethod->setPayments(
            $this->getPayments($modelManager)
        );
        $shippingMethod->setType(0);
        $shippingMethod->setSurchargeCalculation(0);

        $shippingMethod->setCalculation(0);
        $shippingMethod->setCostsMatrix(
            $this->createCostMatrix()
        );

        $shippingMethod->setCountries(
            $this->getEuropeanCountries($modelManager)
        );

        $shippingMethod->setBindWeekdayFrom(1);
        $shippingMethod->setBindWeekdayTo(5);

        $shippingMethod->setShippingFree(100);

        return $shippingMethod;
    }

    /**
     * @param ModelManager $modelManager
     *
     * @return ArrayCollection
     */
    private function getPayments(ModelManager $modelManager)
    {
        $payments = $modelManager->createQueryBuilder()
            ->select('payments')
            ->from(Payment::class, 'payments')
            ->getQuery()
            ->execute();

        return $payments;
    }

    /**
     * @param $modelManager
     * @return mixed
     */
    private function getEuropeanCountries(ModelManager $modelManager)
    {
        $countries = $modelManager->createQueryBuilder()
            ->select('countries')
            ->from(Country::class, 'countries')
            ->leftJoin('countries.area', 'area')
            ->where('area.name = :country')
            ->setParameter(':country', 'europa')
            ->getQuery()
            ->execute();

        return $countries;
    }

    /**
     * @return array
     */
    private function createCostMatrix()
    {
        $costMatrix = [];
        $shippingCost = new ShippingCost();
        $shippingCost->setFrom(0);
        $shippingCost->setValue(5);
        $shippingCost->setFactor(0.00);
        $costMatrix[] = $shippingCost;

        $shippingCost = new ShippingCost();
        $shippingCost->setFrom(11);
        $shippingCost->setValue(10);
        $shippingCost->setFactor(0.00);
        $costMatrix[] = $shippingCost;

        return $costMatrix;
    }
}
