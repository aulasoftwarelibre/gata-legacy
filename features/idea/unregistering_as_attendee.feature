@idea
Feature: Unregistering as attendee from an idea
    In order to unjoin me from an idea
    As an idea attendee
    I want to unregister as attendee from an idea

    @application
    Scenario: Unregistering as attendee from an idea
        Given I am logged in
        And there is a group named "Aula de Software Libre"
        And there is an idea titled "DDD introduction" in this group
        And I am registered as attendee in this idea
        When I unregister me as attendee from this idea
        Then I have to be unregistered as attendee in this idea
