<?php
spl_autoload_register(function($className){
    require_once "$className.php";
});

class SalesOrder
{
    private string $status;
    private int $clientID;
    private int $productSKU;
    private int $locationID;
    private int $taxID;
    private int $discountID;
    private int $quantity;

    /**
     * @param string $status
     * @param int $clientID
     * @param int $productSKU
     * @param int $locationID
     * @param int $taxID
     * @param int $discountID
     */
    public function __construct(string $status, int $clientID, int $productSKU, int $locationID, int $taxID, int $discountID, int $quantity)
    {
        $this->status = $status;
        $this->clientID = $clientID;
        $this->productSKU = $productSKU;
        $this->locationID = $locationID;
        $this->taxID = $taxID;
        $this->discountID = $discountID;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getClientID(): int
    {
        return $this->clientID;
    }

    /**
     * @param int $clientID
     */
    public function setClientID(int $clientID): void
    {
        $this->clientID = $clientID;
    }

    /**
     * @return int
     */
    public function getProductSKU(): int
    {
        return $this->productSKU;
    }

    /**
     * @param int $productSKU
     */
    public function setProductSKU(int $productSKU): void
    {
        $this->productSKU = $productSKU;
    }

    /**
     * @return int
     */
    public function getLocationID(): int
    {
        return $this->locationID;
    }

    /**
     * @param int $locationID
     */
    public function setLocationID(int $locationID): void
    {
        $this->locationID = $locationID;
    }

    /**
     * @return int
     */
    public function getTaxID(): int
    {
        return $this->taxID;
    }

    /**
     * @param int $taxID
     */
    public function setTaxID(int $taxID): void
    {
        $this->taxID = $taxID;
    }

    /**
     * @return int
     */
    public function getDiscountID(): int
    {
        return $this->discountID;
    }

    /**
     * @param int $discountID
     */
    public function setDiscountID(int $discountID): void
    {
        $this->discountID = $discountID;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    // This method adds a SalesOrder to the account
    public function insertSalesOrder():string{
        $url = 'https://api.megaventory.com/v2017a/SalesOrder/SalesOrderUpdate';
        $ch = curl_init($url);

        $salesOrderDetails = array(
            'SalesOrderRowProductSKU' => $this->productSKU,
            'SalesOrderRowTaxID' => $this->taxID,
            'SalesOrderRowQuantity' => $this->quantity
        );

        $mvSalesOrder = array(
            'SalesOrderStatus' => $this->status,
            'SalesOrderClientID' => $this->clientID,
            'SalesOrderDetails' => $salesOrderDetails,
            'SalesOrderInventoryLocationID' => $this->locationID
        );

        $data = array(
            'APIKEY' => '57f1f1cb5e4a2713@m128185',
            'mvSalesOrder' => $mvSalesOrder,
            'mvRecordAction' => 'Insert'
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}