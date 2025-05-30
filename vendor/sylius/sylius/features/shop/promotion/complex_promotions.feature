@applying_promotion_rules
Feature: Receiving a discount based on a configured promotion
    In order to pay less for my order during a promotion period
    As a Customer
    I want to receive a discount for my purchase

    Background:
        Given the store operates on a single channel in "United States"
        And the store classifies its products as "Jackets", "Trousers", "Formal attire" and "Dresses"
        And the store has a product "Black Sabbath jacket" priced at "$100.00"
        And this product belongs to "Jackets"
        And the store has a product "Iron Maiden trousers" priced at "$80.00"
        And this product belongs to "Trousers"
        And the store has a product "Metallica dress" priced at "$50.00"
        And this product belongs to "Dresses"
        And the store has a product "Rammstein bow tie" priced at "$10.00"
        And this product belongs to "Formal attire"
        And I am a logged in customer

    @api @ui
    Scenario: Receiving a discount on the first order
        Given there is a promotion "First order promotion"
        And it gives "20%" off on the customer's 1st order
        And I added product "Metallica dress" to the cart
        When I check details of my cart
        Then my cart total should be "$40.00"
        And my discount should be "-$10.00"

    @api @ui
    Scenario: Receiving a discount on items and shipping from one promotion based on items total
        Given the store has "DHL" shipping method with "$10.00" fee
        And there is a promotion "Jackets and shipping discount"
        And it gives "$10.00" off on every product classified as "Jackets" and a free shipping to every order with items total equal at least "$500.00"
        And I added 7 products "Black Sabbath jacket" to the cart
        And I addressed the cart
        When I proceed with "DHL" shipping method
        Then theirs subtotal price should be decreased by "$70.00"
        And my cart total should be "$630.00"
        And my cart shipping total should be "$0.00"

    @api @ui
    Scenario: Receiving a discount on products from a specific taxon if an order contains products from an another taxon
        Given there is a promotion "Jacket-trousers pack"
        And it gives "10%" off on every product classified as "Jackets" if order contains any product classified as "Trousers"
        And I added products "Iron Maiden trousers" and "Black Sabbath jacket" to the cart
        When I check details of my cart
        Then product "Black Sabbath jacket" price should be discounted by "$10.00"
        And my cart total should be "$170.00"

    @api @ui
    Scenario: Receiving a discount on items and the whole order from one promotion based on items total
        Given there is a promotion "Greatest promotion"
        And it gives "20%" off on every product classified as "Jackets" and a "$50.00" discount to every order with items total equal at least "$500.00"
        And I added 7 products "Black Sabbath jacket" to the cart
        When I check details of my cart
        Then theirs subtotal price should be decreased by "$140.00"
        And my cart total should be "$510.00"
        And my discount should be "-$190.00"

    @api @ui
    Scenario: Receiving a discount on products from multiple taxons based on products from different taxons
        Given there is a promotion "Formal attire pack"
        And it gives "10%" off on every product classified as "Formal attire" or "Dresses" if order contains any product classified as "Trousers" or "Jackets"
        And I added products "Rammstein bow tie", "Metallica dress" and "Iron Maiden trousers" to the cart
        When I check details of my cart
        Then product "Metallica dress" price should be discounted by "$5.00"
        And product "Rammstein bow tie" price should be discounted by "$1.00"
        And my cart total should be "$134.00"

    @api @ui
    Scenario: Receiving a discount on products from a specific taxon together with fixed discount on order
        Given there is a promotion "Jacket-trousers pack"
        And it gives "10%" off on every product classified as "Jackets" and "$20.00" discount on every order
        And I added product "Iron Maiden trousers" to the cart
        And I added product "Black Sabbath jacket" to the cart
        When I check details of my cart
        Then product "Black Sabbath jacket" price should be discounted by "$10.00"
        And my discount should be "-$30.00"
        And my cart total should be "$150.00"
