Feature: Demonstrate the use of the Table Builder pattern

  Scenario: Show a large table
    Given that customer file contains:
      | Firstname | Lastname | Phone Number | Address          | Birthdate  |
      | John      | Doe      | +3360000000  | Some street name | 13/01/1989 |
      | Jane      | Smith    | +3361111111  | Another street   | 08/11/1988 |
    When I search for a customer named "Jane"
    Then I should get 1 result


  Scenario: Do the same test with only the relevant informations
    Given that customer file contains:
      | Firstname | Lastname |
      | John      | Doe      |
      | Jane      | Smith    |
    When I search for a customer named "Jane"
    Then I should get 1 result
