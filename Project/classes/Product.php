<?php

class Product
{
    private string $sku;
    private string $description;
    private float $salesPrice;
    private float $purchasePrice;

    /**
     * @param string $sku
     * @param string $description
     * @param float $salesPrice
     * @param float $purchasePrice
     */
    public function __construct(string $sku, string $description, float $salesPrice, float $purchasePrice)
    {
        $this->sku = $sku;
        $this->description = $description;
        $this->salesPrice = $salesPrice;
        $this->purchasePrice = $purchasePrice;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getSalesPrice(): float
    {
        return $this->salesPrice;
    }

    /**
     * @param float $salesPrice
     */
    public function setSalesPrice(float $salesPrice): void
    {
        $this->salesPrice = $salesPrice;
    }

    /**
     * @return float
     */
    public function getPurchasePrice(): float
    {
        return $this->purchasePrice;
    }

    /**
     * @param float $purchasePrice
     */
    public function setPurchasePrice(float $purchasePrice): void
    {
        $this->purchasePrice = $purchasePrice;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        $url = 'https://api.megaventory.com/v2017a/Product/ProductGet';
        $ch = curl_init($url);

        $filters = array(
            'FieldName' => 'ProductSKU',
            'SearchOperator' => 'Equals',
            'SearchValue' => $this->sku
        );

        $data = array(
            'APIKEY' => '57f1f1cb5e4a2713@m128185',
            'Filters' => $filters,
            'ReturnTopNRecords' => '1'
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $client = curl_exec($ch);
        return intval($client["mvProducts"][0]["ProductID"]);
    }

    // This method adds a Product to the account
    public function insertProduct():string{
        $url = 'https://api.megaventory.com/v2017a/Product/ProductUpdate';
        $ch = curl_init($url);

        $mvProduct = array(
            'ProductSKU' => $this->sku,
            'ProductDescription' => $this->description,
            'ProductSellingPrice' => $this->salesPrice,
            'ProductPurchasePrice' => $this->purchasePrice
        );

        $data = array(
            'APIKEY' => '57f1f1cb5e4a2713@m128185',
            'mvProduct' => $mvProduct,
            'mvRecordAction' => 'Insert'
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}