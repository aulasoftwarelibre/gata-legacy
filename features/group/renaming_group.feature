@group
Feature: Renaming a group
    In order to update a group name
    As an administrator
    I want to rename a group

    @application
    Scenario: Renaming a group
        Given there is a group named "Aula de software libre"
        When I rename it to "Aula de Software Libre"
        Then it should be renamed to "Aula de Software Libre"
