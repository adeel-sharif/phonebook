**Title**
----
 
* **URL**

  <_The URL Structure (path only, no root url)_>

* **Method:**
  
  <_The request type_>

  `GET` | `POST` | `DELETE` | `PUT`


  * **admin login url**

  api/admin/login

   * **Client login url**

  api/client/login


  * **Success Response Both api:**
  
  

  * **Code:** 200 <br />
    **Content:** `{ token : $token }`
  
*  **admin dashboard url**

    /api/admin/dashboard


    *  **admin client url**

    /api/client/dashboard

   



* **Success Response:**
  
  

  * **Code:** 200 <br />
    **Content:** `{ day : number of contact,week:number of contact store current week,month:number of contact store current month }`
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{ error : "Log in" }`

    *  **admin client crud url**

     *  **api/admin/clients method get**
     *  **api/admin/client method post**
     *  **api/admin/client/{id} method get**
     *  **api/admin/client/{id} method put**


    *  **admin contact crud url**

     *  **api/admin/contacts method get**
     *  **api/admin/contact method post**
     *  **api/admin/contact/{id} method get**
     *  **api/admin/contact/{id} method put**
     *  **api/admin/contact/{id} method DELETE**



    *  **admin contact crud url**

     *  **api/admin/contacts method get**
     *  **api/admin/contact method post**
     *  **api/admin/contact/{id} method get**
     *  **api/admin/contact/{id} method put**
     *  **api/admin/contact/{id} method DELETE**

