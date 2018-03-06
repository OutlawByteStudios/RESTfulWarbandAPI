# API calls

Replace _API_VERSION_ with the preferred api version\

***

### _API_VERSION_/ping [GET]
```
Check basic functionallity
```
| Parameter | Description | Example | Required | Type |
| ------ | ------ | ------ | ------ | ------ |
| - |
>Responses
>HTTP:200 {"message" => "Pong. API is reachable", "status" => "success"}
\
***
\
### _API_VERSION_/version [GET]
```
Returns the api version
```
| Parameter | Description | Example | Required | Type |
| ------ | ------ | ------ | ------ | ------ |
| - |
>Responses
>HTTP:200 {"message" => "API Version x", "status" => "success"}
\
***
\
### _API_VERSION_/handshake [GET]
```
Shake hands with the server
```
| Parameter | Description | Example | Required | Type |
| ------ | ------ | ------ | ------ | ------ |
| - |
>Responses  
>HTTP:200 {"message" => "Hello ..., you must be new", "status" => "success"}  
>HTTP:200 {"message" => "Hello ..., welcome back", "status" => "success"}
\
### _API_VERSION_/washhands [POST]
\
```
Washhands: remove any human identifyable client data like ip etc.
```
| Parameter | Description | Example | Required | Type |
| ------ | ------ | ------ | ------ | ------ |
| uid | the client uid | auth1234abcdef | yes | Request Body |
>Responses  
>HTTP:200 {"message" => "you are not a shadow of your former self", "status" => "success"}  
