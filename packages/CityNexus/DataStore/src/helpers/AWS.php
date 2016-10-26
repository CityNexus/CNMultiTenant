<?php
/**
 * Created by PhpStorm.
 * User: sean
 * Date: 10/25/16
 * Time: 5:02 PM
 */

namespace CityNexus\DataStore;


class AWS
{

    public function getS3Details($s3Bucket, $region, $acl = 'private') {

        // Options and Settings
        $awsKey = (!empty(config('datastore.S3_key')) ? config('datastore.S3_key') : S3_KEY);
        $awsSecret = (!empty(config('datastore.S3_secret')) ? config('datastore.S3_secret') : S3_SECRET);

        $algorithm = "AWS4-HMAC-SHA256";
        $service = "s3";
        $date = gmdate("Ymd\THis\Z");
        $shortDate = gmdate("Ymd");
        $requestType = "aws4_request";
        $expires = "86400"; // 24 Hours
        $successStatus = "201";
        $url = "//{$s3Bucket}.{$service}-{$region}.amazonaws.com";

        // Step 1: Generate the Scope
        $scope = [
            $awsKey,
            $shortDate,
            $region,
            $service,
            $requestType
        ];
        $credentials = implode('/', $scope);

        // Step 2: Making a Base64 Policy
        $policy = [
            'expiration' => gmdate('Y-m-d\TG:i:s\Z', strtotime('+2 hours')),
            'conditions' => [
                ['bucket' => $s3Bucket],
                ['acl' => $acl],
                ['starts-with', '$key', ''],
                ['starts-with', '$Content-Type', ''],
                ['success_action_status' => $successStatus],
                ['x-amz-credential' => $credentials],
                ['x-amz-algorithm' => $algorithm],
                ['x-amz-date' => $date],
                ['x-amz-expires' => $expires],
            ]
        ];

        $base64Policy = base64_encode(json_encode($policy));

        // Step 3: Signing your Request (Making a Signature)
        $dateKey = hash_hmac('sha256', $shortDate, 'AWS4' . $awsSecret, true);
        $dateRegionKey = hash_hmac('sha256', $region, $dateKey, true);
        $dateRegionServiceKey = hash_hmac('sha256', $service, $dateRegionKey, true);
        $signingKey = hash_hmac('sha256', $requestType, $dateRegionServiceKey, true);

        $signature = hash_hmac('sha256', $base64Policy, $signingKey);

        // Step 4: Build form inputs
        // This is the data that will get sent with the form to S3
        $inputs = [
            'Content-Type' => '',
            'acl' => $acl,
            'success_action_status' => $successStatus,
            'policy' => $base64Policy,
            'X-amz-credential' => $credentials,
            'X-amz-algorithm' => $algorithm,
            'X-amz-date' => $date,
            'X-amz-expires' => $expires,
            'X-amz-signature' => $signature
        ];

        return compact('url', 'inputs');
    }
}