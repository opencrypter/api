Feature: Get all credentials
  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | d441d720-c6a2-4f3c-a0ab-0fb5395fe307  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |
    And the next credentials:
      | id                                    | name       | exchangeId                           | key       | secret      |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | My-cred    | d441d720-c6a2-4f3c-a0ab-0fb5395fe307 | my-key    | my-secret   |
      | a5c1b3e7-9855-4bcc-a036-ec317d46f67e  | My-cred-2  | d441d720-c6a2-4f3c-a0ab-0fb5395fe307 | my-key-2  | my-secret-2 |

  @login @logout
  Scenario: Credentials exist
    When I send a "GET" request to "v1/credentials"
    Then the response status code should be 200
    And the JSON should be equal to:
    """
    [
      {
        "id": "6e7f1715-84c2-4dab-b690-969af78a063c",
        "name": "My-cred",
        "exchangeId": "d441d720-c6a2-4f3c-a0ab-0fb5395fe307",
        "key": "my-key",
        "secret": "my-secret"
      },
      {
        "id": "a5c1b3e7-9855-4bcc-a036-ec317d46f67e",
        "name": "My-cred-2",
        "exchangeId": "d441d720-c6a2-4f3c-a0ab-0fb5395fe307",
        "key": "my-key-2",
        "secret": "my-secret-2"
      }
    ]
    """
