# iot_smart_backend
Backend app for [IOT Smart farming](https://github.com/YohannesTz/iot_smartfarm_reporting) made using PHP.
## Installation  
```bash
git clone https://github.com/YohannesTz/iot_smart_backend.git
```
### Configuring database
go to connection.php and connect your database
```php
//Connecting to database
$host = ""; //your host
$username = ""; //your username
$password = ""; //password
$dbname = ""; //database name

// Create a mysqli instance
$conn = new mysqli($host, $username, $password, $dbname);
```
### Endpoints<br><br>
| Endpoint  | Request Type  | Body/Param | Response |
|---------------|-------------|-----------------------|-----------------|
| /sendData.php | POST              |(xxx-url-formencoded) [hardwareId, temp,humidity, pumpstatus]| status, message |
| /signUp.php | POST |     (xxx-url-formencoded) [email, password, hardwareId]           |     status, message            |
| /sendFeedback.php  |  POST   | (xxx-url-formencoded) [userId,phoneNumber, feedback] |   status, message          |        
| /getLatestData.php | GET     | (query) [password,hardwareId,isEnc,isRand,mode]     |  status, data  |
| /signIn.php   | POST      | (xxx-url-formencoded) [email, password]        | status, user      |
| /getFeedback.php/feedback | POST     |             |  status, [feedback]              |
| /signInAdmin.php| POST | (xxx-url-formencoded) [email, password] | status, message | 
