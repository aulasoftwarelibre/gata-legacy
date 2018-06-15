@idea
Feature: Retitling an idea
    In order to update an idea title
    As the idea owner
    I want to retitle an idea

    @application
    Scenario: Retitling an idea
        Given there is a group named "Aula de Software Libre"
        And there is an idea titled "DDD introduction" in this group
        When I retitle it to "DDD Introduction"
        Then it should be retitled to "DDD Introduction"
