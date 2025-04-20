@managing_administrators
Feature: Administrator validation
    In order to avoid making mistakes when managing administrators
    As an Administrator
    I want to be prevented from adding it without specifying required fields

    Background:
        Given I am logged in as an administrator

    @api @ui
    Scenario: Trying to add a new administrator without email and name
        When I want to create a new administrator
        And I do not specify its email
        And I do not specify its name
        And I try to add it
        Then I should be notified that the email is required
        And I should be notified that the name is required

    @api @ui
    Scenario: Trying to add a new administrator without password
        When I want to create a new administrator
        And I do not specify its password
        And I try to add it
        Then I should be notified that the password is required

    @api @ui
    Scenario: Trying to add a new administrator with invalid email
        When I want to create a new administrator
        And I specify its email as "Ted"
        And I try to add it
        Then I should be notified that this email is not valid

    @api @ui
    Scenario: Trying to add a new administrator with taken email
        Given there is an administrator "ted@example.com"
        When I want to create a new administrator
        And I specify its email as "ted@example.com"
        And I try to add it
        Then I should be notified that email must be unique
        And there should still be only one administrator with an email "ted@example.com"

    @api @ui
    Scenario: Trying to add a new administrator with taken name
        Given there is an administrator with name "Ted"
        When I want to create a new administrator
        And I specify its name as "Ted"
        And I try to add it
        Then I should be notified that name must be unique
        And there should still be only one administrator with name "Ted"

    @api @ui
    Scenario: Trying to add a new administrator with too long username specified
        When I want to create a new administrator
        And I specify its email as "l.skywalker@gmail.com"
        And I specify its "username" as too long string
        And I specify its password as "lightsaber"
        And I specify its locale as "English (United States)"
        And I try to add it
        Then I should be notified that this "username" is too long

    @api @ui
    Scenario: Trying to add a new administrator with too long first name specified
        When I want to create a new administrator
        And I specify its email as "l.skywalker@gmail.com"
        And I specify its name as "Luke"
        And I specify its password as "lightsaber"
        And I specify its locale as "English (United States)"
        And I specify its "first name" as too long string
        And I try to add it
        Then I should be notified that this "first name" is too long

    @api @ui
    Scenario: Trying to add a new administrator with too long last name specified
        When I want to create a new administrator
        And I specify its email as "l.skywalker@gmail.com"
        And I specify its name as "Luke"
        And I specify its password as "lightsaber"
        And I specify its locale as "English (United States)"
        And I specify its "last name" as too long string
        And I try to add it
        Then I should be notified that this "last name" is too long

    @api @no-ui
    Scenario: Trying to add a new administrator with wrong locale code specified
        When I want to create a new administrator
        And I specify its email as "l.skywalker@gmail.com"
        And I specify its name as "Luke"
        And I specify its password as "lightsaber"
        And I specify its locale as a wrong code
        And I try to add it
        Then I should be notified that this value is not valid locale
