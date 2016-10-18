<?php

return [
	'table' => 'oauth_identities',
	'providers' => [
		'facebook' => [
			'client_id' => env('FACEBOOK_CLIENT_ID'),
			'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
			'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
			'scope' => [],
		],
		'google' => [
			'client_id' => env('GOOGLE_CLIENT_ID'),
			'client_secret' => env('GOOGLE_CLIENT_SECRET'),
			'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
			'scope' => [],
		],
		'github' => [
			'client_id' => env('GITHUB_CLIENT_ID'),
			'client_secret' => env('GITHUB_CLIENT_SECRET'),
			'redirect_uri' => env('GITHUB_REDIRECT_URI'),
			'scope' => [],
		],
		'linkedin' => [
			'client_id' => '12345678',
			'client_secret' => 'y0ur53cr374ppk3y',
			'redirect_uri' => 'https://example.com/your/linkedin/redirect',
			'scope' => [],
		],
		'instagram' => [
			'client_id' => env('INSTAGRAM_CLIENT_ID'),
			'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
			'redirect_uri' => env('INSTAGRAM_REDIRECT_URI'),
			'scope' => [],
		],
		'soundcloud' => [
			'client_id' => '12345678',
			'client_secret' => 'y0ur53cr374ppk3y',
			'redirect_uri' => 'https://example.com/your/soundcloud/redirect',
			'scope' => [],
		],
	],
];
