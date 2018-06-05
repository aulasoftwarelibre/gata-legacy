@idea
Feature: Adding an idea
    In order to propose an idea to a group
    As a group member
    I want to add an idea to a group

    @application
    Scenario: Adding a new idea
        Given there is a group named "Aula de Software Libre"
        When I add a new idea titled "DDD Introduction" with any description to this group
        Then the idea "DDD Introduction" should be available in this group
