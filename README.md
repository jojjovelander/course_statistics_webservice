![Overview Image](https://raw.githubusercontent.com/jojjovelander/course_statistics_webservice/develop/overview.png)

This Moodle webservice plugin processes GET requests which contain a valid one time token.  The OTP token is generated by the Moodle report plugin: https://github.com/jojjovelander/analytics_dashboard and is decypted in order to extract the user id and the token's TTL.  If the the TTL is exceed an empty JSON array is returned otherwise the user id is used to access the user data.  This plugin is read only.

Prior to deployment ensure that the OTP password is changed (and not committed) in both this project and analytics_dashboard, both passwords must match.

The plugin fetches user information from Moodle via direct SQL queries (escapeed according to the Moodle docs) and Moodle's own APIs.

Returned data is in JSON format.
