@checkout
Feature: Placing an order on multiple channels with same currency
    In order to be sure how much should I pay for my cart
    As an Administrator
    I want user to place orders in channel’s base currency

    Background:
        Given the store operates on a channel named "Mobile" in "USD" currency
        And the store operates on another channel named "Web" in "USD" currency
        And the store ships to "United States"
        And the store has a zone "United States" with code "US"
        And this zone has the "United States" country member
        And the store ships everywhere for free for all channels
        And the store allows paying Offline for all channels
        And the store has a product "PHP T-Shirt" priced at "$12.54" available in channel "Web" and channel "Mobile"
        And there is an administrator "sylius@example.com" identified by "sylius"
        And there is a customer account "customer@example.com" identified by "sylius"
        And I am logged in as "customer@example.com"

    @api @ui
    Scenario: Placing an order in a channels base currency
        Given I changed my current channel to "Web"
        And I added product "PHP T-Shirt" to the cart
        And I addressed the cart
        When I proceeded with "Free" shipping method and "Offline" payment method
        And I confirm my order
        Then the administrator should see that order placed by "customer@example.com" has "USD" currency

    @api @ui
    Scenario: Placing an order on a different channel with same currency
        Given I changed my current channel to "Mobile"
        And I added product "PHP T-Shirt" to the cart
        And I addressed the cart
        When I proceed with "Free" shipping method and "Offline" payment
        And I confirm my order
        Then the administrator should see that order placed by "customer@example.com" has "USD" currency
