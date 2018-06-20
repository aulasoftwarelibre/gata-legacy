@idea
Feature: Registering as attendee in an idea
    In order to join me to an idea
    As a person interested in it
    I want to register as attendee in an idea

    @application
    Scenario: Registering as attendee in an idea
        Given I am logged in
        And there is a group named "Aula de Software Libre"
        And there is an idea titled "DDD introduction" in this group
        When I register me as attendee in this idea
        Then I have to be registered as attendee in this idea
