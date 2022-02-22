<?php

class Client
{
    private string $name;
    private string $email;
    private string $shippingAddress;
    private string $phone;

    /**
     * @param string $name
     * @param string $email
     * @param string $shippingAddress
     * @param string $phone
     */
    public function __construct(string $name, string $email, string $shippingAddress, string $phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->shippingAddress = $shippingAddress;
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getShippingAddress(): string
    {
        return $this->shippingAddress;
    }

    /**
     * @param string $shippingAddress
     */
    public function setShippingAddress(string $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        $url = 'https://api.megaventory.com/v2017a/SupplierClient/SupplierClientGet';
        $ch = curl_init($url);

        $filters = array(
            'FieldName' => 'SupplierClientEmail',
            'SearchOperator' => 'Equals',
            'SearchValue' => $this->email
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
        return intval($client["mvSupplierClients"][0]["SupplierClientID"]);
    }

    // This method adds a Client to the account
    public function insertClient():string{
        $url = 'https://api.megaventory.com/v2017a/SupplierClient/SupplierClientUpdate';
        $ch = curl_init($url);

        $mvSupplierClient = array(
            'SupplierClientName' => $this->name,
            'SupplierClientEmail' => $this->email,
            'SupplierClientShippingAddress1' => $this->shippingAddress,
            'SupplierClientPhone1' => $this->phone
        );

        $data = array(
            'APIKEY' => '57f1f1cb5e4a2713@m128185',
            'mvSupplierClient' => $mvSupplierClient,
            'mvRecordAction' => 'Insert'
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}