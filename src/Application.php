<?php

namespace App;

use App\Cart\Item;
use App\Cart\ShoppingCart;
use App\Order\Order;
use App\Invoice\TextInvoice;
use App\Invoice\PDFInvoice;
use App\Customer\Customer;
use App\Payments\CashOnDelivery;
use App\Payments\CreditCardPayment;
use App\Payments\PaypalPayment;

class Application
{
    public static function run()
    {
        $akkopc75b = new Item('Akko', 'Akko PC75B' , 3799);
        $keyboard = new Item('KBD', 'Akko CS Silver' , 2000);

        $shopping_cart = new ShoppingCart();
        $shopping_cart->addItem($akkopc75b, 5);
        $shopping_cart->addItem($keyboard, 2);
        $customer = new Customer('Ryan Matthew', 'Manila', 'masanque.ryanmatthew@auf.edu.ph');
        $order = new Order($customer, $shopping_cart);

        $invoice = new PDFInvoice();
        $order->setInvoiceGenerator($invoice);
        $invoice->generate($order);

        $payment = new PaypalPayment('masanque.ryanmatthew@auf.edu.ph', 'ryanpassword');
        $order->setPaymentMethod($payment);
        $order->payInvoice();
    }
}