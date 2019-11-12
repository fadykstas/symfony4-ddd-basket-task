###TEST TASK: FRUIT BASKET API
####GENERAL DESCRIPTION
The purpose of the project is to implement a Fruit Basket API. It should contain "Basket" and "Item" entities. The **basket** has id, name, max capacity and contents properties. **Item** has the type and weight properties. Item type can be 'apple', 'orange' or 'watermelon' (in next version there will be more).
####REQUIRED FEATURES
- Add new basket. Name and max capacity is required, contents are prohibited.
- View list of existent baskets
- View basket name and contents
- Rename basket
- Remove basket with all contents
- Add the item to the basket (one or a few). If basket cannot fit all new items (based on their weights), need to return an error. It should return an error
- Remove item from basket

####NOTES
- API should adhere to the RESTful principles, according to your vision
- It should accept and respond with JSON
- All baskets are shared by all users. No authentication needed
- Storage must be in MySQL InnoDB, ensuring integrity of data. But we know, that in the next version we may want to switch to MongoDB/Redis (or another NoSQL storage). Migration of PHP code, in this case, should be as simple as possible
- You can use any libraries and frameworks



#### Lets make it work 

```bash
git clone https://github.com/fadykstas/symfony4-ddd-basket-task.git
cd symfony4-ddd-basket-task
composer install
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load 
php -S 127.0.0.1:9002 -t public

```

then visit `127.0.0.1:9002/api/doc`  you should see the documentation now.


#### Packages
- Symfony Flex
- Doctrine ORM Bundle
- Doctrine Fixtures
- Twig Bundle
- Nelmio Doc Bundle
- Symfony Profiler (dev)
- Framework Extra Bundle
