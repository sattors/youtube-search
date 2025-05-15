<?php

namespace Youtube\Search;

use Youtube\Enums\Type;
use Youtube\Settings;

class Video {
    private \GuzzleHttp\Client $client;

    public array $items = array();
    private int $offset = 0;
    private int $length = 10;

    private Settings $settings;

    public function __construct(Settings $settings) {
        $this->settings = $settings;
        $this->client = new \GuzzleHttp\Client();
    }

    public function Search(string $query, int $offset = 0, int $length = 10): static {
        $payload = [
            "context" => [
                "client" => [
                    "hl" => $this->settings->hl,
                    "gl" => $this->settings->gl,
                    "clientName" => $this->settings->clientName,
                    "clientVersion" => $this->settings->clientVersion
                ]
            ],
            "query" => $query,
            "param" => Type::VIDEO
        ];

        $response = $this->client->post("https://www.youtube.com/youtubei/v1/search", [
            "headers" => [
                "Content-Type" => "application/json",
                "Referer" => "https://www.youtube.com/",
                "User-Agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Safari/605.1.15"
            ],
            "body" => json_encode($payload)
        ]);

        $json = json_decode($response->getBody()->getContents(), true);

        foreach ($json["contents"]["twoColumnSearchResultsRenderer"]["primaryContents"]["sectionListRenderer"]["contents"] as $content) {
            if (isset($content["itemSectionRenderer"])) {
                foreach ($content["itemSectionRenderer"]["contents"] as $video) {
                    if (isset($video["videoRenderer"])) {
                        $this->items["videos"][] = [
                            "id" => $video["videoRenderer"]["videoId"],
                            "title" => $video["videoRenderer"]["title"]["runs"][0]["text"],
                            "thumbnails" => $video["videoRenderer"]["thumbnail"]["thumbnails"],
                            "author" => array(
                                "name" => $video["videoRenderer"]["shortBylineText"]["runs"][0]["text"],
                                "id" => $video["videoRenderer"]["shortBylineText"]["runs"][0]["navigationEndpoint"]["browseEndpoint"]["browseId"],
                            )
                        ];
                    }
                }
            }
        }

        $this->offset = $offset;
        $this->length = $length;
        return $this;
    }

    public function results(): array {
        return array_slice($this->items["videos"] ?? array(), $this->offset, $this->length);
    }
}
