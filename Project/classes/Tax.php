<?php

class Tax
{
    private string $name;
    private string $description;
    private float $value;

    /**
     * @param string $name
     * @param string $description
     * @param float $value
     */
    public function __construct(string $name, string $description, float $value)
    {
        $this->name = $name;
        $this->description = $description;
        $this->value = $value;
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
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        $url = 'https://api.megaventory.com/v2017a/Tax/TaxGet';
        $ch = curl_init($url);

        $filters = array(
            'FieldName' => 'TaxName',
            'SearchOperator' => 'Equals',
            'SearchValue' => $this->name
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
        return intval($client["mvTaxes"][0]["TaxID"]);
    }

    // This method adds a Tax to the account
    public function insertTax():string{
        $url = 'https://api.megaventory.com/v2017a/Tax/TaxUpdate';
        $ch = curl_init($url);

        $mvTax = array(
            'TaxName' => $this->name,
            'TaxDescription' => $this->description,
            'TaxValue' => $this->value
        );

        $data = array(
            'APIKEY' => '57f1f1cb5e4a2713@m128185',
            'mvTax' => $mvTax,
            'mvRecordAction' => 'Insert'
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}