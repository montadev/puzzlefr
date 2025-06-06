@paying_for_order
Feature: Informing customer about any order total changes during checkout process
    In order to inform the customer about any changes that affect order total
    As a Customer
    I want to be prevented from placing order with invalid order total

    Background:
        Given the store operates on a single channel in "United States"
        And the store has "NA VAT" tax rate of 23% for "Clothes" within the "US" zone
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And it belongs to "Clothes" tax category
        And the store ships everywhere for Free
        And the store allows paying Offline

    @api @ui
    Scenario: Informing customer about order total change due to product price change
        Given I am a logged in customer
        And I added product "PHP T-Shirt" to the cart
        And I proceeded through checkout process
        And this product price has been changed to "$25.00"
        And I confirm my order
        Then my order should not be placed due to changed order total

    @api @ui
    Scenario: Being able to confirm order after information appears
        Given I am a logged in customer
        And I added product "PHP T-Shirt" to the cart
        And I proceeded through checkout process
        And this product price has been changed to "$25.00"
        When I confirm my order
        Then my order should not be placed due to changed order total

    @api @ui
    Scenario: Informing customer about order total change due to tax change
        Given I am a logged in customer
        And I added product "PHP T-Shirt" to the cart
        And I proceeded through checkout process
        And the "NA VAT" tax rate has changed to 10%
        When I confirm my order
        Then my order should not be placed due to changed order total

    @api @ui @mink:chromedriver
    Scenario: Informing customer about order total change due to shipping method fee change
        Given the store has "UPS" shipping method with "$20.00" fee
        When I add product "PHP T-Shirt" to the cart
        And I complete addressing step with email "guest@example.com" and "United States" based billing address
        And I proceed with "UPS" shipping method and "Offline" payment
        And the shipping fee for "UPS" shipping method has been changed to "$30.00"
        And I confirm my order
        Then my order should not be placed due to changed order total
