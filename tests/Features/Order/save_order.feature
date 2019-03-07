Feature: Save an order
  In order execute one or more steps
  As a client
  I want to save an order

  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |

  @login @logout
  Scenario: The order is new
    When I send a "PUT" request to "v1/orders/d441d720-c6a2-4f3c-a0ab-0fb5395fe307" with body:
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
    Then the response should be empty
    And the response status code should be 204
    And the order with id "d441d720-c6a2-4f3c-a0ab-0fb5395fe307" equals to:
      | position | type       | exchangeId                            | symbol  | value  | dependsOf |
      | 1        | wait_price | 6e7f1715-84c2-4dab-b690-969af78a063c  | BTCUSD  | 4200   |           |
      | 2        | buy        | 6e7f1715-84c2-4dab-b690-969af78a063c  | BTCUSD  | 0.25   | 1         |

  @login @logout
  Scenario: The order already exists
    Given the order with id "21f33265-5426-4d62-a99e-1a78cc16ac29" and the next steps:
      | position | type | exchangeId                             | symbol | value |
      | 1        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |
    When I send a "PUT" request to "v1/orders/21f33265-5426-4d62-a99e-1a78cc16ac29" with body:
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
    Then the response should be empty
    And the response status code should be 204
    And the order with id "21f33265-5426-4d62-a99e-1a78cc16ac29" equals to:
      | position | type       | exchangeId                            | symbol  | value  | dependsOf |
      | 1        | wait_price | 6e7f1715-84c2-4dab-b690-969af78a063c  | BTCUSD  | 4200   |           |
      | 2        | buy        | 6e7f1715-84c2-4dab-b690-969af78a063c  | BTCUSD  | 0.25   | 1         |


  @login @logout
  Scenario: Bad request. Missing position
    When the order with id "21f33265-5426-4d62-a99e-1a78cc16ac29" and the next steps:
      | position | type | exchangeId                             | symbol | value | dependsOf |
      | 1        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |           |
      |          | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |           |
    Then the response should be in JSON
    And the response status code should be 400

  @login @logout
  Scenario: Bad request. Missing type
    When the order with id "21f33265-5426-4d62-a99e-1a78cc16ac29" and the next steps:
      | position | type | exchangeId                             | symbol | value | dependsOf |
      | 1        |      | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |           |
      | 2        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |           |
    Then the response should be in JSON
    And the response status code should be 400

  @login @logout
  Scenario: Bad request. Missing exchangeId
    When the order with id "21f33265-5426-4d62-a99e-1a78cc16ac29" and the next steps:
      | position | type | exchangeId                             | symbol | value | dependsOf |
      | 1        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |           |
      | 2        | buy  |                                        | BTCUSD | 1.54  |           |
    Then the response should be in JSON
    And the response status code should be 400

  @login @logout
  Scenario: Bad request. Missing symbol
    When the order with id "21f33265-5426-4d62-a99e-1a78cc16ac29" and the next steps:
      | position | type | exchangeId                             | symbol | value | dependsOf |
      | 1        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |           |
      | 2        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   |        | 1.54  |           |
    Then the response should be in JSON
    And the response status code should be 400

  @login @logout
  Scenario: Bad request. Missing value
    When the order with id "21f33265-5426-4d62-a99e-1a78cc16ac29" and the next steps:
      | position | type | exchangeId                             | symbol | value | dependsOf |
      | 1        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD |       |           |
      | 2        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |           |
    Then the response should be in JSON
    And the response status code should be 400
