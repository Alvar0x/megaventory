<?php

class InventoryLocation
{
    private string $abbreviation;
    private string $name;
    private string $address;

    /**
     * @param string $abbreviation
     * @param string $name
     * @param string $address
     */
    public function __construct(string $abbreviation, string $name, string $address)
    {
        $this->abbreviation = $abbreviation;
        $this->name = $name;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation(string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
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
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        $url = 'https://api.megaventory.com/v2017a/SupplierClient/SupplierClientGet';
        $ch = curl_init($url);

        $filters = array(
            'FieldName' => 'InventoryLocationAbbreviation',
            'SearchOperator' => 'Equals',
            'SearchValue' => $this->abbreviation
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
        return intval($client["mvInventoryLocations"][0]["InventoryLocationID"]);
    }

    // This method adds a InventoryLocation to the account
    public function insertInventoryLocation():string{
        $url = 'https://api.megaventory.com/v2017a/InventoryLocation/InventoryLocationUpdate';
        $ch = curl_init($url);

        $mvInventoryLocation = array(
            'InventoryLocationName' => $this->name,
            'InventoryLocationAbbreviation' => $this->abbreviation,
            'InventoryLocationAddress' => $this->address
        );

        $data = array(
            'APIKEY' => '57f1f1cb5e4a2713@m128185',
            'mvInventoryLocation' => $mvInventoryLocation,
            'mvRecordAction' => 'Insert'
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}