Feature: Get the detail of an exchange
  In order to know all details about an exchange
  As a client
  I want to see the data of a specific exchange

  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |
      | ad91b45d-a06e-4779-9a5a-0328c1bbce88  | Binance   | ["XRPUSD", "XEMUSD"]  |

  @login @logout
  Scenario: The exchange exists in the database
    When I send a "GET" request to "v1/exchanges/6e7f1715-84c2-4dab-b690-969af78a063c"
    Then the response should be in JSON
    And the response status code should be 200
    And the JSON should be equal to:
    """
    {
      "id": "6e7f1715-84c2-4dab-b690-969af78a063c",
      "name": "Bitstamp",
      "symbols": [
        "BTCUSD",
        "ETHUSD"
      ]
    }
    """

  @login @logout
  Scenario: The exchange does not exist
    When I send a "GET" request to "v1/exchanges/6e7f1715-1111-1111-1111-969af78a063c"
    Then the response should be in JSON
    And the response status code should be 404
    And the JSON should be equal to:
    """
    {
      "message": "Exchange with id 6e7f1715-1111-1111-1111-969af78a063c not found"
    }
    """
