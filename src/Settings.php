<?php

namespace Youtube;

class Settings {
    public string $hl = "en";
    public string $gl = "US";
    public string $clientVersion = "2.20250515.01.00";
    public string $clientName = "WEB";
    
    public function __construct(array|null $settings) {
        foreach ($settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
