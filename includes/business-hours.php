<?php
// Business hours configuration
$business_hours = [
    'monday' => ['open' => '08:00', 'close' => '17:00'],
    'tuesday' => ['open' => '08:00', 'close' => '17:00'],
    'wednesday' => ['open' => '08:00', 'close' => '17:00'],
    'thursday' => ['open' => '08:00', 'close' => '17:00'],
    'friday' => ['open' => '08:00', 'close' => '17:00'],
    'saturday' => ['open' => 'closed', 'close' => 'closed'],
    'sunday' => ['open' => 'closed', 'close' => 'closed']
];

function isBusinessOpen() {
    global $business_hours;
    
    // Get current time in South Africa timezone
    $current_time = new DateTime('now', new DateTimeZone('Africa/Johannesburg'));
    $current_day = strtolower($current_time->format('l'));
    $current_hour = $current_time->format('H:i');
    
    // Check if it's a business day
    if (!isset($business_hours[$current_day]) || $business_hours[$current_day]['open'] === 'closed') {
        return false;
    }
    
    // Convert times to comparable format
    $open_time = DateTime::createFromFormat('H:i', $business_hours[$current_day]['open']);
    $close_time = DateTime::createFromFormat('H:i', $business_hours[$current_day]['close']);
    $current = DateTime::createFromFormat('H:i', $current_hour);
    
    // Check if current time is within business hours
    return $current >= $open_time && $current <= $close_time;
}

function getBusinessHours() {
    global $business_hours;
    return $business_hours;
}

function getFormattedBusinessHours() {
    global $business_hours;
    
    // Check if weekday hours are consistent
    $weekday_hours = array_slice($business_hours, 0, 5); // Monday to Friday
    $first_day = reset($weekday_hours);
    $consistent_weekdays = true;
    
    foreach ($weekday_hours as $hours) {
        if ($hours['open'] !== $first_day['open'] || $hours['close'] !== $first_day['close']) {
            $consistent_weekdays = false;
            break;
        }
    }
    
    if ($consistent_weekdays) {
        return "Mon - Fri, {$first_day['open']} - {$first_day['close']}";
    } else {
        $formatted = '';
        $days = ['monday' => 'Mon', 'tuesday' => 'Tue', 'wednesday' => 'Wed', 
                'thursday' => 'Thu', 'friday' => 'Fri', 'saturday' => 'Sat', 
                'sunday' => 'Sun'];
                
        foreach ($business_hours as $day => $hours) {
            if ($hours['open'] !== 'closed') {
                $formatted .= "{$days[$day]}: {$hours['open']} - {$hours['close']}\n";
            }
        }
        return trim($formatted);
    }
}
?>
