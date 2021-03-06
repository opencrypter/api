Feature: Get an order
  In order see the detail of an order
  As a client
  I want to get the order

  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |
    And the order with id "6e7f1715-84c2-4dab-b690-969af78a063c" and the next steps:
      | position | type | exchangeId                             | symbol | value |
      | 1        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |

  @login @logout
  Scenario: The order exists
    When I send a "GET" request to "v1/orders/6e7f1715-84c2-4dab-b690-969af78a063c"
    Then the response should be in JSON
    And the JSON should be equal to:
    """
    {
      "id": "6e7f1715-84c2-4dab-b690-969af78a063c",
      "steps": [
          {
              "position": 1,
              "type": "buy",
              "exchangeId": "6e7f1715-84c2-4dab-b690-969af78a063c",
              "symbol": "BTCUSD",
              "value": 1.54,
              "dependsOf": null
          }
      ]
    }

    """
    And the response status code should be 200

  @login @logout
  Scenario: The order does not exist
    When I send a "GET" request to "v1/orders/ec308788-557b-46a1-916e-73ae14c7bdc8"
    Then the response should be in JSON
    And the response status code should be 404

