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

namespace Sylius\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\Element\Admin\TaxCategory\FormElementInterface;
use Sylius\Behat\Page\Admin\Crud\CreatePageInterface;
use Sylius\Behat\Page\Admin\Crud\IndexPageInterface;
use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface;
use Sylius\Component\Taxation\Model\TaxCategoryInterface;
use Webmozart\Assert\Assert;

final readonly class ManagingTaxCategoriesContext implements Context
{
    public function __construct(
        private IndexPageInterface $indexPage,
        private CreatePageInterface $createPage,
        private UpdatePageInterface $updatePage,
        private FormElementInterface $formElement,
    ) {
    }

    /**
     * @When I want to create a new tax category
     */
    public function iWantToCreateNewTaxCategory(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I specify its code as :code
     * @When I do not specify its code
     */
    public function iSpecifyItsCodeAs(?string $code = null): void
    {
        $this->formElement->setCode($code ?? '');
    }

    /**
     * @When I specify a too long :field
     */
    public function iSpecifyATooLongCode(string $field): void
    {
        $this->formElement->fillElement(str_repeat('a', 256), $field);
    }

    /**
     * @When I name it :name
     * @When I rename it to :name
     * @When I do not name it
     * @When I remove its name
     */
    public function iNameIt($name = null): void
    {
        $this->formElement->setName($name ?? '');
    }

    /**
     * @When I describe it as :description
     */
    public function iDescribeItAs($description): void
    {
        $this->formElement->setDescription($description);
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @When I want to modify a tax category :taxCategory
     * @When /^I want to modify (this tax category)$/
     */
    public function iWantToModifyTaxCategory(TaxCategoryInterface $taxCategory): void
    {
        $this->updatePage->open(['id' => $taxCategory->getId()]);
    }

    /**
     * @Given I am browsing tax categories
     * @When I browse tax categories
     */
    public function iWantToBrowseTaxCategories(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I check (also) the :taxCategoryName tax category
     */
    public function iCheckTheTaxCategory(string $taxCategoryName): void
    {
        $this->indexPage->checkResourceOnPage(['nameAndDescription' => $taxCategoryName]);
    }

    /**
     * @When I delete them
     */
    public function iDeleteThem(): void
    {
        $this->indexPage->bulkDelete();
    }

    /**
     * @When I delete tax category :taxCategory
     */
    public function iDeletedTaxCategory(TaxCategoryInterface $taxCategory): void
    {
        $this->indexPage->open();
        $this->indexPage->deleteResourceOnPage(['code' => $taxCategory->getCode()]);
    }

    /**
     * @Then /^(this tax category) should no longer exist in the registry$/
     */
    public function thisTaxCategoryShouldNoLongerExistInTheRegistry(TaxCategoryInterface $taxCategory): void
    {
        Assert::false($this->indexPage->isSingleResourceOnPage(['code' => $taxCategory->getCode()]));
    }

    /**
     * @Then I should see the tax category :taxCategoryName in the list
     * @Then the tax category :taxCategoryName should appear in the registry
     */
    public function theTaxCategoryShouldAppearInTheRegistry(string $taxCategoryName): void
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['nameAndDescription' => $taxCategoryName]));
    }

    /**
     * @Then I should not be able to edit its code
     */
    public function iShouldNotBeAbleToEditItsCode(): void
    {
        Assert::true($this->formElement->isCodeDisabled());
    }

    /**
     * @Then /^(this tax category) name should be "([^"]+)"$/
     * @Then /^(this tax category) should still be named "([^"]+)"$/
     */
    public function thisTaxCategoryNameShouldBe(TaxCategoryInterface $taxCategory, $taxCategoryName): void
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage(['code' => $taxCategory->getCode(), 'nameAndDescription' => $taxCategoryName]));
    }

    /**
     * @Then I should be notified that tax category with this code already exists
     */
    public function iShouldBeNotifiedThatTaxCategoryWithThisCodeAlreadyExists(): void
    {
        Assert::same($this->formElement->getValidationMessage('code'), 'The tax category with given code already exists.');
    }

    /**
     * @Then there should still be only one tax category with :element :code
     */
    public function thereShouldStillBeOnlyOneTaxCategoryWith($element, $code): void
    {
        $this->indexPage->open();
        Assert::true($this->indexPage->isSingleResourceOnPage([$element => $code]));
    }

    /**
     * @Then I should be notified that :element is required
     */
    public function iShouldBeNotifiedThatIsRequired($element): void
    {
        Assert::same($this->formElement->getValidationMessage($element), sprintf('Please enter tax category %s.', $element));
    }

    /**
     * @Then tax category with :element :name should not be added
     */
    public function taxCategoryWithElementValueShouldNotBeAdded($element, $name): void
    {
        $this->indexPage->open();
        Assert::false($this->indexPage->isSingleResourceOnPage([$element => $name]));
    }

    /**
     * @Then I should see a single tax category in the list
     * @Then I should see :amount tax categories in the list
     */
    public function iShouldSeeTaxCategoriesInTheList(int $amount = 1): void
    {
        Assert::same($this->indexPage->countItems(), $amount);
    }

    /**
     * @Then I should see the tax category :taxCategoryName
     */
    public function IShouldSeeTheTaxCategory(string $taxCategoryName): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['nameAndDescription' => $taxCategoryName]));
    }

    /**
     * @Then I should not see the tax category :taxCategoryName
     */
    public function IShouldNotSeeTheTaxCategory(string $taxCategoryName): void
    {
        Assert::false($this->indexPage->isSingleResourceOnPage(['nameAndDescription' => $taxCategoryName]));
    }

    /**
     * @Then I should be notified that :field is too long
     */
    public function iShouldBeNotifiedThatIsTooLong(string $field): void
    {
        Assert::contains(
            $this->formElement->getValidationMessage($field),
            'must not be longer than 255 characters.',
        );
    }
}
