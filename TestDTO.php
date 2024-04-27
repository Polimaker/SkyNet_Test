<?php

enum TarifType: int
{
    case Active = 0;
    case Archive = 1;
    case System = 2;
}


class TarifDTO {
    public function __construct(
        public string $name,
        public int $cost,
        public DateTime|string|int $exp_date,/*|Carbon */
        public string|int $speed,
        public TarifType $type
    ) 
    {
        if(is_numeric($exp_date))
            $this->exp_date = (new DateTime())->setTimestamp($exp_date);
        elseif(!$exp_date instanceof DateTime)
            $this->exp_date = (new DateTime())->setTimestamp(strtotime($exp_date));
    }

    public function toJson() {
        return json_encode([
            "name" => $this->name,
            "cost" => $this->cost,
            "exp_date" => $this->exp_date->getTimestamp(),
            "speed" => $this->speed,
            "type" => $this->type
        ], JSON_PRETTY_PRINT);
    }
}

print_r((new TarifDTO("Test 1", 100, "2017-03-03T09:06:41.187", 100, TarifType::Active))->toJson());
print_r((new TarifDTO("Test 2", 100, 1714216977, 100, TarifType::Archive))->toJson());
print_r((new TarifDTO("Test 3", 100, new DateTime(), 100, TarifType::System))->toJson());