@checkout
Feature: Addressing an order
    In order to address an order
    As a Guest
    I want to be able to fill addressing details

    Background:
        Given the store operates on a single channel in "United States"
        And the store ships everywhere for Free
        And the store has a product "PHP T-Shirt" priced at "$19.99"

    @api @ui @javascript
    Scenario: Address an order without different shipping address
        When I add product "PHP T-Shirt" to the cart
        And I go to the checkout addressing step
        And I specify the email as "jon.snow@example.com"
        And I specify the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        Then I should be on the checkout shipping step

    @api @ui @mink:chromedriver
    Scenario: Address an order with different shipping address
        When I add product "PHP T-Shirt" to the cart
        And I go to the checkout addressing step
        And I specify the email as "eddard.stark@example.com"
        And I specify the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Eddard Stark"
        And I specify the shipping address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        Then I should be on the checkout shipping step

    @api @ui @javascript
    Scenario: Address an order using existing email
        Given the store has customer "eddard.stark@example.com"
        When I add product "PHP T-Shirt" to the cart
        And I go to the checkout addressing step
        When I specify the email as "eddard.stark@example.com"
        And I specify the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        Then I should be on the checkout shipping step
