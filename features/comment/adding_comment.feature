@comment
Feature: Adding a comment
    In order to participate in an idea
    As a person interested in it
    I want to be able to add a comment

    @application
    Scenario: Adding a comment
        Given I am logged in
        And there is a group named "Aula de Software Libre"
        And there is an idea titled "DDD Introduction" in this group
        When I add the next comment
            """
            Great idea. I can help to organize it if you need.
            """
        Then the comment should be available in this idea


