@checkout
Feature: Checking out as guest with a registered email
    In order to make the checkout process less cumbersome
    As a Visitor
    I want to be able to checkout with my email although I have a registered account

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And the store ships everywhere for Free
        And the store allows paying Offline
        And there is a customer account "john@example.com"

    @api @ui @javascript
    Scenario: Successfully placing an order
        When I add product "PHP T-Shirt" to the cart
        And I complete addressing step with email "john@example.com" and "United States" based billing address
        And I select "Free" shipping method
        And I complete the shipping step
        And I choose "Offline" payment method
        And I confirm my order
        Then I should see the thank you page

    @api @ui @javascript
    Scenario: Placing an order using email with mixed case
        When I add product "PHP T-Shirt" to the cart
        And I complete addressing step with email "JOhn@example.COM" and "United States" based billing address
        And I select "Free" shipping method
        And I complete the shipping step
        And I choose "Offline" payment method
        And I confirm my order
        Then I should see the thank you page
