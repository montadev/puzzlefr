@checkout
Feature: Preventing skipping checkout steps
    In order to get back to the right checkout step after leaving
    As a Customer
    I want to be able to finish checkout process

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And the store has a product "Paganini T-Shirt" priced at "$10.00"
        And there is a promotion "Holiday promotion"
        And the promotion gives "$29.99" discount to every order with quantity at least 2
        And the store ships everywhere for Free
        And the store allows paying Offline
        And I am a logged in customer

    @no-api @ui
    Scenario: Skipping shipping checkout step
        Given I added product "PHP T-Shirt" to the cart
        And I addressed the cart
        When I want to complete checkout
        Then I should be on the checkout shipping step

    @no-api @ui
    Scenario: Skipping payment checkout step
        Given I added product "PHP T-Shirt" to the cart
        And I addressed the cart
        When I want to complete the shipping step
        And I have selected "Free" shipping method
        And I complete the shipping step
        And I want to complete checkout
        Then I should be on the checkout payment step

    @no-api @ui
    Scenario: Skipping addressing checkout step
        Given I added product "PHP T-Shirt" to the cart
        And I am at the checkout addressing step
        When I want to complete checkout
        Then I should be on the checkout addressing step

    @no-api @ui
    Scenario: Skipping addressing checkout step when order total is zero
        When I add product "PHP T-Shirt" to the cart
        And I have product "Paganini T-Shirt" in the cart
        And I am at the checkout addressing step
        When I want to complete checkout
        Then I should be on the checkout addressing step

    @no-api @ui
    Scenario: Not being able to skip the checkout shipping selection step when order total is zero
        When I add product "PHP T-Shirt" to the cart
        And I have product "Paganini T-Shirt" in the cart
        And I specified the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        When I want to complete checkout
        Then I should be on the checkout shipping step

    @no-api @ui
    Scenario: Not being able go to payment checkout step when order total is zero and payments not exists
        Given I added product "PHP T-Shirt" to the cart
        And I added product "Paganini T-Shirt" to the cart
        And I addressed the cart
        When I want to complete checkout
        And I have selected "Free" shipping method
        And I complete the shipping step
        And I want to pay for order
        Then I should be on the checkout complete step
