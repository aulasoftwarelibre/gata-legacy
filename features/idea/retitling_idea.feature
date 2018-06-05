@idea
Feature: Retitling an idea
    In order to update an idea title
    As the idea owner
    I want to retitle an idea

    @application
    Scenario: Retitling an idea
        Given there is an idea titled "DDD introduction" with any description in any group
        When I retitle it to "DDD Introduction"
        Then it should be retitled to "DDD Introduction"
