# API calls

Replace _API_VERSION_ with the preferred api version

***

### _API_VERSION_/ping
```
Check basic functionallity
```
| Parameter | Description | Example | Required | Type |
| ------ | ------ | ------ | ------ | ------ |
| - |
>Responses
>HTTP:200 {"message" => "Pong. API is reachable", "status" => "success"}

***

### _API_VERSION_/version
```
Returns the api version
```
| Parameter | Description | Example | Required | Type |
| ------ | ------ | ------ | ------ | ------ |
| - |
>Responses
>HTTP:200 {"message" => "API Version x", "status" => "success"}

***

### _API_VERSION_/handshake
```
Shake hands with the server
```
| Parameter | Description | Example | Required | Type |
| ------ | ------ | ------ | ------ | ------ |
| - |
>Responses  
>HTTP:200 {"message" => "Hello ..., you must be new", "status" => "success"}  
>HTTP:200 {"message" => "Hello ..., welcome back", "status" => "success"}
