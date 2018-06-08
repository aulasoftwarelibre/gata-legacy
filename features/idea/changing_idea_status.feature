@idea
Feature: Changing idea status
    In order to determinate the available ideas
    As an administrator
    I want to be able to change the idea status

    @application
    Scenario: Marking an idea as accepted
        Given there is a group named "Aula de Software Libre"
        And there is an idea titled "DDD Introduction" in this group
        When I accept it
        Then it should be marked as accepted