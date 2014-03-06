Feature: User
    Background:
        Given the database is clean

    Scenario: Register a user
        Given I go to "/register"
        When I fill in "fos_user_registration_form_username" with "symfonyvlc"
        And I fill in "fos_user_registration_form_email" with "symfonyvlc@gmail.com"
        And I fill in "fos_user_registration_form_plainPassword_first" with "ilovesymfony"
        And I fill in "fos_user_registration_form_plainPassword_second" with "ilovesymfony"
        And I press "Register"
        And show last response
        Then I should see "Logged in as symfony"

    Scenario: Register a user 2
        Given I go to "/register"
        When I fill in the following:
            | fos_user_registration_form_username | symfonyvlc |
            | fos_user_registration_form_email | symfonyvlc@gmail.com |
            | fos_user_registration_form_plainPassword_first | ilovesymfony |
            | fos_user_registration_form_plainPassword_second | ilovesymfony |
        And I press "Register"
        Then I should see "Logged in as symfony"
