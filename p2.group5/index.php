<?php
define('LIB_DIR', realpath('./'));
set_include_path(get_include_path() . PATH_SEPARATOR . LIB_DIR);
include_once 'lib/Cart.php';
include_once 'lib/Product/Food.php';
include_once 'lib/Persistance/Session.php';
$products = array();
$food1 = new Product_Food();
$food1->setName("Fig-eta bout it Burger");
$food1->setDescription("Don't be a clown. You like figs.");
$food1->setCost(7.95);
$products[] = $food1;

$food2 = new Product_Food();
$food2->setName("Tuna-mi Burger");
$food2->setDescription("It's a burger with tuna, like a tidal wave in your mouth.");
$food2->setCost(9.95);
$products[] = $food2;

$food3 = new Product_Food();
$food3->setName("New Bacon-ings Burger");
$food3->setDescription("Start fresh, with bacon.");
$food3->setCost(8.95);
$products[] = $food3;

$food4 = new Product_Food();
$food4->setName("Hit me with your best shallot Burger");
$food4->setDescription("Come on and hit me with your best shallot.");
$food4->setCost(8.95);
$products[] = $food4;

$food5 = new Product_Food();
$food5->setName("The Sound and the Curry Burger");
$food5->setDescription("This should be a very long and complex sentence with too many clauses.");
$food5->setCost(8.95);
$products[] = $food5;
// since products did not come from the database
// let's fake their id property, so they can be uniquely referenced
foreach ($products as $id => $product) {
    $product->id = $id;
}
// initialize shopping cart
// note that Cart implements Singleton pattern
$cart = Cart::getInstance();
// inject persistance object
// so our Cart can remember it's items
$cart->setPersistance(new Persistance_Session());
// add  tax to Cart
$cart->addTax('PDV', .096);
// process submitted form
if (isset($_POST) && ! empty($_POST)) {

    // adding to cart
    if (isset($_POST['add'])) {
        if (isset($_POST['product_check'])) {
            foreach ($_POST['product_check'] as $productId) {
                $selectedProduct = $products[$productId];
                $cart->add($selectedProduct);
            }
        }
    }

    // changing the cart contents
    if (isset($_POST['cart'])) {

        if (isset($_POST['empty'])) {
            $cart->removeAll();
        } elseif (isset($_POST['remove'])) { // removing the products
            if (isset($_POST['remove_product'])) {
                foreach ($_POST['remove_product'] as $k => $v) {
                    $cart->remove($v);
                }
            }
        }
    }
}
// include display template
include 'view/index.php';