Feature: Register user
  In order to use the application
  As a client
  I want to create my user account

  Scenario: Identifier is free
    When I add "Content-Type" header equal to "application/json"
    And I send a "POST" request to "register" with body:
    """
    {
      "email": "myUser@example.com",
      "password": "myPassword101!"
    }
    """
    Then the response status code should be 201
    And the JSON should be equal to:
    """
    {
      "email": "myUser@example.com"
    }
    """

  Scenario: Identifier is already used
    Given I add "Content-Type" header equal to "application/json"
    And I send a "POST" request to "register" with body:
    """
    {
      "email": "myUser@example.com",
      "password": "myPassword101!"
    }
    """
    When I send a "POST" request to "register" with body:
    """
    {
      "email": "myUser@example.com",
      "password": "myPassword101!"
    }
    """
    Then the response status code should be 409
