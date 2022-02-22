<?php

if(isset($_REQUEST['Create'])) {
    require_once "classes/".$_REQUEST["Entity"].".php";

    switch($_REQUEST["Entity"]){
        case "Product":
            $product = new Product($_REQUEST["ProductSKU"], $_REQUEST["Description"], $_REQUEST["SalesPrice"], $_REQUEST["PurchasePrice"]);
            $product->insertProduct();
            break;
        case "Client":
            $client = new Client($_REQUEST["Name"], $_REQUEST["Email"], $_REQUEST["ShippingAddress"], $_REQUEST["Phone"]);
            $client->insertClient();
            break;
        case "InventoryLocation":
            $inventoryLocation = new InventoryLocation($_REQUEST["Abbreviation"], $_REQUEST["Name"], $_REQUEST["Address"]);
            $inventoryLocation->insertInventoryLocation();
            break;
        case "Tax":
            $tax = new Tax($_REQUEST["Name"], $_REQUEST["Description"], $_REQUEST["Value"]);
            $tax->insertTax();
            break;
        case "Discount":
            $discount = new Discount($_REQUEST["Name"], $_REQUEST["Description"], $_REQUEST["Value"]);
            $discount->insertDiscount();
            break;
        case "SalesOrder":
            /* In my case, I used these values to create a Sales Order with the entities I created before */
            /* Values: new SalesOrder('Verified', 8, 1112256, 3, 3, 4, 1) */
            $salesOrder = new SalesOrder($_REQUEST["Status"], $_REQUEST["ClientID"], $_REQUEST["ProductID"], $_REQUEST["LocationID"], $_REQUEST["TaxID"], $_REQUEST["DiscountID"], $_REQUEST["Quantity"]);
            $salesOrder->insertSalesOrder();
            break;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Entities</title>
</head>
<body>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <p>To create a sales order, you need to have created at least one of each entity</p>
        <select name="Entity" required>
            <option value="">Select entity ...</option>
            <option value="Product" <?= isset($_REQUEST["Entity"]) ? ($_REQUEST["Entity"] == "Product" ? "selected" : "") : "" ?>>Product</option>
            <option value="Client" <?= isset($_REQUEST["Entity"]) ? ($_REQUEST["Entity"] == "Client" ? "selected" : "") : "" ?>>Supplier Client</option>
            <option value="InventoryLocation" <?= isset($_REQUEST["Entity"]) ? ($_REQUEST["Entity"] == "InventoryLocation" ? "selected" : "") : "" ?>>Inventory Location</option>
            <option value="Tax" <?= isset($_REQUEST["Entity"]) ? ($_REQUEST["Entity"] == "Tax" ? "selected" : "") : "" ?>>Tax</option>
            <option value="Discount" <?= isset($_REQUEST["Entity"]) ? ($_REQUEST["Entity"] == "Discount" ? "selected" : "") : "" ?>>Discount</option>
            <option value="SalesOrder" <?= isset($_REQUEST["Entity"]) ? ($_REQUEST["Entity"] == "SalesOrder" ? "selected" : "") : "" ?>>Sales Order</option>
        </select>
        <input type="submit" name="Select" value="Select">
        <?php
        if(isset($_REQUEST["Select"])){
            echo "<h1>Create ".$_REQUEST["Entity"]."</h1>";
            switch($_REQUEST["Entity"]){
                case "Product":
                    echo "<input type='text' name='ProductSKU' placeholder='Product SKU' required>";
                    echo "<input type='text' name='Description' placeholder='Description' required>";
                    echo "<input type='text' name='SalesPrice' placeholder='Sales price' required>";
                    echo "<input type='text' name='PurchasePrice' placeholder='Purchase price' required>";
                    break;
                case "Client":
                    echo "<input type='text' name='Name' placeholder='Name' required>";
                    echo "<input type='text' name='Email' placeholder='Email' required>";
                    echo "<input type='text' name='ShippingAddress' placeholder='Shipping address' required>";
                    echo "<input type='text' name='Phone' placeholder='Phone' required>";
                    break;
                case "InventoryLocation":
                    echo "<input type='text' name='Abbreviation' placeholder='Abbreviation' required>";
                    echo "<input type='text' name='Name' placeholder='Name' required>";
                    echo "<input type='text' name='Address' placeholder='Address' required>";
                    break;
                case "Tax":
                case "Discount":
                    echo "<input type='text' name='Name' placeholder='Name' required>";
                    echo "<input type='text' name='Description' placeholder='Description' required>";
                    echo "<input type='text' name='Value' placeholder='Value' required>";
                    break;
                case "SalesOrder":
                    echo "<input type='text' name='Status' placeholder='Status' required>";
                    echo "<input type='number' name='ClientID' placeholder='Client ID' required>";
                    echo "<input type='number' name='ProductID' placeholder='Product ID' required>";
                    echo "<input type='number' name='LocationID' placeholder='Location ID' required>";
                    echo "<input type='number' name='TaxID' placeholder='Tax ID' required>";
                    echo "<input type='number' name='DiscountID' placeholder='Discount ID' required>";
                    echo "<input type='number' name='Quantity' placeholder='Quantity' required>";
                    break;
            }
            echo "<input type='hidden' name='Entity' value='".$_REQUEST["Entity"]."'>";
            echo "<input type='submit' name='Create' value='Create'>";
        }
        ?>
    </form>
</body>
</html>
