Feature:
  In order to know what exchanges are available
  As a client
  I want to see all of them

  Scenario: It returns all available exchanges
    Given 3 random exchanges in repository
    When I send a GET request to "/v1/exchanges"
    Then the response should be in JSON
    And the JSON should be valid according to this schema:
    """
    {
      "$schema": "http://json-schema.org/draft-07/schema",
      "type": "array",
      "minItems": 3,
      "maxItems": 3,
      "items": [
        {
          "type": "object",
          "additionalItems": false,
          "required": ["id", "name"],
          "properties": {
            "id":   { "type": "string", "pattern": "^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$" },
            "name": { "type": "string" }
          }
        }
      ]
    }
    """
