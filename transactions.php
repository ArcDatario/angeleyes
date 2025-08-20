<?php
$apiKey = "xnd_development_4D5fF5YYez3z4EG01BPr4wriMZjkGfy9gitazM6IccEwEbSfl6bv1dhTcF6Aha";
$url = "https://api.xendit.co/transactions?limit=10";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":");
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Xendit Transactions</title>
  <style>
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
    th { background-color: #f4f4f4; }
  </style>
</head>
<body>
  <h2>Xendit Transactions</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Type</th>
      <th>Status</th>
      <th>Channel</th>
      <th>Channel</th>
      <th>Amount</th>
     
      <th>Currency</th>
      <th>Created</th>
     
    </tr>
    <?php if (!empty($data['data'])): ?>
      <?php foreach ($data['data'] as $txn): ?>
        <tr>
          <td><?= htmlspecialchars($txn['reference_id']) ?></td>
          <td><?= htmlspecialchars($txn['type']) ?></td>
          <td><?= htmlspecialchars($txn['status']) ?></td>
          <td><?= htmlspecialchars($txn['channel_category']) ?></td>
<td><?= htmlspecialchars($txn['channel_code']) ?></td>

          <td><?= number_format($txn['amount'], 2) ?></td>
         
          <td><?= htmlspecialchars($txn['currency']) ?></td>
          <td><?php
            $created = $txn['created'] ?? '';
            $formatted = '-';
            if (!empty($created)) {
              // Try to parse the timestamp and convert to Asia/Manila (GMT+8)
              try {
                // Let DateTime parse the input (it should handle ISO 8601 with Z)
                $dt = new DateTime($created);
                $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                $formatted = $dt->format('d M Y, h:i A');
              } catch (Exception $e) {
                // Fallback: try strtotime then create a DateTime from timestamp
                $ts = strtotime($created);
                if ($ts !== false) {
                  $dt = new DateTime('@' . $ts); // UTC
                  $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                  $formatted = $dt->format('d M Y, h:i A');
                } else {
                  // As last resort, output the raw string
                  $formatted = $created;
                }
              }
            }
            echo htmlspecialchars($formatted);
          ?></td>
          
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="9">No transactions found</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
