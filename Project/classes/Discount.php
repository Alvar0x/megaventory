<?php

class Discount
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
        $url = 'https://api.megaventory.com/v2017a/Discount/DiscountGet';
        $ch = curl_init($url);

        $filters = array(
            'FieldName' => 'DiscountName',
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
        return intval($client["mvDiscounts"][0]["DiscountID"]);
    }

    // This method adds a Discount to the account
    public function insertDiscount():string{
        $url = 'https://api.megaventory.com/v2017a/Discount/DiscountUpdate';
        $ch = curl_init($url);

        $mvDiscount = array(
            'DiscountName' => $this->name,
            'DiscountDescription' => $this->description,
            'DiscountValue' => $this->value
        );

        $data = array(
            'APIKEY' => '57f1f1cb5e4a2713@m128185',
            'mvDiscount' => $mvDiscount,
            'mvRecordAction' => 'Insert'
        );

        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }
}