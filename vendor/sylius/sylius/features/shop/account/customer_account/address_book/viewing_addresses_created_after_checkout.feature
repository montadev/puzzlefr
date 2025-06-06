@address_book
Feature: Viewing addresses created after checkout
    In order to see all my addresses
    As a Customer
    I want to be able to browse my address book

    Background:
        Given the store operates on a single channel in "United States"
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And the store ships everywhere for Free
        And the store allows paying Offline
        And I am a logged in customer
        And I have an address "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States", "Arkansas" in my address book
        And my default address is of "Lucifer Morningstar"

    @api @ui @javascript
    Scenario: Viewing address created after placing an order
        When I add product "PHP T-Shirt" to the cart
        And I am at the checkout addressing step
        And my billing address is fulfilled automatically through default address
        When I specify the first and last name as "Mike Ross" for billing address
        And I complete the addressing step
        And I proceed with "Free" shipping method and "Offline" payment
        And I confirm my order
        And I browse my address book
        Then I should have 2 addresses in my address book
