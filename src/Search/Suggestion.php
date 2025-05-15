<?php 

namespace Youtube\Search;

use Youtube\Settings;

class Suggestion {
    private \GuzzleHttp\Client $client;
    private array $sugs = array();

    private Settings $settings;

    public function __construct(Settings $settings) {
        $this->settings = $settings;
        $this->client = new \GuzzleHttp\Client();
    }

    public function Search(string $query): static {
        $request = $this->client->get("https://suggestqueries-clients6.youtube.com/complete/search", array(
            "query" => array(
                "ds" => "yt",
                "client" => "youtube",
                "gs_ri" => "youtube",
                "hl" => $this->settings->hl,
                "q" => $query
            )
        ));

        $response = $request->getBody()->getContents();
        $json = json_decode(substr($response, strpos($response, '(') + 1, -1), true);
        $suggestions = array_column($json[1], 0);

        $this->sugs = $suggestions;
        return $this;
    }

    public function results(): array {
        return $this->sugs;
    }
}