@checkout
Feature: Choosing an address from address book
    In order to quickly fill in my address information during checkout
    As a Customer
    I want to be able to choose it from my address book

    Background:
        Given the store operates on a single channel in "United States"
        And the store also has country "Australia"
        And this country has the "Queensland" province with "AU-QLD" code
        And this country also has the "Victoria" province with "AU-VIC" code
        And the store ships everywhere for Free
        And the store has a product "PHP T-Shirt" priced at "$19.99"
        And I am a logged in customer
        And I have an address "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States", "Arkansas" in my address book
        And I have an address "Fletcher Ren", "Upper Barkly Street", "3377", "Ararat", "Australia", "Victoria" in my address book

    @api @ui @javascript
    Scenario: Choosing billing address from address book
        When I add product "PHP T-Shirt" to the cart
        And I go to the checkout addressing step
        And I choose "Seaside Fwy" street for billing address
        Then address "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States", "Arkansas" should be filled as billing address

    @api @ui @javascript
    Scenario: Choosing shipping address from address book
        When I add product "PHP T-Shirt" to the cart
        And I go to the checkout addressing step
        And I choose "Seaside Fwy" street for shipping address
        Then address "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States", "Arkansas" should be filled as shipping address

    @api @ui @javascript
    Scenario: Choosing billing address which contains a country with provinces from my address book
        When I add product "PHP T-Shirt" to the cart
        And I go to the checkout addressing step
        And I choose "Upper Barkly Street" street for billing address
        Then address "Fletcher Ren", "Upper Barkly Street", "3377", "Ararat", "Australia", "Victoria" should be filled as billing address

    @api @ui @javascript
    Scenario: Choosing billing address from address book and proceed to the next step
        When I add product "PHP T-Shirt" to the cart
        And I go to the checkout addressing step
        And I choose "Seaside Fwy" street for billing address
        And I complete the addressing step
        Then I should be on the checkout shipping step
