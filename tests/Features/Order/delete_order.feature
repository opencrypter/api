Feature: Delete an order
  In order to cancel an order
  As a client
  I want to delete it

  Background:
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |
    And the order with id "6e7f1715-84c2-4dab-b690-969af78a063c" and the next steps:
      | position | type | exchangeId                             | symbol | value |
      | 1        | buy  | 6e7f1715-84c2-4dab-b690-969af78a063c   | BTCUSD | 1.54  |

  @login @logout
  Scenario: The order exists and has not been executed
    When I send a "DELETE" request to "v1/orders/6e7f1715-84c2-4dab-b690-969af78a063c"
    Then the response status code should be 204
    And the response should be empty
    And the order with id "6e7f1715-84c2-4dab-b690-969af78a063c" does not exist

  @login @logout
  Scenario: The order does not exist
    When I send a "DELETE" request to "v1/orders/ec308788-557b-46a1-916e-73ae14c7bdc8"
    Then the response status code should be 404
    And the response should be in JSON

