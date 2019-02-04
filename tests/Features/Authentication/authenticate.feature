Feature: User authentication
  In order to use the application
  As a client
  I want to get an authentication token

  Scenario: Credentials are valid
    Given user with username "myUser@example.com" and password "myPassword100!"
    When I add "Content-Type" header equal to "application/json"
    And I send a "POST" request to "authenticate" with body:
    """
    {
      "email": "myUser@example.com",
      "password": "myPassword100!"
    }
    """
    Then the JSON should be valid according to this schema:
    """
    {
      "token": "string",
      "refresh_token": "string"
    }
    """
