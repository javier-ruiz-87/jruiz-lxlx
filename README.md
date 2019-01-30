# jruiz-lxlx
Gestor de pedidos Symfony 4 y PHP 7.2. con API Rest

- Productos, Tiendas, Pedidos y Shoppers.
- CRUD Web.
- APIs
- SQLite database
  - data/app.db para las APIs 
  - data/test.db3 para los tests 

#### APIs
- localhost:8000/api/producto/add
- localhost:8000/api/tienda/add
- localhost:8000/api/pedido/add
- localhost:8000/api/shopper/add

Sin acabar:
localhost:8000/api/shopper/dispatch-pedido


#### TESTS:
 ```
$ ./bin/phpunit
 ```
OK (21 tests, 35 assertions)


Changelog:

- Entidades
- CRUD básico
- APIs funcionales
- Tests

TODO:
- API shopper y pedido devuelve productos
- APIS mejorar faltan varios validadores, control de errores
- Tests resto
- Revisar todo
- Añadir peso a los productos para sumarlo al pedido
- restar la cantidad del pedido a las unidades del producto

