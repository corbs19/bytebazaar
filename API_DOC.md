Overview:


API (Application Programming Interface) is a collection of rules and protocols that allow one software application to interact with another. Connecting various software systems and facilitating them smooth collaboration are some of the goals of APIs. It alsoenables programmers to reuse pre-existing functionality rather than creating it from the ground up.


Endpoint Descriptions:
URL: http://localhost/shopping%20cart/restapi.php

HTTP Method: GET

Required Parameters:


Path: http://localhost/shopping%20cart/restapi.php/{id}

  
Example Request:

   {
        "name": "Razer BlackWidow V4 X",
        "price": "(input price)"
      
    }
Example Response:

   {
        "id": 1,
        "name": "Razer BlackWidow V4 X",
        "price": "129"
    }

  
Error Handling:
-	404 not found
-	400 Bad Request
