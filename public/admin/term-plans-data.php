<?php
// Simple JSON endpoint returning term plans as FullCalendar events
include('../../includes/database.php');

header('Content-Type: application/json; charset=utf-8');

$events = [];
$res = $conn->query("SELECT id, title, description, plan_date, end_date, event_type FROM term_plans");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        // map event types to colors
        $colorMap = [
            'exam' => '#ef4444', // red
            'holiday' => '#10b981', // green
            'meeting' => '#3b82f6', // blue
            'general' => '#8b5cf6' // purple
        ];
        $etype = $row['event_type'] ?? 'general';
        $events[] = [
            'id' => (int) $row['id'],
            'title' => $row['title'],
            'start' => $row['plan_date'],
            'end' => $row['end_date'] ?: $row['plan_date'],
            'allDay' => true,
            'bgColor' => $colorMap[$etype] ?? $colorMap['general'],
            'borderColor' => $colorMap[$etype] ?? $colorMap['general'],
            'color' => '#111827',
            'extendedProps' => [
                'description' => $row['description'],
                'event_type' => $etype
            ],
            'raw' => [
                'description' => $row['description'],
                'event_type' => $etype
            ]
        ];
    }
}

echo json_encode($events);
