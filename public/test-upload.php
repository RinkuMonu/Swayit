<?php
// temp_tiktok_auth.php
$clientKey = 'awtc5x18cejuewkz'; // Directly paste it here
$redirectUri = 'https://new.swayit.com/auth/tiktok/callback'; // Directly paste it here
$scopes = 'user.info.basic,video.upload,aweme.share,tiktok.share.creator';

$authUrl = "https://www.tiktok.com/v2/auth/authorize/" .
           "?client_key={$clientKey}" .
           "&redirect_uri=" . urlencode($redirectUri) .
           "&scope={$scopes}" .
           "&response_type=code" .
           "&state=" . bin2hex(random_bytes(16));

echo "Generated TikTok Auth URL: <br>";
echo "<a href=\"" . htmlspecialchars($authUrl) . "\">Click to Connect to TikTok</a>";
?>
