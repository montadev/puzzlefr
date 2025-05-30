@applying_taxes
Feature: Apply correct taxes on visitor cart
    In order to buy goods with correct taxes applied
    As a Visitor
    I want to have correct taxes applied to my order

    Background:
        Given the store operates on a single channel in "United States"
        And there is a zone "The Rest of the World" containing all other countries
        And the store ships to "Austria"
        And the store ships everywhere for Free
        And default tax zone is "US"
        And the store has "RoW VAT" tax rate of 10% for "Clothes" for the rest of the world
        And the store has "US VAT" tax rate of 23% for "Clothes" within the "US" zone
        And the store has a product "PHP T-Shirt" priced at "$100.00"
        And it belongs to "Clothes" tax category

    @api @ui @javascript
    Scenario: Proper taxes for taxed product
        When I add product "PHP T-Shirt" to the cart
        Then my cart total should be "$123.00"
        And my cart taxes should be "$23.00"

    @api @ui @javascript
    Scenario: Proper taxes after specifying billing address
        When I add product "PHP T-Shirt" to the cart
        And I proceed as guest "john@example.com" with "Austria" as billing country
        Then my cart total should be "$110.00"
        And my cart taxes should be "$10.00"
