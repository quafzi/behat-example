Feature: weather indicator
    In order to get weather information
    As a user
    I want to get a human readable version of xml weather forcast

    Scenario:
        Given xml input "<some>strange</parsing error>"
        When I run my application
        Then I should get an exception with message "service currently not available"

    Scenario:
        Given xml input "<weather><cloud>0</cloud><temperature>-10</temperature><rain>0</rain></weather>"
        When I run my application
        Then I should get no exception
        And I should get a weather class instance

    Scenario Outline:
        Given value <cloud> for clouds
        When I call cloudiness
        Then I should get cloudiness <cloudiness>

        Examples:
            | cloud | cloudiness    |
            | 0     | bright        |
            | 20    | partly cloudy |
            | 50    | cloudy        |
            | 90    | clouded       |

    Scenario:
        Given value 20 for clouds
        And value 27 for temperature
        And value 0 for rain
        When I call summary
        Then I should get summary "a beautiful warm day"
