<?php

class SpotifyService {
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $apiUrl = 'https://api.spotify.com/v1/';
    

    public function __construct($clientId, $clientSecret) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->authenticate();
    }

    private function authenticate() {
        $url = 'https://accounts.spotify.com/api/token';
        $headers = [
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            'Content-Type: application/x-www-form-urlencoded'
        ];
        $data = 'grant_type=client_credentials';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['access_token'])) {
            $this->accessToken = $result['access_token'];
        } else {
            throw new Exception('Authentication failed: ' . $response);
        }
    }

    public function search($query) {
        $url = $this->apiUrl . 'search?q=' . urlencode($query) . '&type=track';
        $headers = [
            'Authorization: Bearer ' . $this->accessToken
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    // Additional methods for other Spotify API interactions can be added here
}