@group
Feature: Adding a group
    In order to let groups to propose ideas
    As an administrator
    I want to add a group to list

    @application
    Scenario: Adding a new group
        When I add a new group called "Aula de Software Libre"
        Then the group "Aula de Software Libre" should be available in the list
