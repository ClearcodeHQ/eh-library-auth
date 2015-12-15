Feature: Registration
  In order to use the library
  As a user
  I must register

  Scenario: Registration of new reader
    When I register a reader with email john.doe@example.com
    Then the john.doe@example.com user should be registered library user

  Scenario: Registration of already existing user
    Given I registered a reader with email john.doe@example.com
    And I register a reader with email john.doe@example.com
    Then I should get an exception that user already exists