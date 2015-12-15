Feature: Authentication
  In order to use the library
  As a user
  I must authenticate myself using JWT

  Scenario: Authentication using valid JWT
    Given I generated a token for john.doe@example.com
    When I authenticate using the token
    Then authentication is successful

  Scenario: Authentication using tampered JWT
    # this is token generated for john.doe@example.com but with changed payload (email changed to marco.polo@example.com)
    When I authenticate using the eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjIzNWE3NGVlLTMxZWMtNDE0Ni1iMzU5LTQ4MzVjYmUyMzc1MiJ9.eyJqdGkiOiIyMzVhNzRlZS0zMWVjLTQxNDYtYjM1OS00ODM1Y2JlMjM3NTIiLCJpYXQiOjE0NTAxODM4NDksImV4cCI6MTQ1MDE4NzQ0OSwiZW1haWwiOiJtYXJjby5wb2xvQGV4YW1wbGUuY29tIn0.QFbh27z7jKcC06kjV02Smp8JPPlpuo3G857SPbCiBBA token
    Then invalid signature exception is thrown

  Scenario: Authentication using invalid JWT
    When I authenticate using the ABCDEFG token
    Then unrecognized token exception should be thrown
