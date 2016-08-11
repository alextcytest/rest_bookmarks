# API

## Bookmarks

### Get latest bookmarks
  * GET request **/api/bookmarks**
  * response JSON 
  ```javascript
  [{"id":1, "url":"http://someurl.com", "create_at":"2016-08-10 16:03:15", "comments":[]}, ...]
  ```

### Get bookmark by url 
  * GET request **/api/bookmark/{url}** (please escape URL string):
  * response JSON 
    ```javascript
    {"id":1, "url":"http://someurl.com", "create_at":"2016-08-10 16:03:15", "comments":[]}
    ``` 
  
### Create bookmark 
  * POST request **/api/bookmark**    
  * specify raw json data
      ```javascript
      {"url":"http://your_url.com"}
      ``` 
   
## Comments

### Create comment
  * POST request **/api/bookmarks/{bookmark_id}/comment**
  * specify raw json data
    ```javascript
    {"text":"my comment text"}
    ```
  * response JSON 
    ```javascript
    {"id":1}
    ```
  * return HTTP code: 200
      
### Update comment
  * PUT request **/api/comments/{id}**  
  * specify raw json data
    ```javascript
    {"text":"my updated comment text"}
    ```
  * return HTTP code: 202  

### Delete comment
  * DELETE request **/api/comments/{id}** 
  * return HTTP code: 204 

