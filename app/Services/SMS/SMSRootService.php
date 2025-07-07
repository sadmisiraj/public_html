<?php

namespace App\Services\SMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SMSRootService
{
    protected $client;
    protected $apiKey;
    protected $routeId;
    protected $senderId;
    protected $templateId;

    public function getConnection()
    {
        $this->apiKey = env('SMSROOT_API_KEY');
        $this->routeId = env('SMSROOT_ROUTE_ID', '13');
        $this->senderId = env('SMSROOT_SENDER_ID', '40885');
        $this->templateId = env('SMSROOT_TEMPLATE_ID', '8931');
        $this->client = new Client();
        return $this;
    }

    public function sendMessage($destination, $message)
    {
        try {
            $apiKey = $this->apiKey;
            $routeId = $this->routeId;
            $senderId = $this->senderId;
            $templateId = $this->templateId;
            
            // Format the phone number (remove country code if needed)
            $phone = preg_replace('/^\+?[0-9]{1,3}/', '', $destination);
            
            // Extract OTP code from the message
            // For TWO_FACTOR_AUTH template, the message format is: "Your authentication code is [[code]]."
            $otpCode = '';
            
            // Try to extract the code using pattern matching
            if (preg_match('/authentication code is (\d+)/', $message, $matches)) {
                $otpCode = $matches[1];
            } 
            // If that fails, try to extract any numeric code (4-6 digits)
            elseif (preg_match('/\b(\d{4,6})\b/', $message, $matches)) {
                $otpCode = $matches[1];
            }
            
            // For template-based SMS, we only need to send the variables
            // The template itself is stored on the SMS provider's side
            $queryParams = [
                'key' => $apiKey,
                'campaign' => '0',
                'routeid' => $routeId,
                'type' => 'text',
                'contacts' => $phone,
                'senderid' => $senderId,
                'template_id' => $templateId
            ];
            
            // Add the OTP code as a variable if we found it
            if (!empty($otpCode)) {
                $queryParams['var1'] = $otpCode;
            }
            
            $response = $this->client->request('GET', 'https://bulksms.smsroot.com/app/smsapi/index.php', [
                'query' => $queryParams
            ]);
            
            $responseBody = $response->getBody()->getContents();
            return ['success' => true, 'response' => $responseBody];
            
        } catch (GuzzleException $exception) {
            return ['error' => $exception->getMessage(), 'code' => $exception->getCode()];
        }
    }
} 