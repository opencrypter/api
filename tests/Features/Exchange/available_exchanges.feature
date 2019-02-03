Feature: Get available exchanges
  In order to know what exchanges are available
  As a client
  I want to see all of them

  @login @logout
  Scenario: There are multiple exchanges in the repository.
    Given the following exchanges:
      | id                                    | name      | symbols               |
      | 6e7f1715-84c2-4dab-b690-969af78a063c  | Bitstamp  | ["BTCUSD", "ETHUSD"]  |
      | ad91b45d-a06e-4779-9a5a-0328c1bbce88  | Binance   | ["XRPUSD", "XEMUSD"]  |
    When I send a GET request to "v1/exchanges"
    Then the response should be in JSON
    And the response status code should be 200
    And the JSON should be equal to:
    """
    [
      {
        "id": "6e7f1715-84c2-4dab-b690-969af78a063c",
        "name": "Bitstamp",
        "symbols": [
          "BTCUSD",
          "ETHUSD"
        ]
      },
      {
        "id": "ad91b45d-a06e-4779-9a5a-0328c1bbce88",
        "name": "Binance",
        "symbols": [
          "XEMUSD",
          "XRPUSD"
        ]
      }
    ]
    """

