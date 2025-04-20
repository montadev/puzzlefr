@managing_customers
Feature: Filtering customers by firstname, lastname and email
    In order to quickly find customers
    As an Administrator
    I want to search for a specific customer

    Background:
        Given there is a customer "Frodo Baggins" with an email "f.baggins@shire.me"
        And there is a customer "Ghastly Bespoke" with an email "g.bespoke@example.com"
        And there is a customer "Lirael Abhorsen" with an email "l.abhorsen@example.me"
        And I am logged in as an administrator

    @api @ui
    Scenario: Searching customers by email
        When I want to see all customers in store
        And I search by "e.me" email
        Then I should see 2 customers on the list
        And I should see the customer "f.baggins@shire.me" on the list
        And I should see the customer "l.abhorsen@example.me" on the list

    @api @ui
    Scenario: Filtering customers by firstname
        When I want to see all customers in store
        And I search by "Lirael" first name
        Then I should see a single customer on the list
        And I should see the customer "l.abhorsen@example.me" on the list

    @api @ui
    Scenario: Filtering customers by lastname
        When I want to see all customers in store
        And I search by "Bespoke" last name
        Then I should see a single customer on the list
        And I should see the customer "g.bespoke@example.com" on the list
