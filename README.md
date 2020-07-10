[![N|Solid](https://www.carcool.pe/images/logo_carcool.png)](https://www.carcool.pe)
Repositorio de las Fuentes de la Entrevista de  Trabajo.

![N|Solid](https://laravel.com/assets/img/components/logo-laravel.svg)![N|Solid](https://vuejs.org/images/icons/apple-icon-57x57.png)
 ### Pasos
 1) Clonar el repositorio
 
        git clone https://github.com/fericell2909/Carcool.git
 2) Para Vue ubicarse en la raiz (appvue)  y ejecutar lo siguiente :
        
        npm install        
        
 3. compilacion en modo desarrollo
    ```
        npm run serve
    ```
 4. compilacion produccion 
    ```
    npm run build
    ```
5.  Personalizacion segun preferencia
Ver [Configuration Reference](https://cli.vuejs.org/config/).


6. Para Laravel ubicarse en la raiz (AppApiLaravel)  y ejecutar lo siguiente :
        
         composer install
    
7. Crear credenciales de acceso a bd , configurar el archivo .env con los
      datos de acceso a la bd y ejecutar el siguiente comando

            php artisan migrate


 8. Ejecute el comando : 

              php artisan passport:install   


 9. Ejecutar el comando.
          
            php artisan serve
    
10. Aqui puede ver la colleccion creada en postman   [Link](https://documenter.getpostman.com/view/6327993/T17Kd6ux) 
     
     

 11. En la Carpeta Utils se encuentra el archivo .json de la coleccion de postman. 


          
12. Las credenciales de acceso para los proyectos basados en laravel se deben guardar en el 
    archivo .env . Asi mismo esta llave para acceso debe estar encriptada.