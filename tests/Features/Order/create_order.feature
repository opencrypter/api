Feature: Create an order
  In order place an order in one of my exchanges
  As a client
  I want to create an order

  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |

  @login @logout
  Scenario: The order is new
    When I send a "PUT" request to "v1/orders/cede5a4e-2584-465a-8641-13c3dc169c17" with body:
    """
    {
      "steps": [
          {
            "position": 1,
            "type": "wait_price",
            "exchangeId": "6e7f1715-84c2-4dab-b690-969af78a063c",
            "symbol": "BTCUSD",
            "value": 4200
          },
          {
            "position": 2,
            "type": "buy",
            "exchangeId": "6e7f1715-84c2-4dab-b690-969af78a063c",
            "symbol": "BTCUSD",
            "value": 0.25,
            "dependsOf": 1
          }
       ]
    }
    """
    Then the response should be in JSON
    And the response status code should be 201
    And the order with id "cede5a4e-2584-465a-8641-13c3dc169c17" exists in the repository

