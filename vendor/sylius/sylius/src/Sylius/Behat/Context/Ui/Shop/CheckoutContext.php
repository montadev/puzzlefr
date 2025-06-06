<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use Sylius\Behat\Context\Ui\Shop\Checkout\CheckoutAddressingContext;
use Sylius\Behat\Context\Ui\Shop\Checkout\CheckoutPaymentContext;
use Sylius\Behat\Context\Ui\Shop\Checkout\CheckoutShippingContext;
use Sylius\Behat\Element\Shop\Account\RegisterElementInterface;
use Sylius\Behat\Page\Shop\Account\RegisterPageInterface;
use Sylius\Behat\Page\Shop\Checkout\AddressPageInterface;
use Sylius\Behat\Page\Shop\Checkout\CompletePageInterface;
use Sylius\Behat\Page\Shop\Checkout\SelectPaymentPageInterface;
use Sylius\Behat\Page\Shop\Checkout\SelectShippingPageInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

final readonly class CheckoutContext implements Context
{
    public function __construct(
        private AddressPageInterface $addressPage,
        private SelectPaymentPageInterface $selectPaymentPage,
        private SelectShippingPageInterface $selectShippingPage,
        private CompletePageInterface $completePage,
        private RegisterPageInterface $registerPage,
        private RegisterElementInterface $registerElement,
        private CurrentPageResolverInterface $currentPageResolver,
        private CheckoutAddressingContext $addressingContext,
        private CheckoutShippingContext $shippingContext,
        private CheckoutPaymentContext $paymentContext,
        private SharedStorageInterface $sharedStorage,
    ) {
    }

    /**
     * @Given I was at the checkout summary step
     */
    public function iWasAtTheCheckoutSummaryStep(): void
    {
        $this->addressingContext->iSpecifiedTheBillingAddress();
        $this->iProceedOrderWithShippingMethodAndPayment('Free', 'Offline');
    }

    /**
     * @Given I have proceeded selecting :paymentMethodName payment method
     * @When I proceed with selecting :paymentMethodName payment method
     */
    public function iProceedSelectingPaymentMethod(string $paymentMethodName): void
    {
        $this->addressingContext->iSpecifiedTheBillingAddress();
        $this->shippingContext->iCompleteTheShippingStep();
        $this->paymentContext->iChoosePaymentMethod($paymentMethodName);
    }

    /**
     * @Given I have proceeded order with :shippingMethodName shipping method and :paymentMethodName payment
     * @Given I proceeded with :shippingMethodName shipping method and :paymentMethodName payment
     * @Given I proceeded with :shippingMethodName shipping method and :paymentMethodName payment method
     * @When I proceed with :shippingMethodName shipping method and :paymentMethodName payment
     */
    public function iProceedOrderWithShippingMethodAndPayment(string $shippingMethodName, string $paymentMethodName): void
    {
        if (!$this->selectShippingPage->isOpen()) {
            $this->selectShippingPage->open();
        }

        $this->selectShippingPage->selectShippingMethod($shippingMethodName);
        $this->selectShippingPage->nextStep();

        $this->selectPaymentPage->selectPaymentMethod($paymentMethodName ?: 'Offline');
        $this->selectPaymentPage->nextStep();
    }

    /**
     * @Given I have proceeded through checkout process in the :localeCode locale with email :email
     * @Given I have proceeded through checkout process
     * @When I proceed through checkout process
     * @When I proceeded through checkout process
     * @When I proceed through checkout process in the :localeCode locale
     * @When I proceed through checkout process in the :localeCode locale with email :email
     */
    public function iProceedThroughCheckoutProcess(string $localeCode = 'en_US', ?string $email = null): void
    {
        $this->addressingContext->iProceedSelectingBillingCountry(null, $localeCode, $email);
        $this->shippingContext->iCompleteTheShippingStep();
        $this->paymentContext->iCompleteThePaymentStep();
    }

    /**
     * @Given I have proceeded through checkout process with :shippingMethod shipping method
     * @When I proceed through checkout with :shippingMethod shipping method
     */
    public function iHaveProceededThroughCheckoutProcessWithShippingMethod(ShippingMethodInterface $shippingMethod): void
    {
        $this->addressingContext->iProceedSelectingBillingCountry();
        $this->shippingContext->iHaveProceededWithSelectingShippingMethod($shippingMethod->getName());
        if ($this->selectPaymentPage->isOpen()) {
            $this->paymentContext->iCompleteThePaymentStep();
        }

        $this->sharedStorage->set('shipping_method', $shippingMethod);
    }

    /**
     * @When I proceed with selecting :shippingMethodName shipping method
     */
    public function iProceedWithSelectingShippingMethod(string $shippingMethodName): void
    {
        $this->addressingContext->iProceedSelectingBillingCountry();
        $this->shippingContext->iHaveProceededWithSelectingShippingMethod($shippingMethodName);
    }

    /**
     * @When I go to the addressing step
     */
    public function iGoToTheAddressingStep(): void
    {
        if ($this->selectShippingPage->isOpen()) {
            $this->selectShippingPage->changeAddressByStepLabel();

            return;
        }

        if ($this->selectPaymentPage->isOpen()) {
            $this->selectPaymentPage->changeAddressByStepLabel();

            return;
        }

        if ($this->completePage->isOpen()) {
            $this->completePage->changeAddress();

            return;
        }

        throw new UnexpectedPageException('It is impossible to go to addressing step from current page.');
    }

    /**
     * @When I go to the shipping step
     */
    public function iGoToTheShippingStep(): void
    {
        if ($this->selectPaymentPage->isOpen()) {
            $this->selectPaymentPage->changeShippingMethodByStepLabel();

            return;
        }

        if ($this->completePage->isOpen()) {
            $this->completePage->changeShippingMethod();

            return;
        }

        throw new UnexpectedPageException('It is impossible to go to shipping step from current page.');
    }

    /**
     * @Then the subtotal of :item item should be :price
     */
    public function theSubtotalOfItemShouldBe($item, $price)
    {
        /** @var AddressPageInterface|SelectPaymentPageInterface|SelectShippingPageInterface|CompletePageInterface $currentPage */
        $currentPage = $this->currentPageResolver->getCurrentPageWithForm([
            $this->addressPage,
            $this->selectPaymentPage,
            $this->selectShippingPage,
            $this->completePage,
        ]);

        Assert::eq($currentPage->getItemSubtotal($item), $price);
    }

    /**
     * @Then I should not be able to change email
     */
    public function iShouldNotBeAbleToChangeEmail(): void
    {
        Assert::false($this->addressPage->hasEmailInput());
    }

    /**
     * @When I register with previously used :email email and :password password
     */
    public function iRegisterWithPreviouslyUsedEmailAndPassword(string $email, string $password): void
    {
        $this->registerPage->open();
        $this->registerElement->specifyEmail($email);
        $this->registerElement->specifyPassword($password);
        $this->registerElement->verifyPassword($password);
        $this->registerElement->specifyFirstName('Carrot');
        $this->registerElement->specifyLastName('Ironfoundersson');
        $this->registerElement->register();
    }
}
