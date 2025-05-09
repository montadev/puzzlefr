@checkout
Feature: Seeing order addresses on order summary page
    In order to be certain about shipping and billing address
    As a Customer
    I want to be able to see addresses on the order summary page

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "Lannister Coat" priced at "$19.99"
        And the store ships everywhere for Free
        And the store allows paying with "Cash on Delivery"
        And I am a logged in customer

    @api @ui @javascript
    Scenario: Seeing the same shipping and billing address on order summary
        When I add product "Lannister Coat" to the cart
        And I specified the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I proceed with "Free" shipping method and "Cash on Delivery" payment
        And I should be on the checkout summary step
        And address to "Jon Snow" should be used for both shipping and billing of my order

    @api @ui @mink:chromedriver
    Scenario: Seeing different shipping and billing address on order summary
        When I add product "Lannister Coat" to the cart
        And I am at the checkout addressing step
        And I specify the billing address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Eddard Stark"
        And I specify the shipping address as "Ankh Morpork", "Frost Alley", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        And I proceed with "Free" shipping method and "Cash on Delivery" payment
        Then I should be on the checkout summary step
        And my order's shipping address should be to "Jon Snow"
        But my order's billing address should be to "Eddard Stark"
