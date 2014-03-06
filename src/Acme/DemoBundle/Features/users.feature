Feature: User
    
    Scenario: Register a user
        Given I go to "/register"
        When I fill in the following:
            | fos_user_registration_form_username | symfonyvlc |
            | fos_user_registration_form_email | symfonyvlc@gmail.com |
            | fos_user_registration_form_plainPassword_first | ilovesymfony |
            | fos_user_registration_form_plainPassword_second | ilovesymfony |
        And I press "Register"
        Then I should see "Logged in as symfony"
