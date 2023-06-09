# CRM Shop Api
## REST Api hosted on MyDevil Server 
## https://crm-api.mydevillogin.usermd.net/

# Live preview with frontend
## https://crm-shop-client.vercel.app/

## Test accounts to login to application with certain role:
- Admin
  - email: admin@admin
  - password: admin123
- Employee
  - email: employee@employee
  - password: employee123
- Client
  - email: client@client
  - password: client123

## To test all the functionalities of the application, it is recommended to log in as admin

## Features:
- Authentication: Secure user registration and login using JWT (JSON Web Tokens) for stateless authentication 
- User Management: CRUD operations for managing users, roles, orders, and products 
- Data Validation: Automatic validation of incoming requests to ensure data integrity and consistency
- Error Handling: Consistent error responses with specific error messages and appropriate HTTP status codes
- Resourceful Routing: Well-defined routes and controllers following RESTful conventions for easy integration and usage
- Database Integration: Seamless integration with MySQL database hosted on MyDevil
- Query Parameters: Support for filtering, sorting, and pagination using query parameters to efficiently retrieve data
- Relations: Project uses one to many, many to one, and many to many relations
- Structure: Using controllers, repositories, and services which brings the following benefits:
  - separate the concerns of data access and business logic from the controllers and routes
  - make it easier to write unit tests for application
  - allow you to encapsulate common data access and business logic operations into reusable components
  - provide a flexible layer between your application and the underlying data storage
  - you can centralize your data access and business logic operations. This makes it easier to update or modify specific parts of your application without affecting other areas
  - enforce security measures at the data access layer
  - allow you to scale your application more effectively



