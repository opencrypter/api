Feature: Save exchange credentials
  In order to delegate actions to the platform
  As a client
  I want to save my credentials

  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |

  @login @logout @test
  Scenario: Credentials are valid
    When I send a "PUT" request to "v1/credentials/d441d720-c6a2-4f3c-a0ab-0fb5395fe307" with body:
    """
    {
      "name": "my credentials",
      "exchangeId": "6e7f1715-84c2-4dab-b690-969af78a063c",
      "key": "exchange-key",
      "secret": "my-secret"
    }
    """
    Then the response should be empty
    And the response status code should be 204

  @login @logout
  Scenario: Bad request. Missing name
    When I send a "PUT" request to "v1/credentials/d441d720-c6a2-4f3c-a0ab-0fb5395fe307" with body:
    """
    {
      "exchangeId": "6e7f1715-84c2-4dab-b690-969af78a063c",
      "key": "exchange-key",
      "secret": "my-secret"
    }
    """
    Then the response should be in JSON
    And the response status code should be 400

  @login @logout
  Scenario: Bad request. Missing exchange id
    When I send a "PUT" request to "v1/credentials/d441d720-c6a2-4f3c-a0ab-0fb5395fe307" with body:
    """
    {
      "name": "my credentials",
      "key": "exchange-key",
      "secret": "my-secret"
    }
    """
    Then the response should be in JSON
    And the response status code should be 400

  @login @logout
  Scenario: Bad request. Missing key
    When I send a "PUT" request to "v1/credentials/d441d720-c6a2-4f3c-a0ab-0fb5395fe307" with body:
    """
    {
      "name": "my credentials",
      "exchangeId": "6e7f1715-84c2-4dab-b690-969af78a063c",
      "secret": "my-secret"
    }
    """
    Then the response should be in JSON
    And the response status code should be 400

  @login @logout
  Scenario: Bad request. Missing secret
    When I send a "PUT" request to "v1/credentials/d441d720-c6a2-4f3c-a0ab-0fb5395fe307" with body:
    """
    {
      "name": "my credentials",
      "exchangeId": "6e7f1715-84c2-4dab-b690-969af78a063c",
      "key": "exchange-key"
    }
    """
    Then the response should be in JSON
    And the response status code should be 400
