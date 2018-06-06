@idea
Feature: Redescribing an idea
    In order to update an idea description
    As the idea owner
    I want to redescribe an idea

    @application
    Scenario: Retitling an idea
        Given there is an idea with any title and "DDD introduction" as description in any group
        When I redescribe it to "DDD Introduction"
        Then it should be redescribed to "DDD Introduction"