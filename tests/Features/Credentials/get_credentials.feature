Feature: Get credentials detail
  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | d441d720-c6a2-4f3c-a0ab-0fb5395fe307  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |
    And the next credentials:
      | id                                    | name     | exchangeId                           | key     | secret    |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | My-cred  | d441d720-c6a2-4f3c-a0ab-0fb5395fe307 | my-key  | my-secret |

  @login @logout
  Scenario: Credentials exist
    When I send a "GET" request to "v1/credentials/6e7f1715-84c2-4dab-b690-969af78a063c"
    Then the response status code should be 200
    And the JSON should be equal to:
    """
    {
      "id": "6e7f1715-84c2-4dab-b690-969af78a063c",
      "name": "My-cred",
      "exchangeId": "d441d720-c6a2-4f3c-a0ab-0fb5395fe307",
      "key": "my-key",
      "secret": "my-secret"
    }
    """

  @login @logout
  Scenario: Missing credentials
    When I send a "GET" request to "v1/credentials/d441d720-c6a2-4f3c-a0ab-0fb5395fe307"
    Then the response should be in JSON
    And the response status code should be 404

